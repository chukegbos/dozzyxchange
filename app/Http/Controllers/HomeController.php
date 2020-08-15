<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Account;
use App\User;
use App\Bank;
use App\Withdraw;
use App\AirtimeTransaction;

class HomeController extends Controller

{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->is_admin==1) {
            $users = User::where('deleted_at', NULL)->count();
            $withdraws = Withdraw::where('deleted_at', NULL)->where('status', NULL)->count();
            $transactions = AirtimeTransaction::where('deleted_at', NULL)->where('status', 'pending')->where('pop', '!=', NULL)->count();
            return view('admin.index', compact('users', 'withdraws', 'transactions'));
        }
        return view('dashboard');
      
    }

    public function settings()
    {   
        $userss = User::where('deleted_at', NULL)->where('is_admin', 1)->get();
        return view('setting', compact('userss'));
    }

    public function services()
    {
        return view('services');
    }

    public function account()
    {
        $accounts = Account::where('accounts.deleted_at', NULL)
            ->join('users', 'accounts.user_id', '=', 'users.id')
            ->orderBy('accounts.created_at', 'Desc')
            ->get();
        return view('accounts', compact('accounts'));
    }

    public function users()
    {
        $users = User::where('deleted_at', NULL)->where('is_admin', NULL)->get();
        return view('users', compact('users'));
    }

    public function searchaccount($id)
    {
        $banks = Bank::get();
        $user = User::find($id);
        if ($user) {
            return view('viewuser', compact('user', 'banks'));
        }
        return redirect()->back()->withErrors(['No account found!!!']);
    }

    public function adminchangepassword(Request $request)
    {
        $user = User::find($request->id);
        $user->password = bcrypt($request->get('password'));
        $user->update();
        return redirect()->back()->with('success', 'Password changed!');
    }

    public function deleteuser($id)
    {
        user::destroy($id);
        return redirect()->back()->with('success', 'User deleted!');
    }

    public function withdraw()
    {
        $withdraws = Withdraw::where('withdraws.deleted_at', NULL)
            ->join('users', 'withdraws.user_id', '=', 'users.id')
            ->select(
                'users.first_name as first_name',
                'users.last_name as last_name',
                'withdraws.id as id',
                'withdraws.amount as amount',
                'withdraws.status as status',
                'withdraws.created_at as created_at'
            )
            ->latest()
            ->get();
        return view('withdraw', compact('withdraws'));
    }

    public function showwithdraw($id)
    {
        $withdraw = Withdraw::find($id);
        $withdraw->status = 'Paid';
        $withdraw->update();

        $account = new Account();
        $account->user_id = $withdraw->user_id;
        $account->txid = rand(1, 98888);
        $account->type = 'dedit';
        $account->amount = $withdraw->amount;
        $account->purpose = 'Payment to domicidary account';
        $account->save();

        $user = User::where('deleted_at', NULL)->find($withdraw->user_id);
        $user->balance = $user->balance - $withdraw->amount;
        $user->update();


        return redirect()->back()->with('success', 'Successfully approved!');
    }
}

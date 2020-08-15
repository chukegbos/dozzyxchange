<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Account;
use App\Airtime;
use App\Crypto;
use App\Bank;
use App\Withdraw;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Auth;
use Mail;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('api');
    }


    public function getUser(Request $request)
    {
        return auth('api')->user(); 
    }

    public function bank()
    {
        return Bank::where('deleted_at', NULL)->get(); 
    }

    public function getrates()
    {
        $params = [];
        $params['crypto'] = Crypto::where('deleted_at', NULL)->get();
        $params['network'] = Airtime::where('deleted_at', NULL)->get();
        return $params;
    }

    public function account()
    {
        return Account::where('deleted_at', NULL)->where('user_id', auth('api')->user()->id)->paginate(10); 
    }

    public function withdraw()
    {
        return Withdraw::where('deleted_at', NULL)->where('status', NULL)->where('user_id', auth('api')->user()->id)->first(); 
    }

    public function storewithdraw(Request $request)
    {
        
        $validate = $this->validate($request, [
            'amount' => 'required',
        ]);

        if ($request->amount>auth('api')->user()->balance) {
            return response()->json(['error' => 'You do not have upto that amount!'], 400);
        }

        $withdraw = new Withdraw();
        $withdraw->user_id = auth('api')->user()->id;
        $withdraw->amount = $request->amount;
        $withdraw->save();

        return ['message' => "Success"];
    }

    public function fetchbank(Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.paystack.co/bank/resolve?account_number='.$request->bank_account.'&bank_code='.$request->bank_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
              "Authorization: Bearer sk_test_2b3f7792faa550ac09dd009b1788b89f3286c3a4",
              "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } 
        else {
            return $response;
        }
    }


    public function payback(Request $request)
    {
        $url = "https://api.paystack.co/transfer";

        $fields = [
            "source" => "balance", 
            "reason" => "Calm down", 
            "amount" => 3794800, 
            "recipient" => "CUS_x9nikbnabej5srm"
        ];

        $fields_string = http_build_query($fields);

        //open connection

        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer sk_test_2b3f7792faa550ac09dd009b1788b89f3286c3a4",
            "Cache-Control: no-cache",
        ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        //execute post

        $result = curl_exec($ch);

        return $result;
    }


    public function UpdateUser(Request $request, $id)
    {
        $user = User::where('deleted_at', NULL)->find(auth('api')->user()->id);

        if ($request->first_name) {
            $this->validate($request, [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:25',
            ]);

            $user->update([
                'first_name' => ucwords($request->first_name),
                'last_name' => ucwords($request->last_name),
                'username' => $request->username,
                'phone' => $request->phone,
                'setup' => 1,
            ]);
        }

        if ($request->acc_number) {
            $user->update([
                'acc_number' => $request->acc_number,
                'acc_name' => $request->acc_name,
                'bank_name' => $request->bank_name,
            ]);
        }
        return ['message' => "Success"];
    }

    public function password(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6',
        ]);

        $user = User::where('deleted_at', NULL)->find(auth('api')->user()->id);

        if (!(Hash::check($request->get('current_password'), $user->password))) {
            $error = "Your current password does not matches with the password you provided. Please try again.";
            return ['error' => $error];
        }
        
        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            $error = "New Password cannot be same as your current password. Please choose a different password.";
            return ['error' => $error];
           
        }

        if(!strcmp($request->get('new_password'), $request->get('password_confirmation')) == 0){
            $error = "The new password confirmation does not match.";
            return ['error' => $error];   
        }
        
        $user->update([
            'password' => Hash::make($request->get('new_password')),
        ]); 

        return ['message' => 'Success'];
    }


    protected function resend()
    {
        $data = array('confirmation_code'=> auth('api')->user()->confirmation_code);
        Mail::send('emails.verify', $data, function($message) {
            $message
                ->to(auth('api')->user()->email, auth('api')->user()->username)
                ->subject('Verify your email address');
        });
        
        return $data;
    }
}

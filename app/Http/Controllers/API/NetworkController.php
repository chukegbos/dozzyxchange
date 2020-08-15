<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Airtime;
use App\AirtimeTransaction;
use App\Line;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;

class NetworkController extends Controller
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

    public function index()
    {
        return Airtime::where('deleted_at', NULL)->get();
    }

    public function show($id)
    {
        $params = [];
        $params['airtime'] = Airtime::where('deleted_at', NULL)->find($id);
        $params['line'] = Line::where('deleted_at', NULL)->where('airtime_id', $params['airtime']->id)->inRandomOrder()->first();
        return $params;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|string|max:25',
            'sender_phone' => 'required|string|max:20',
        ]);


        $ref_id = rand(2,9988777);
        $transaction = new AirtimeTransaction;
        $request->merge(['ref_id' => $ref_id]);
        $transaction->create($request->all());
        return $ref_id;
    }

    public function invoice($ref_id)
    {
        return AirtimeTransaction::where('airtime_transactions.deleted_at', NULL)
            ->where('airtime_transactions.ref_id', $ref_id)
            ->join('airtimes', 'airtime_transactions.network_id', '=', 'airtimes.id')
            ->first();
    }

    public function postinvoice(Request $request)
    {
        $airtime = AirtimeTransaction::where('deleted_at', NULL)->where('ref_id', $request->ref_id)->first();
       
        if ($request->pop) {
            $name = time().'.' . explode('/', explode(':', substr($request->pop, 0, strpos($request->pop, ';')))[1])[1];
            //\Image::make($request->pop)->save('/home2/dozzyxch/public_html/storage/pop/'.$name);
            \Image::make($request->pop)->save(public_path('storage/pop/').$name);
            $request->merge(['pop' => $name]);
        }
        $airtime->update($request->all());
        return ['message' => "Success"];
    }

    public function transaction_airtime()
    {
        return AirtimeTransaction::where('airtime_transactions.deleted_at', NULL)
            ->where('airtime_transactions.user_id', auth('api')->user()->id)
            ->join('airtimes', 'airtime_transactions.network_id', '=', 'airtimes.id')
            ->paginate(10);
    }

    public function delete_airtime($ref_id)
    {
        $airtime = AirtimeTransaction::where('ref_id', $ref_id)->first();
        return AirtimeTransaction::destroy($airtime->id);
    }
}

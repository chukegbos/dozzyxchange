<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Crypto;
use App\CryptoTransaction;
use App\Btc;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;

class CryptoController extends Controller
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
        return Crypto::where('deleted_at', NULL)->get();
    }

    public function show($id)
    {
        $params = [];

        $api_key = 'afy8CUjxIGa3RrFArynEEoNqQ1GRk6jS7I1YIha31pc';
        $url = 'https://www.blockonomics.co/api/new_address';

        $options = array( 
            'http' => array(
                'header'  => 'Authorization: Bearer '.$api_key,
                'method'  => 'POST',
                'content' => '',
                'ignore_errors' => true
            )   
        );  

        $context = stream_context_create($options);
        $contents = file_get_contents($url, false, $context);
        $object = json_decode($contents);

        // Check if address was generated successfully
        if (isset($object->address)) {
            $params['address'] = $object->address;
        } else {
          // Show any possible errors
          return $http_response_header[0]."\n".$contents;
        }

        
        $params['btc'] = Btc::where('deleted_at', NULL)->where('crypto_id', $id)->inRandomOrder()->first();
        return $params;     
    }

    public function postcrypto(Request $request)
    {
        $crypto = new CryptoTransaction();
        $request->merge(['status' => 0]);
        $request->merge(['user_id' => auth('api')->user()->id]);
        $crypto->create($request->all());
        return ['message' => "Success"];
    }

    public function transaction_crypto()
    {
        return CryptoTransaction::where('crypto_transactions.deleted_at', NULL)
            ->where('crypto_transactions.user_id', auth('api')->user()->id)
            ->orderBy('crypto_transactions.created_at', 'Desc')
            ->join('cryptos', 'crypto_transactions.crypto_id', '=', 'cryptos.id')
            ->paginate(10);
    }

    public function delete_crypto($ref_id)
    {
        $airtime = CryptoTransaction::where('ref_id', $ref_id)->first();
        return CryptoTransaction::destroy($airtime->id);
    }
}

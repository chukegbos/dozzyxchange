<?php

namespace App\Http\Controllers;

use App\Crypto;
use Illuminate\Http\Request;
use App\Btc;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;


class BtcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'address' => 'required|string|max:250',
            'image' => 'mimes:png,jpeg,jpg',
        ]);

        if ($request->file('image')) {
            $file = $request->file('image');
            $image = Storage::disk('public')->putFile('barcode', $file);
        } 
        else
        {
            $image = NULL;
        }

        Btc::create([
            'address' => $request['address'],
            'image' => $image,
            'crypto_id' => $request['crypto_id'],
        ]);

        $status = 'Address added successfuly';
        //return redirect()->route('leave')->withErrors(['You have left the class']);
        return redirect()->back()->with('success', $status );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Btc  $btc
     * @return \Illuminate\Http\Response
     */
    public function show(Btc $btc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Btc  $btc
     * @return \Illuminate\Http\Response
     */
    public function edit(Btc $btc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Btc  $btc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'address' => 'required|string|max:250',
            'image' => 'mimes:png,jpeg,jpg',
        ]);

        $btc = Btc::where('deleted_at', NULL)->find($id);
        if ($request->file('image')) {
            $file = $request->file('image');
            $image = Storage::disk('public')->putFile('barcode', $file);
        } 
        else
        {
            $image = $btc->image;
        }

        $btc->update([
            'address' => $request['address'],
            'image' => $image,
        ]);

        $status = 'Address updated successfuly';
        //return redirect()->route('leave')->withErrors(['You have left the class']);
        return redirect()->back()->with('success', $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Crypto  $crypto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Btc::destroy($id);
        return redirect()->back()->with('success', 'Address deleted!');
    }
}

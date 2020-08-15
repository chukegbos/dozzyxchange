<?php

namespace App\Http\Controllers;

use App\Airtime;
use Illuminate\Http\Request;
use App\Line;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class LineController extends Controller
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
            'number' => 'required|string|max:250',
        ]);


        Line::create([
            'number' => $request['number'],
            'airtime_id' => $request['airtime_id'],
        ]);

        $status = 'Number added successfuly';
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
            'number' => 'required|string|max:250',
        ]);

        $line = Line::where('deleted_at', NULL)->find($id);

        $line->update([
            'number' => $request['number'],
        ]);

        $status = 'Number updated successfuly';
        //return redirect()->route('leave')->withErrors(['You have left the class']);
        return redirect()->back()->with('success', $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\airtime  $airtime
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Line::destroy($id);
        return redirect()->back()->with('success', 'Number deleted!');
    }
}

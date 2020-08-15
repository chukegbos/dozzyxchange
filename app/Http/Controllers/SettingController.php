<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Setting;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use DB;

class SettingController extends Controller
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
        $userss = User::where('deleted_at', NULL)->where('is_admin', 1)->get();
        return view('setting', compact('userss'));
    }

    public function passwordget()
    {   
        $error = request('passworderror'); 
        return view('admin.password', compact('error'));
    }

    public function password(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->withErrors(['Your current password does not matches with the password you provided. Please try again.']);
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            return redirect()->back()->withErrors(['New Password cannot be same as your current password. Please choose a different password.']);
        }
 
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with('success', 'Password changed successfully.');  
    }

    /**

    
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    public function create_admin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|max:191|email|unique:users',
            'password' => 'required|string|min:8',
        ]);
        
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'is_admin' => 1,
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->back()->with('success', 'Admin successful created!');
    }
    
    public function update_admin(Request $request, $id)
    {
        
        $this->validate($request, [
            'password' => 'required|string|min:8',
        ]);
        $user = User::find($id);

        $password = ($request['password']) ?  Hash::make($request['password']) : $user->password ;
        $user->update([
            'password' => $password,
        ]);

        return redirect()->back()->with('success', 'Admin successful updated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);
        if ($request->sitename) {
            $this->validate($request, [
                'sitename' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);
        }
        $setting->update($request->all());
        return redirect()->back()->with('success', 'Setting successful updated!');
    }

    public function logoupdate(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:8048'
        ]);

        $file = $request->file('logo');
        $path = Storage::disk('public')->putFile('logo', $file);

        $setting->update([
            'logo' => $path,
        ]);
        return redirect()->back()->with('success', 'Logo successful updated!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'Admin deleted!');
    }
}

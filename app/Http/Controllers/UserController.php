<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $userList = User::get();
        //echo '<pre>';print_r($userList);die;
        return view('user.index', ['userList' => $userList]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => ['required', 'string']
        ]);
        //return $request;
  
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address
        ]);
   
        return redirect()->route('user.index')
                        ->with('success','User created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $userInfo = User::find($id);
        // echo '<pre>';print_r($userInfo);die;
        return view('user.edit',['user' => $userInfo]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string']
        ]);
  
        DB::table('users')
            ->where('id', $id)
            ->update(['name' => $request->name, 'email' => $request->email, 'address' => $request->address]);
  
        return redirect()->route('user.index')
                        ->with('success','User updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $message = '';
        if($request->lock){
            DB::table('users')
                ->where('id', $id)
                ->update(['status' => 0]);
            $message = $request->lock . 'ed';
        }else{
            DB::table('users')
                ->where('id', $id)
                ->update(['status' => 1]);
            $message = $request->unlock . 'ed';
        }
  
        return redirect()->route('user.index')
                        ->with('success',"User $message successfully");
    }
}

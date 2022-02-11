<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        $userList = User::orderBy('id','DESC')->paginate(5);
        //echo '<pre>';print_r($userList);die;
        return view('user.index', ['userList' => $userList]);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('user.create', ['roles' => $roles]);
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
  
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address
        ]);
        $user->assignRole($request->input('roles'));

        Http::post('localhost:3000/registeruser', ["username"=>$request->name]);
   
        return redirect()->route('user.index')
                        ->with('success','User created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        // echo '<pre>';print_r($userInfo);die;
        return view('user.edit',['user' => $user, 'roles' => $roles, 'userRole' => $userRole]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'address' => ['required', 'string'],
            'roles' => ['required']
        ]);

        $input = $request->all();
        $user = User::find($id);
        $user->update($input);

        // return $user;

        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        // Http::post('localhost:3000/registeruser', ["username"=>$user->name]);
  
        return redirect()->route('user.index')
                        ->with('success','User updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $message = '';
        if($request->lock){
            $user = User::find($id);
            $user->update(['status' => 0, 'write_permission' => 0]);
            // return $user;
            $res = Http::post('localhost:3000/registeruser', ["username"=>"appUser"]);
            // echo '<pre>';print_r($res);die;
            $message = $request->lock . 'ed';
        }else if($request->unlock)
        {
            $user = User::find($id);
            $user->update(['status' => 1, 'write_permission' => 1]);
            // return $user;

            $res = Http::post('localhost:3000/registeruser', ["username"=>$user->name]);
            // echo '<pre>';print_r($res);die;

            $message = $request->unlock . 'ed';
        }else if($request->revoke){
            $user = User::find($id);
            $user->update(['write_permission' => 0]);

            $res = Http::post('localhost:3000/registeruser', ["username"=>"appUser"]);
            // echo '<pre>';print_r($res);die;
            if(!empty($res)){
                $message = $request->revoke . 'ed from blockchain network';
            }else{
                $message = 'Smething went wrong. Please try again later.';
            }
        }else if($request->invoke){
            $user = User::find($id);
            $user->update(['write_permission' => 1]);

            $res = Http::post('localhost:3000/registeruser', ["username"=>$user->name]);
            // echo '<pre>';print_r($res);die;
            if(!empty($res)){
                $message = 'invoked in blockchain network';
            }else{
                $message = 'Smething went wrong. Please try again later.';
            }
        }else{
            $message = 'Smething went wrong. Please try again later.';
        }
  
        return redirect()->route('user.index')
                        ->with('success',"User $message successfully");
    }

    public function writeAccess(Request $request, $id){
        $message = '';
        if($request->revoke){
            $user = User::find($id);
            $user->update(['write_permission' => 0]);

            $res = Http::post('localhost:3000/registeruser', ["username"=>""]);
            // echo '<pre>';print_r($res);die;
            if(!empty($res)){
                $message = $request->revoke . 'ed from blockchain network';
            }else{
                $message = 'Smething went wrong. Please try again later.';
            }
        }else{
            $user = User::find($id);
            $user->update(['write_permission' => 1]);

            $res = Http::post('localhost:3000/registeruser', ["username"=>$user->name]);
            // echo '<pre>';print_r($res);die;
            if(!empty($res)){
                $message = 'invoked in blockchain network';
            }else{
                $message = 'Smething went wrong. Please try again later.';
            }
        }
  
        return redirect()->route('user.index')
                        ->with('success',"User $message successfully");
    }
}

<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function login(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email'     => 'required',
                'password'  => 'required',
            ]);
    
            if ($validator->fails()) {
                // return $validator->messages();
                return redirect('login')->with('error' , 'Username dan password harus di isi');
            }

            $user = User::where('email', '=', $request->email)->first();

            if ($user == null || !Hash::check($request->password, $user->password)) {
                return redirect('login')->with('error' , 'Username atau password salah');
            }

            Session::put('id_user',     $user->id_user);
            Session::put('nama',        $user->nama);
            Session::put('email',       $user->email);
            Session::put('telepon',     $user->telepon);
            Session::put('role',        $user->kode_role);
            Session::put('alamat',      $user->alamat);
            Session::put('login',       TRUE);

            return redirect('produk');
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function addUser(Request $request){
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'email'     => 'required',
            'password'  => 'required',
            'telepon'   => 'required',
            // 'role'      => 'required',
            // 'alamat'    => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        }

        $query = "select * from users where email = '".$request->email."' and deleted_at is null";
        $data = DB::select($query);

        if($data != null){
            return redirect('registration')->with('error' , 'Email sudah terdaftar');
        }

        $now = Carbon::now();

        $query = 
        "insert into users (
            nama, 
            email, 
            password, 
            telepon, 
            alamat,
            role, 
            created_at, 
            updated_at)
        VALUES (
            '".$request->nama."',
            '".$request->email."',
            '".Hash::make($request->password)."',
            '".$request->telepon."',
            '".$request->alamat."',
            'USER',
            '".$now->toDateTimeString()."',
            '".$now->toDateTimeString()."')";
        
        $ret = DB::select($query);

        return redirect('login');
    }

    public function getAllUser(){
        try{
            $query = "select * from users where deleted_at is null order by nama asc";
            
            $users = DB::select($query);

            return Datatables()->of($users)
                    ->addColumn('detail_user', function($users){
                        return '<a class="modal-detail-user" data-id="'.$users->id_user.'" href="#">'. $users->nama . '</a>';
                    })
                    ->addColumn('action', function($users){
                        return '<a class="btn btn-danger modal-delete-user" data-id="'.$users->id_user.'" href="#"><i class="fas fa-trash-alt"></i></a>';
                    })
                    ->rawColumns(['detail_user','action'])->make(true);

        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function editUser(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id_user'   => 'required',
                'nama'      => 'required',
                'email'     => 'required',
                'telepon'   => 'required',
            ]);
    
            if ($validator->fails()) {
                return $validator->messages();
            }
    
            $now = Carbon::now();
    
            $query = 
            "update users set 
                nama = '".$request->nama."',
                email = '".$request->email."',
                telepon = '".$request->telepon."',
                alamat = '".$request->alamat."'
            where 
                id_user = '".$request->id_user."'";
            
            $user = DB::select($query);

            return 0;    
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function deleteUser(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id_user'   => 'required',
            ]);
    
            if ($validator->fails()) {
                return $validator->messages();
            }

            $now = Carbon::now();
    
            $query = "update users set deleted_at = '".$now->toDateTimeString()."' where id_user = '".$request->id_user."'";
            
            $user = DB::select($query);

            return redirect()->back()->with(['sukses' => 'Berhasil hapus user']);
        }catch(\Exception $ex){
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }

    public function getDetailUser($id_user){
        try{
            $query = "select * from users where id_user = '".$id_user."' and deleted_at is null limit 1";
            
            $user = DB::select($query);

            return json_encode($user);
    
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }
}

<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeranjangController extends Controller
{
    public function addKeranjang(Request $request){
        $validator = Validator::make($request->all(), [
            // 'id_user'       => 'required',
            'id_produk'     => 'required',
            'jumlah'        => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        }

        // '".$Session::get('id_user')."',
        $now = Carbon::now();

        $query = 
        "insert into keranjang (
            id_user, 
            id_produk, 
            jumlah, 
            created_at, 
            updated_at)
        VALUES (
            '".$request->id_user."',
            '".$request->id_produk."',
            '".$request->jumlah."',
            '".$now->toDateTimeString()."',
            '".$now->toDateTimeString()."')";
        
        $ret = DB::select($query);

        return 0;
    }

    public function editKeranjang(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id_keranjang'  => 'required',
                'jumlah'        => 'required',
            ]);
    
            if ($validator->fails()) {
                return $validator->messages();
            }

            $now = Carbon::now();
    
            $query = 
            "update keranjang set 
                jumlah= '".$request->jumlah."', 
                updated_at='".$now->toDateTimeString()."'
            WHERE 
                id_keranjang='".$request->id_keranjang."'";
            
            $produk = DB::select($query);

            return 0;        
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function deleteKeranjang($id_keranjang){
        try{
            $now = Carbon::now();
    
            $query = "update keranjang set deleted_at = '".$now->toDateTimeString()."' where id_keranjang = '".$id_keranjang."'";
            
            $produk = DB::select($query);

            return 0;    
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function getAllKeranjang($id_user){
        try{
            $query = 
            "select 
                users.nama,
                users.email,
                users.telepon,
                produk.kode_produk,
                produk.nama as nama_produk,
                produk.harga,
                keranjang.jumlah	
            from 
                keranjang 
            left join 
                users on keranjang.id_user = users.id_user
            left join 
                produk on keranjang.id_produk = produk.id_produk
            where 
                keranjang.id_user = '".$id_user."'
            and 
                keranjang.deleted_at is null
            order by 
                keranjang.updated_at asc";            
            
            $keranjang = DB::select($query);

            return json_encode($keranjang);
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }
}

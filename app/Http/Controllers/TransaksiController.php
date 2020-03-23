<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\TransaksiModel;

class TransaksiController extends Controller
{
    public function saveImage($file){
        try{
            if(!File::isDirectory($this->path)){
                File::makeDirectory($this->path);    
            }
    
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $canvas = Image::canvas($this->dimension,$this->dimension);
    
            $resizeImage  = Image::make($file)->resize($this->dimension, $this->dimension, function($constraint) {
                $constraint->aspectRatio();
            });
             
            $canvas->insert($resizeImage, 'center');    
            $canvas->save($this->path . '/' . $fileName);

            $res = array(
                'code'      => true,
                'message'   => $this->path,
            );

            return $res;
        }catch(\Exception $ex){
            $res = array(
                'code'      => false,
                'message'   => 'gagal menyimpan gambar, '. $ex->getMessage(),
            );

            return $res;
        }
    }

    public function addTransaksi(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'no_rekening'   => 'required',
                'alamat_kirim'  => 'required',
                'total'         => 'required',
                'status'        => 'required',
                // 'barang'        => 'required',
            ]);
    
            if ($validator->fails()) {
                return $validator->messages();
            }

            $now = Carbon::now();

            $query = 
            "insert into transaksi (
                no_rekening, 
                alamat_kirim, 
                total, 
                status, 
                created_at, 
                updated_at)
            VALUES (
                '".$request->no_rekening."',
                '".$request->alamat_kirim."',
                '".$request->total."',
                'MENUNGGU PEMBAYARAN',
                '".$now->toDateTimeString()."',
                '".$now->toDateTimeString()."')";
            
            $ret = DB::select($query);
            
            $queryId = "select LAST_INSERT_ID()";

            $lastId = DB::select($queryId);

            $data = array();
            
            for($i = 0; $i < count($request->barang); $i++){                
                $data[$i] = array();
                // $data[$i]['id_transaksi'] = $request->barang[];
                // $data[$i]['id_user'] = $request->barang[];
                // $data[$i]['id_produk'] = $request->barang[];
                // $data[$i]['jumlah'] = $request->barang[];
                // $data[$i]['total'] = $request->barang[];
                // $data[$i]['created_at'] = $request->barang[];
                // $data[$i]['updated_at'] = $request->barang[];
            }

            TransaksiModel::insert($data);

            return $lastId;
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function addDetailTransaksi($data){
        try{

        }catch(\Exception $ex){

        }
    }

    public function uploadBuktiBayar(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id_transaksi'  => 'required',
                // 'status'        => 'required',
                'bukti_bayar'   => 'required',
            ]);
    
            if ($validator->fails()) {
                return $validator->messages();
            }

            $saveImage = $this->saveImage($request->bukti_bayar); 

            if($saveImage['code'] == false){
                return $saveImage['message'];
            }
    
            $path = $this->path;
            $now = Carbon::now();
        
            $query = 
            "update transaksi set 
                status = 'CEK PEMBAYARAN',
                bukti_bayar = '".$path."'
            where 
                id_transaksi = '".$request->id_transaksi."'";
            
            $user = DB::select($query);

            return 0;        
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function editStatus(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id_transaksi'  => 'required',
                'status'        => 'required',
            ]);
    
            if ($validator->fails()) {
                return $validator->messages();
            }
    
            $now = Carbon::now();
    
            $query = 
            "update transaksi set 
                status = '".$request->status."'
            where 
                id_transaksi = '".$request->id_transaksi."'";
            
            $user = DB::select($query);

            return 0;    
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function getAllTransaksi($id_user){
        try{
            $query = 
            "select
                transaksi.id_transaksi,
                transaksi.alamat_kirim,
                transaksi.total,
                transaksi.status,
                transaksi.bukti_bayar
            from 
                detail_transaksi 
            left join 
                transaksi on detail_transaksi.id_transaksi= transaksi.id_transaksi
            left join 
                users on detail_transaksi.id_user = users.id_user
            where 
                detail_transaksi.id_user = '".$id_user."'
            order by 
                detail_transaksi.updated_at asc";

            $transaksi = DB::select($query);
            
            return json_encode($transaksi);
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }


    public function getDetailTransaksi($id_transaksi){
        try{
            $query = 
            "select
                transaksi.id_transaksi,
                transaksi.alamat_kirim,
                transaksi.total as total_transaksi,
                transaksi.status,
                transaksi.bukti_bayar,
                produk.id_produk,
                produk.nama as nama_produk,
                produk.harga,
                produk.gambar,
                detail_transaksi.jumlah,
                detail_transaksi.total
            from 
                detail_transaksi 
            left join 
                transaksi on detail_transaksi.id_transaksi= transaksi.id_transaksi
            left join 
                produk on detail_transaksi.id_produk= produk.id_produk
            left join 
                users on detail_transaksi.id_user = users.id_user
            where 
                detail_transaksi.id_transaksi= '".$id_transaksi."'
            order by 
                detail_transaksi.updated_at asc";
            
            $user = DB::select($query);

            return json_encode($user);
    
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }
}

<?php

namespace App\Http\Controllers;

use DB;
use App\Image_uploaded;
use Carbon\Carbon;
use Image;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ProdukModel;
use Illuminate\Support\Facades\Session;

class ProdukController extends Controller
{
    
    public $path;
    public $dimension;

    public function __construct(){
        $this->path         = storage_path('app/public/images/');
        $this->dimension    = 300;
    }   

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
                'message'   => $fileName,
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

    public function addProduk(Request $request){
        $validator = Validator::make($request->all(), [
            'kode_produk'   => 'required',
            'nama'          => 'required',
            'harga'         => 'required',
            'jumlah'        => 'required',
            'keterangan'    => 'required',
            'gambar'        => 'required|image|mimes:jpg,png,jpeg'
        ]);

        if ($validator->fails()) {
            $error = $validator->messages()->first();
            return redirect()->back()->with(['error' => $error]);
        }

        $query = "select * from produk where kode_produk = '".$request->kode_produk."' and deleted_at is null";
        $kodeProduk = DB::select($query);

        if($kodeProduk != null){
            return redirect()->back()->with(['error' => 'produk sudah tersedia']);
        }

        $saveImage = $this->saveImage($request->gambar); 

        if($saveImage['code'] == false){
            return $saveImage['message'];
        }

        $path = 'storage/images/'.$saveImage['message'];
        $now = Carbon::now();

        $query = 
        "insert into produk (
            kode_produk, 
            nama, 
            jumlah, 
            harga, 
            gambar, 
            keterangan,
            created_at, 
            updated_at)
        VALUES (
            '".$request->kode_produk."',
            '".$request->nama."',
            '".$request->jumlah."',
            '".$request->harga."',
            '".$path."',
            '".$request->keterangan."',
            '".$now->toDateTimeString()."',
            '".$now->toDateTimeString()."')";
        
        $ret = DB::select($query);

        return redirect()->back()->with(['sukses' => 'Berhasil tambah produk']);
    }

    public function editProduk(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id_produk'     => 'required',
                'nama'          => 'required',
                'harga'         => 'required',
                'jumlah'        => 'required',
                'keterangan'    => 'required',
                // 'gambar'        => 'required|image|mimes:jpg,png,jpeg'
            ]);
    
            if ($validator->fails()) {
                return $validator->messages();
            }

            $now = Carbon::now();
    
            $query = 
            "update produk set 
                nama='".$request->nama."', 
                jumlah= '".$request->jumlah."', 
                harga= '".$request->harga."', 
                keterangan='".$request->keterangan."', 
                updated_at='".$now->toDateTimeString()."'
            WHERE 
                id_produk='".$request->id_produk."'";
            
            $produk = DB::select($query);

            return redirect()->back()->with(['sukses' => 'Berhasil edit produk']);
        }catch(\Exception $ex){
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }

    public function deleteProduk(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id_produk'     => 'required',
            ]);
    
            if ($validator->fails()) {
                return $validator->messages();
            }

            $now = Carbon::now();
    
            $query = "update produk set deleted_at = '".$now->toDateTimeString()."' where id_produk = '".$request->id_produk."'";
            
            $produk = DB::select($query);

            return redirect()->back()->with(['sukses' => 'Berhasil hapus produk']);
        }catch(\Exception $ex){
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }

    public function getAllProduk(){
        try{
            $query = "select * from produk where deleted_at is null order by nama asc";
            
            $produk = DB::select($query);

            return Datatables()->of($produk)
                    ->addColumn('gambar', function($produk){
                        $url= asset('storage/'.$produk->gambar);
                        return '<img src="'.$produk->gambar.'" border="0" width="40" class="img-rounded" align="center" />';
                            })
                    ->addColumn('action', function($produk){
                        return '<a class="btn btn-primary modal-edit-produk" data-id="'.$produk->id_produk.'" href="#"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-danger modal-delete-produk" data-id="'.$produk->id_produk.'" href="#"><i class="fas fa-trash-alt"></i></a>';
                            })
                    ->rawColumns(['gambar'],['action'])->make(true);
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function getAllProdukShop(){
        try{
            $produk = DB::table('produk')
                    ->whereNull('deleted_at')
                    ->orderBy('nama','asc')
                    ->paginate(12);

            return json_encode($produk);

        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function getDetailProduk($id_produk){
        try{
            if(!Session::get('login')){
                return redirect('login')->with('error','Anda harus login dulu');
            }

            $query = "select * from produk where id_produk = '".$id_produk."' and deleted_at is null limit 1";
            
            $produk = DB::select($query);

            // return json_encode($produk);
    
            return view('content.detailProduk')->with('data', $produk);
        
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }    
}

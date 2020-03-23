<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ViewController extends Controller
{
    public function index(){
        return view('login');
    }

    public function registration(){
        return view('registration');
    }

    public function dashboard(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Anda harus login dulu');
        }
        return view('content.dashboard');
    }

    public function keranjang(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Anda harus login dulu');
        }
        return view('content.keranjang');
    }

    public function pelanggan(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Anda harus login dulu');
        }
        return view('content.pelanggan');
    }
    
    public function shop(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Anda harus login dulu');
        }

        $produk = $this->getAllProduk();

        $res = array(
            'produk'        => $produk->getCollection(),
            'current_page'  => $produk->currentPage(),
            'next_page'     => $produk->nextPageUrl(),
            'prev_page'     => $produk->previousPageUrl(),
            'last_page'     => $produk->lastPage(),
            'total'         => $produk->total(), 
            'size'          => count($produk->getCollection()), 
            'option'        => $produk->getOptions(), 
        );

        // return $res; die()   ;
        // return $produk;
        return view('content.shop', ['data_shop' => $res]);
    }

    public function detailProduk(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Anda harus login dulu');
        }
        return view('content.detailProduk');
    }

    
    public function transaksi(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Anda harus login dulu');
        }
        return view('content.transaksi');
    }

    public function getAllProduk(){
        try{
            $produk = DB::table('produk')
                    ->whereNull('deleted_at')
                    ->orderBy('nama','asc')
                    ->paginate(12);

            // echo json_encode($produk);die(); 
            return $produk;
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
        
    }
}

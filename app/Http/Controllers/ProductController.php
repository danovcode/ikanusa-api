<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\Toko;
use App\Models\User;

class ProductController extends Controller
{

    public function createProduct(Request $request){
        $user  = Auth::user();
        $user_id = $user->id;
        $toko = Toko::where('userId', $user_id)->firstOrFail();
        $toko_id = $toko->id;
        $time = date('H:i',strtotime("+1 hours"));
        $product = Product::create([
            'harga'   => $request->harga,
            'nama'    => $request->nama,
            'stok'    => $request->stok,
            'kondisi' => $request->kondisi,
            'minimal' => $request->minimal,
            'deskripsi'    => $request->deskripsi,
            'image'     => $request->file('file')->store('image'),
            'tokoId'  => $toko_id,
            'status'  => $request->status,
            'user_id' => $user_id,
            'expired_on' => $time
        ]);
        return $product;
    }

    public function showAllJual(){
        $product = Product::where('status','jual')
                            
                            ->get();
        $arr = [];
        foreach($product as $object){
            $query = Toko::where([
                ['id', $object['tokoId']],
            ])->first();

            $product = [
                'id'      => $object->id,
                'harga'   => $object->harga,
                'nama'    => $object->nama,
                'stok'    => $object->stok,
                'kondisi' => $object->kondisi,
                'minimal' => $object->minimal,
                'deskripsi'    => $object->deskripsi,
                'image'    => $object->image,
                'tokoId'  => $object->toko,
                'status'  => $object->status,
                
            ];
            $toko = [
                'id_toko'   =>$query->id,
                'nama_toko'    => $query->nama_toko,
                'lokasi_toko'    => $query->lokasi_toko,
                'nama_alamat'    => $query->nama_alamat,
            ];
            $dataModel = [
                "product" => $product,
                "toko" => $toko
            ];

            array_push($arr,$dataModel);
        }
        return $arr;
    }
    
    public function pesananBaru(){
        $user  = Auth::user();
        $time = date('H:i');
        $reject = json_decode($user->rejected_request);
        $product = Product::where('status','beli')
                    ->Where('accepted',false||null)
                    ->Where('is_active','Y')
                    ->where('expired_on','>=',$time)
                    ->whereNotIn('id',$reject)->get();
        $arr = [];
        foreach($product as $object){
            if($object->expired_on <= $time){
                $product->update([
                        "is_active" => "N",
                ]);
            }
            $query = User::where([
                ['id', $object['tokoId']],
            ])->first();
            $product = [
                'id'      => $object->id,
                'harga'   => $object->harga,
                'nama'    => $object->nama,
                'stok'    => $object->stok,
                'kondisi' => $object->kondisi,
                'minimal' => $object->minimal,
                'deskripsi'    => $object->deskripsi,
                'tokoId'  => $object->toko,
                'expired_on' => $object->expired_on,
                'status'  => $object->status,
                'tanggal' => $object->created_at,
            ];
            $user = [
                'nama_depan'   =>$query->nama_depan,
                'nama_belakang'    => $query->nama_belakang,
            ];
            
            $dataModel = [
                "product" => $product,
                "user" => $user,
                "status" => "success",
            ];
            
            array_push($arr,$dataModel);
            
        }
        
        return $arr;
    }
    
    public function pembelianBaru(){
        $user  = Auth::user();
        $time = date('H:i');
        $reject = json_decode($user->rejected_request);
        $product = Product::where('status','jual')
                    ->Where('accepted',false||null)
                    ->Where('is_active','Y')
                    ->where('expired_on','>=',$time)
                    ->whereNotIn('id',$reject)->get();
        $arr = [];
        foreach($product as $object){
            if($object->expired_on <= $time){
                $product->update([
                        "is_active" => "N",
                ]);
            }
            $query = Toko::where([
                ['id', $object['tokoId']],
            ])->first();

            $product = [
                'id'      => $object->id,
                'harga'   => $object->harga,
                'nama'    => $object->nama,
                'stok'    => $object->stok,
                'kondisi' => $object->kondisi,
                'minimal' => $object->minimal,
                'deskripsi'    => $object->deskripsi,
                'tokoId'  => $object->toko,
                'status'  => $object->status,
                'tanggal' => $object->created_at,
                "message" => 'hi '. $user->nama_belakang .' ada pesanan baru berupa : ' . $object->nama .', sebanyak :'. $object->stok .''
            ];
            $toko = [
                'id_toko'   =>$query->id,
                'nama_toko'    => $query->nama_toko,
                'lokasi_toko'    => $query->lokasi_toko,
                'nama_alamat'    => $query->nama_alamat,
            ];
            $dataModel = [
                "product" => $product,
                "toko" => $toko,
                
            ];

            array_push($arr,$dataModel);
        }
        return $arr;
    }
    
    public function showAllBeli(){
        $product = Product::where('status','beli')->get();
        $arr = [];
        foreach($product as $object){
            $query = Toko::where([
                ['id', $object['tokoId']],
            ])->first();

            $product = [
                'id'      => $object->id,
                'harga'   => $object->harga,
                'nama'    => $object->nama,
                'stok'    => $object->stok,
                'kondisi' => $object->kondisi,
                'minimal' => $object->minimal,
                'deskripsi'    => $object->deskripsi,
                'tokoId'  => $object->toko,
                'status'  => $object->status,
            ];
            $toko = [
                'id_toko'   =>$query->id,
                'nama_toko'    => $query->nama_toko,
                'lokasi_toko'    => $query->lokasi_toko,
                'nama_alamat'    => $query->nama_alamat,
            ];
            $dataModel = [
                "product" => $product,
                "toko" => $toko
            ];

            array_push($arr,$dataModel);
        }
        return $arr;
    }

    public function showdetail($id){
        $product = Product::where('status','beli')->firstOrFail();
        $toko_id = $product->tokoId;
        $query = Toko::where([
            ['id', $toko_id],
        ])->first();

        $product_model = [
            'harga'   => $product->harga,
            'nama'    => $product->nama,
            'stok'    => $product->stok,
            'kondisi' => $product->kondisi,
            'minimal' => $product->minimal,
            'deskripsi'    => $product->deskripsi,
            'tokoId'  => $product->toko,
            'status'  => $product->status,
        ];
        $toko_model = [
            'nama_toko'    => $query->nama_toko,
            'lokasi_toko'    => $query->lokasi_toko,
            'nama_alamat'    => $query->nama_alamat,
        ];
        $dataModel = [
            "product" => $product_model,
            "toko" => $toko_model
        ];

        return $dataModel;
    }
    
    public function accept($id){
        $user  = Auth::user();
        $user_id = $user->id;
        $stok = Product::where('id', $id)->update([
            'accepted' => true,
            'nelayanId' => $user_id
        ]);
        $dataModel = [
            "message" => "berhasil menerima pesanan",
            "error" => false,
            "code" => 200
        ];
        return $user_id;
    }
    
    public function reject($id){
        $user  = Auth::user();
        $user_id = $user->id;
        $int = (int)$id;
        $rejected = json_decode($user->rejected_request);
        $res = array_push($rejected,$int);
        $stok = User::where('id', $user_id)->update([
            'rejected_request'=>$rejected
        ]);
        $dataModel = [
            "product" => $rejected,
            "toko" => $id,
            "message" => "berhasil menolak pesanan",
            "error" => false,
            "code" => 200
        ];
        return $dataModel;
    }
    
     public function edit($id, Request $request){
        $user  = Auth::user();
        $user_id = $user->id;
        $stok = Product::where('id', $id)->update([
            'harga'   => $request->harga,
            'nama'    => $request->nama,
            'stok'    => $request->stok,
            'kondisi' => $request->kondisi,
            'minimal' => $request->minimal,
            'deskripsi'    => $request->deskripsi,
        ]);
        $dataModel = [
            "message" => "berhasil menerima pesanan",
            "error" => false,
            "code" => 200
        ];
        return $user_id;
    }
}

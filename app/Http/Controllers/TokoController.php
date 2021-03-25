<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\User;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TokoController extends Controller
{
    public function createToko(Request $request){
        $user  = Auth::user();
        $user_id = $user->id;
        if($user->toko_status === true || $user->toko_status === 1){
            $toko = Toko::where('userId', $user_id)->firstOrFail();
            return response()->json([
                'error' => TRUE,
                'message' => 'Kamu sudah memiliki toko',
                'data toko' => $toko,
                'code' => 403
            ],403);
        }
        else{
            $toko = Toko::create([
                'userId'    => $user_id,
                'nama_pemilik'    => $request->nama_pemilik,
                'nama_toko'    => $request->nama_toko,
                'foto_ktp'    => $request->file('foto_ktp')->store('ktp'),
                'foto_selfie_ktp'    => $request->file('foto_selfie_ktp')->store('selfie_ktp'),
                'tanda_tangan'     => $request->file('tanda_tangan')->store('tanda_tangan'),
                'lokasi_toko'    => $request->lokasi_toko,
                'nama_alamat'    => $request->nama_alamat,
            ]);

            User::where('id', $user_id)->update([
                'toko_status'    => true,
            ]);
            return $toko;
        }
    }
    
    public function getMyToko(){
        $user  = Auth::user();
        $user_id = $user->id;
        try{
            return Toko::where('userId', $user_id)->firstOrFail();
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'error' => TRUE,
                'message' => 'Toko Tidak di temukan',
                'code' => 404
            ],404);
        }
    }

    public function getToko($id){
        try{
            return Toko::where('userId',$id)->firstOrFail();
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'error' => TRUE,
                'message' => 'Toko Tidak di temukan',
                'code' => 404
            ],404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
use App\Models\Image;
 
use Validator;
 
class MultipleUploadController extends Controller
{
    public function upload(Request $req){
        $res = $req->file('file')->store('image');
        return ['file' => $res];
    }
}

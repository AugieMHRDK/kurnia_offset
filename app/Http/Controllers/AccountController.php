<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Billing;
use App\Models\Package;
use App\helpers;

class AccountController extends Controller
{

    public function generateRandomString($length = 6) {
        $characters = '@#&98765432asdfghjkmnbvcxzpytrewq';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function generateRandomString2($length = 6) {
        $characters = 'ASDFGHJKPUYTREWZXCVBNM';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function register(Request $request)
    {
        \DB::beginTransaction();
        try{
            
            $user               = new User();
            $user->name         = $request->name;
            $user->number       = $request->number;
            $user->email        = $request->email;
            $user->level        = 2;
            $user->password     = Hash::make($request->password);
            $user->save();
            
            
            \DB::commit();
            
            return response()->json(['status'=>true, 'message'=>'Registrasi Berhasil!']);
        }catch(\Exception $e){
            \DB::rollback();
            return response()->json(['status'=>false, 'message'=>'Registrasi Gagal!']);
        }
    }
}

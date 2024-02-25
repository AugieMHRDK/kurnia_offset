<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\helpers;

class ApiController extends Controller
{

    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $key = $request->header('x-api-key');
        //     $this->app = User::select('*')
        //                         ->where([
        //                             ['id','=', 1],
        //                             ['api_key','=',$key]
        //                             ])
        //                         ->first(); // get from users only id = 1 & level must 1
        //     if($this->app === null){
        //         return response('Unauthorized', 401)
        //                       ->header('Content-Type', 'application/json');
        //     } else {
        //         return $next($request);
        //     }
        // });
    }
    
    public function status(Request $request)
    {
        $status = $request->transaction_status;
        $id = $request->transaction_id;
        $message = $request->status_message;
        $fraud = $request->fraud_status;

        $pemesanan = Pemesanan::where('kode_pemesanan', $id)->first();
        $pemesanan->status = $status;
        $pemesanan->save();

        if($pemesanan){
            $res = array(
                "status" => 'success'
            );
            $res = json_encode($res);
    
            return response($res, 200)
                            ->header('Content-Type', 'application/json');
        } else {
    
            $res = array(
                "status" => 'error'
            );
            $res = json_encode($res);
    
            return response($res, 500)
                            ->header('Content-Type', 'application/json');
        }
    }
}

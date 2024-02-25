<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use DataTables;
use DateTime;
use App\Models\Produk;
use App\Models\Pemesanan;
use App\Models\TrackingStatus;
use App\helpers;
use Rawilk\Printing\Facades\Printing;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        

        // $data = Pemesanan::get();
        // if($data){
        //     foreach($data as $d){
        //         if($d->midtrans_status_code === null || $d->midtrans_status_code != '200'){
        //             $stat = cekStatus($d->kode_pemesanan);
        //             if($stat){
        //                 if($stat['status_code'] != '404'){
        //                     if($stat['status_code'] != '502'){
        //                         if($stat['status_code'] == '200'){
        //                             $status = "Pembayaran Diterima";
        //                         } else if($stat['status_code'] == '201'){
        //                             $status = "Pending";
        //                         } else if($stat['status_code'] == '202'){
        //                             $status = "Pembayaran Ditolak";
        //                         } else {
        //                             $status = $stat['transaction_status'];
        //                         }
                                
        //                         $cek = TrackingStatus::where(['pemesanan_id'=>$d->id, 'status'=>"[".$stat['transaction_status']."] ".$status])->count();
        //                         if($cek == 0){
        //                             $upd                             = Pemesanan::find($d->id);
        //                             $upd->midtrans_status_code       = $stat['status_code'];
        //                             $upd->midtrans_transaction_status= $stat['transaction_status'];
        //                             $upd->status                     = $status;
        //                             $upd->save();
                
        //                             $ins = new TrackingStatus();
        //                             $ins->pemesanan_id = $d->id;
        //                             $ins->status = "[".$stat['transaction_status']."] ".$status;
        //                             $ins->timestamp = date("Y-m-d H:i:s");
        //                             $ins->save();
        //                         }
        //                     }
                            
        //                 }
        //             }
                        
        //         }
        //     }
        // }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function landing(Request $request)
    {
        return view('landing');
    }
    
    public function index(Request $request)
    {
        if(auth()->user()->level == 1){
            $dashboard = 'content.dashboard_admin';
        } else {
            $dashboard = 'content.dashboard_user';
        }
        $data = [
            'count_omsecond' => 0,
            'menu'       => 'menu.'.auth()->user()->menu,
            'content'    => $dashboard,
            'title'      => 'Home',
            'notif'      => 'v_notif',
            'produk'     => Produk::with('attachments')->get()
        ];

        if ($request->ajax()) {

            if(auth()->user()->level == 1){
                $pemesanan = Pemesanan::with('produk')
                ->select('*')
                ->addSelect(\DB::raw('DATE_FORMAT(timestamp, "%d/%m/%Y") AS timestamp_f'))
                ->orderBy('timestamp', 'desc');
            } else {
                $pemesanan = Pemesanan::with('produk')->where('user_id', auth()->user()->id)
                ->select('*')
                ->addSelect(\DB::raw('DATE_FORMAT(timestamp, "%d/%m/%Y") AS timestamp_f'))
                ->orderBy('timestamp', 'desc');
            }
            return Datatables::of($pemesanan)
                    ->addIndexColumn()
                    ->addColumn('stat_lunas', function($row){
                        if($row->is_lunas == '1'){
                            $stat = '<span class="badge badge-light-primary">Lunas</span>';
                        } else {
                            $stat = '<span class="badge badge-light-danger">Belum Lunas</span>';
                        }
 
                        return $stat;
                    })
                    ->addColumn('action', function($row){
                        $btn = '';
                        if($row->midtrans_status_code != '200'){
                            $btn .= '&nbsp; <a href="'.url("/pembayaran/$row->id").'" class="btn btn-light-primary btn-sm btn-icon"  data-id="'.$row->id.'"data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Bayar">
                                <i class="fa fa-credit-card"></i>
                            </a>';
                        }

                        $btn .= '&nbsp; <a href="javascript:;" class="btn btn-light-primary btn-sm btn-icon detailData"  data-id="'.$row->id.'"data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Detail">
                            <i class="fa fa-eye"></i>
                        </a>';
 
                        return $btn;
                    })
                    ->rawColumns(['action','stat_lunas'])
                    ->make(true);
        }

        return view('layouts.v_template', $data);
    }
    public function detail($id)
    {
        $pemesanan = Pemesanan::with('produk')->where('id', $id)
        ->select('*')
        ->addSelect(\DB::raw('DATE_FORMAT(timestamp, "%d/%m/%Y") AS timestamp'))
        ->first();
        $pemesanan->total_harga = number_format( $pemesanan->total_harga,0,",",".");
        return response()->json($pemesanan);
    }

}

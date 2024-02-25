<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use App\Models\Pemesanan;
use App\Models\Attachments;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\TrackingStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TrackingStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // $data = Pemesanan::get();
        // foreach($data as $d){
        //     // dd($d);
        //     if($d->midtrans_status_code === null || $d->midtrans_status_code != '200'){
        //         $stat = cekStatus($d->kode_pemesanan);
        //         if($stat['status_code'] != '404'){
        //             if($stat['status_code'] != '502'){
        //                 if($stat['status_code'] == '200'){
        //                     $status = "Pembayaran Diterima";
        //                 } else if($stat['status_code'] == '201'){
        //                     $status = "Pending";
        //                 } else if($stat['status_code'] == '202'){
        //                     $status = "Pembayaran Ditolak";
        //                 } else {
        //                     $status = $stat['transaction_status'];
        //                 }
                        
        //                 $cek = TrackingStatus::where(['pemesanan_id'=>$d->id, 'status'=>"[".$stat['transaction_status']."] ".$status])->count();
        //                 if($cek == 0){
        //                     $upd                             = Pemesanan::find($d->id);
        //                     $upd->midtrans_status_code       = $stat['status_code'];
        //                     $upd->midtrans_transaction_status= $stat['transaction_status'];
        //                     $upd->status                     = $status;
        //                     $upd->save();
        
        //                     $ins = new TrackingStatus();
        //                     $ins->pemesanan_id = $d->id;
        //                     $ins->status = "[".$stat['transaction_status']."] ".$status;
        //                     $ins->timestamp = date("Y-m-d H:i:s");
        //                     $ins->save();
        //                 }
        //             }
                    
        //         }
        //     }
        // }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $data = [
            'menu'       => 'menu.v_menu_user',
            'content'    => 'content.tracking_status_create',
            'title'      => 'Update Status Pemesanan',
            'notif'      => 'v_notif',
            'count'      => Pemesanan::count()
        ];

        if ($request->ajax()) {

            $data = Pemesanan::with('produk','user')->orderBy('timestamp', 'DESC');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<a href="javascript:;" class="btn btn-light-primary btn-sm btn-icon editData" data-id="'.$row->id.'" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Update Status Pesanan">
                            <i class="fa fa-pen"></i>
                        </a>';
 
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('layouts.v_template',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->status == "Lainnya"){
            $status = $request->status_txt;
        } else {
            $status = $request->status;
        }
        $ins = new TrackingStatus();
        $ins->pemesanan_id = $request->id;
        $ins->status = $status;
        $ins->timestamp = date("Y-m-d H:i:s");
        $ins->save();

        return response()->json(['status'=>true, 'message'=>'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = TrackingStatus::
        select('*')
        ->addSelect(\DB::raw('DATE_FORMAT(timestamp, "%d/%m/%Y") AS tanggal, DATE_FORMAT(timestamp, "%H:%i") AS jam'))
        ->where('pemesanan_id',$id)->get();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

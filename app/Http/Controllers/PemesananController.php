<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use DateTime;
use App\Models\Pemesanan;
use App\Models\Attachments;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\TrackingStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\Midtrans\CreateSnapTokenService; // => letakkan pada bagian atas class

class PemesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $data = Pemesanan::get();
        foreach($data as $d){
            if($d->midtrans_status_code === null ){
                $stat = cekStatus($d->kode_pemesanan);
                if($stat){
                    if($stat['status_code'] != '404'){
                        if($stat['status_code'] != '502'){
                            if($stat['status_code'] == '200'){
                                $status = "Pembayaran Diterima";
                            } else if($stat['status_code'] == '201'){
                                $status = "Pending";
                            } else if($stat['status_code'] == '202'){
                                $status = "Pembayaran Ditolak";
                            } else {
                                $status = $stat['transaction_status'];
                            }
                            
                            $cek = TrackingStatus::where(['pemesanan_id'=>$d->id, 'status'=>"[".$stat['transaction_status']."] ".$status])->count();
                            if($cek == 0){
                                $upd                             = Pemesanan::find($d->id);
                                $upd->midtrans_status_code       = $stat['status_code'];
                                $upd->midtrans_transaction_status= $stat['transaction_status'];
                                $upd->status                     = $status;
                                $upd->save();
            
                                $ins = new TrackingStatus();
                                $ins->pemesanan_id = $d->id;
                                $ins->status = "[".$stat['transaction_status']."] ".$status;
                                $ins->timestamp = date("Y-m-d H:i:s");
                                $ins->save();
                            }
                        }
                        
                    }
                }
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $bahan = Bahan::select(\DB::raw('bahan AS text, id, harga_satuan'))
        ->where([
            ['produk_id', $id]
        ])
        ->get();
        $hs = [];
        foreach($bahan as $b){
            $hs[$b->id] = number_format($b->harga_satuan,0,",",".");
        }
        
        $produk = Produk::find($id);
        if (!$produk) {
            abort(404);
        }
        $produk->harga_satuan = number_format($produk->harga_satuan,0,",",".");
        
        $data = [
            'menu'       => 'menu.v_menu_user',
            'content'    => 'content.pemesanan',
            'title'      => 'Pemesanan Produk',
            'notif'      => 'v_notif',
            'bahan'      => $bahan,
            'produk'     => $produk,
            'hs'         => $hs,
        ];

        return view('layouts.v_template',$data);
    }

    public function trackingIndex(Request $request)
    {

        $data = [
            'menu'       => 'menu.v_menu_user',
            'content'    => 'content.daftar_pesanan_user',
            'title'      => 'Daftar Pesanan',
            'notif'      => 'v_notif',
            'count'      => Pemesanan::with('produk')->where(['user_id'=>auth()->user()->id])->count()
        ];
        // $pemesanan = Pemesanan::with('produk')->where(['user_id'=>auth()->user()->id]);
        // dd($pemesanan->get());

        if ($request->ajax()) {

            $pemesanan = Pemesanan::with('produk','user')->where(['user_id'=>auth()->user()->id])->orderBy('timestamp', 'DESC');
        
            return Datatables::of($pemesanan)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<a href="' .url("tracking-status/$row->id"). '" class="btn btn-light-primary btn-sm btn-icon editData" data-id="'.$row->id.'" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Tracking Status">
                            <i class="fa fa-truck"></i>
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
    public function daftarPesanan(Request $request)
    {
        $data = [
            'menu'       => 'menu.v_menu_user',
            'content'    => 'content.daftar_pesanan',
            'title'      => 'Daftar Pesanan',
            'notif'      => 'v_notif',
            'count'      => Pemesanan::count()
        ];

        if ($request->ajax()) {

            $data = Pemesanan::with('user','produk')
            ->select('*')
            ->addSelect(\DB::raw('DATE_FORMAT(timestamp, "%d/%m/%Y %H:%i") AS tanggal'));

            if(isset($request->tgl_awal) && isset($request->tgl_akhir)){
                // dd($request->tgl_awal);
                $from = DateTime::createFromFormat('d-m-Y', $request->tgl_awal)->format('Y-m-d');
                $to   = DateTime::createFromFormat('d-m-Y', $request->tgl_akhir)->format('Y-m-d');
                $data = $data->whereBetween('timestamp', [$from . " 00:00:00", $to . " 23:59:59"]);
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<a href="'. url($row->desain) .'" class="btn btn-light-primary btn-sm btn-icon editData" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Lihat Desain" target="_blank">
                            <i class="fa fa-print"></i>
                        </a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('layouts.v_template',$data);
    }

    public function daftarPesananPDF(Request $request){
        $data = Pemesanan::with('user','produk')
        ->select('*')
        ->addSelect(\DB::raw('DATE_FORMAT(timestamp, "%d/%m/%Y %H:%i") AS tanggal'));

        if(isset($request->tgl_awal) && isset($request->tgl_akhir)){
            // dd($request->tgl_awal);
            $from = DateTime::createFromFormat('d-m-Y', $request->tgl_awal)->format('Y-m-d');
            $to   = DateTime::createFromFormat('d-m-Y', $request->tgl_akhir)->format('Y-m-d');
            $data = $data->whereBetween('timestamp', [$from . " 00:00:00", $to . " 23:59:59"]);
        }

        $data = $data->get();
        $row = '';
        $hrg = 0;
        foreach($data as $d){
            $hrg += $d->total_harga;
            $row .= "
            <tr>
                <td style='border:1px dashed #555'>$d->kode_pemesanan</td>
                <td style='border:1px dashed #555'>".$d->produk->nama_produk."</td>
                <td style='border:1px dashed #555'>".$d->user->name."</td>
                <td style='border:1px dashed #555'>$d->tanggal</td>
                <td style='border:1px dashed #555'>$d->status</td>
                <td style='border:1px dashed #555'>".number_format($d->total_harga,0,",",".")."</td>
            </tr>

            ";
        }
        $hrg = number_format($hrg,0,",",".");
        
        $html = '
            <style>
                .page-break {
                    page-break-after: always;
                }
            </style>
            <h4>Daftar Pesanan CV Kurnia Offset</h2>
            <table cellpadding=10 cellspacing=0 style="width:100%">
            
                <tr>
                    <td style="border:1px dashed #555;font-weight:bold">Kode Pemesanan</td>
                    <td style="border:1px dashed #555;font-weight:bold">Produk</td>
                    <td style="border:1px dashed #555;font-weight:bold">Pemesan</td>
                    <td style="border:1px dashed #555;font-weight:bold">Tanggal</td>
                    <td style="border:1px dashed #555;font-weight:bold">Status Pembayaran</td>
                    <td style="border:1px dashed #555;font-weight:bold">Total Harga</td>
                </tr>
                '.$row.'
                <tr>
                    <td style="border:1px dashed #555;font-weight:bold" colspan=5>Grand Total</td>
                    <td style="border:1px dashed #555;font-weight:bold">'.$hrg.'</td>
                </tr>
            </table>
        ';
        return Pdf::loadHTML($html)->save(public_path().'/myfile.pdf')->stream('download.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            
            if ($request->hasFile('file')) {
                if($request->file->extension() != 'pdf'){
                    return response()->json(['status'=>true, 'message'=>'Format file harus .pdf!']);
                }

                $file       = time().'.'.$request->file->extension();
                $filename   = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);
                $url        = 'files/'.$file;
                
                if ($request->file) {
                    $request->file->move(public_path('files/'), $file);
                }
            } else {
                $url       = '';
            }
            
            $harga_satuan = preg_replace('/[^0-9]/', '', $request->harga_satuan);
            $total_harga = $harga_satuan*$request->jumlah;

            $ins                = new Pemesanan();
            $ins->kode_pemesanan= auth()->user()->id .'-'. date('YmdHis');
            $ins->user_id       = auth()->user()->id;
            $ins->produk_id     = $request->produk_id;
            $ins->bahan_id      = $request->bahan_id;
            $ins->jumlah        = $request->jumlah;
            $ins->harga_satuan  = $harga_satuan;
            $ins->total_harga   = $total_harga;
            $ins->catatan       = $request->catatan;
            $ins->desain        = $url;
            $ins->status        = "Menunggu Pembayaran";
            $ins->ket           = $request->ket;
            $ins->timestamp     = date("Y-m-d H:i:s");
            $ins->save();

            $stat                = new TrackingStatus();
            $stat->pemesanan_id  = $ins->id;
            $stat->status        = "Menunggu Pembayaran";
            $stat->timestamp     = date("Y-m-d H:i:s");
            $stat->save();

            
            return response()->json(['status'=>true, 'message'=>'Data Berhasil Disimpan!', 'id'=>$ins->id]);
        
        } catch (\Illuminate\Database\QueryException $exception) {
            \DB::rollback();
            $errorInfo = $exception->errorInfo;
            return response()->json(['status'=>false, 'error'=>$errorInfo]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $pemesanan = Pemesanan::with('produk')->where(['user_id'=>auth()->user()->id,'id'=>$id])->first();
        if (!$pemesanan) {
            abort(404);
        }

        $params = (object)[
            'transaction_details' => [
                'order_id' => $pemesanan->kode_pemesanan,
                'gross_amount' => $pemesanan->total_harga,
            ],
            'item_details' => [
                [
                    'id' => $pemesanan->id,
                    'price' => $pemesanan->harga_satuan,
                    'quantity' => $pemesanan->jumlah,
                    'name' => $pemesanan->produk->nama_produk,
                ],
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->number,
            ]
        ];
        
        $snapToken = $pemesanan->snap_token;
        if (empty($snapToken)) {
            
            $midtrans = new CreateSnapTokenService($params);
            $snapToken = $midtrans->getSnapToken();
            
            $upd = Pemesanan::find($id);
            $upd->snap_token = $snapToken;
            $upd->save();
 
        }

        $data = [
            'menu'       => 'menu.v_menu_user',
            'content'    => 'content.pembayaran',
            'title'      => 'Pemesanan Produk',
            'notif'      => 'v_notif',
            'order'      => $params,
            'snapToken'  => $snapToken,
        ];
 
        return view('layouts.v_template',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    
    public function tracking(Request $request, $id)
    {
        $detail = Pemesanan::with('produk','bahan')->find($id);
        $track = TrackingStatus::
        select('*')
        ->addSelect(\DB::raw('DATE_FORMAT(timestamp, "%d/%m/%Y") AS tanggal, DATE_FORMAT(timestamp, "%H:%i") AS jam'))
        ->where('pemesanan_id',$id)->orderBy('timestamp', 'ASC')->get();
        
        $data = [
            'menu'       => 'menu.v_menu_user',
            'content'    => 'content.tracking_status',
            'title'      => 'Pemesanan Produk',
            'notif'      => 'v_notif',
            'track'      => $track,
            'detail'      => $detail,
        ];

        
        return view('layouts.v_template',$data);
    }

    public function cekStatus($kode_pemesanan){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.sandbox.midtrans.com/v2/'.$kode_pemesanan.'/status',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic U0ItTWlkLXNlcnZlci1Tc0lMbVFMUnl2OGNoV2djY3lVaWFoZmc6'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);

    }

    public function autoPrint(Request $request)
    {
        
        if ($request->ajax()) {

            $data = Pemesanan::with('user','produk')
            ->select('*')
            ->addSelect(\DB::raw('DATE_FORMAT(timestamp, "%d/%m/%Y %H:%i") AS tanggal'))
            ->where(['status'=>'Pembayaran Diterima'])->get();
            
            return response()->json(['status'=>true, 'data'=>$data]);
        }

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Attachments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    public function index(Request $request)
    {
        $uuid = Str::uuid()->toString();

        $data = [
            'menu'       => 'menu.v_menu_user',
            'content'    => 'content.produk',
            'title'      => 'Daftar Produk',
            'notif'      => 'v_notif',
            'uuid'      => $uuid,
            'count'      => Produk::count()
        ];

        if ($request->ajax()) {

            $data = Produk::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<a href="javascript:;" class="btn btn-light-primary btn-sm btn-icon editData" data-id="'.$row->id.'" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Edit Data">
                            <i class="fa fa-pen"></i>
                        </a>';

                        $btn = $btn.'&nbsp; <a href="javascript:;" class="btn btn-light-danger btn-sm btn-icon deleteData"  data-id="'.$row->id.'"data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Delete Data">
                            <i class="fa fa-trash"></i>
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
        try {

            $produk = Produk::updateOrCreate(['id' => $request->id],
            [
                'nama_produk' => $request->nama_produk,
                'satuan' => $request->satuan,
                // 'harga_satuan' => $request->harga_satuan,
                'id_gambar' => $request->uid,
            ]);
            
            Bahan::where('produk_id', $produk->id)->delete();
            if(is_array($request->bahan)){
                foreach ($request->bahan as $x => $val) {
                    $ins = new Bahan();
                    $ins->produk_id = $produk->id;
                    $ins->bahan = $val;
                    $ins->harga_satuan = $request->harga_satuan[$x];
                    $ins->save();
                }
            }

            return response()->json(['status'=>true, 'message'=>'Data Berhasil Disimpan!']);
        
        } catch (\Illuminate\Database\QueryException $exception) {
            \DB::rollback();
            $errorInfo = $exception->errorInfo;
            return response()->json(['status'=>false, 'error'=>$errorInfo]);
        }
    }

    public function imageUpload(Request $request)
    {
        $headers = getallheaders();
        
        $request->validate([
            'file' => 'required|max:10480',
        ]);
    
        $imageName = time().'.'.$request->file->extension();  
        $tipe = $request->file->extension();
     
        $request->file->move(public_path('files'), $imageName);

        $attachment = new Attachments();
        $attachment->user_id = auth()->user()->id;
        $attachment->uid = $request->uuid;
        $attachment->url = 'files/'.$imageName;
        $attachment->filename = $imageName;
        $attachment->tipe = $tipe;
        $attachment->save();
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
        $produk = Produk::with('attachments','bahan')->find($id);
        return response()->json($produk);
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
        Produk::find($id)->delete();
        Bahan::where('produk_id',$id)->delete();

        return response()->json(['status'=>true, 'message'=>'Data Berhasil Dihapus!']);
    }

    public function destroyAttach($id)
    {
        try {

            Attachments::find($id)->delete();
            return response()->json(['status'=>true, 'message'=>'Attachment deleted successfully!']);
        
        } catch (\Illuminate\Database\QueryException $exception) {
            \DB::rollback();
            $errorInfo = $exception->errorInfo;
            return response()->json(['status'=>false, 'error'=>$errorInfo]);
        }
    }
}

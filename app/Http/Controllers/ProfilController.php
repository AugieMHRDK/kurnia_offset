<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use DateTime;
use App\Models\User;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Pemesanan;
use App\Models\Attachments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    
    public function index(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->addSelect(\DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y %H:%i") AS tanggal'))->first();
        // dd($user->tanggal);
        $tanggal = $user->tanggal;
        if(auth()->user()->level == 1){
            $count_p = Pemesanan::count();
            $sum_p = Pemesanan::sum('total_harga');
        } else {
            $count_p = Pemesanan::where(['user_id'=>auth()->user()->id])->count();
            $sum_p = Pemesanan::where(['user_id'=>auth()->user()->id])->sum('total_harga');
        }

        $data = [
            'menu'       => 'menu.v_menu_user',
            'content'    => 'content.profil',
            'title'      => 'Profil Anda',
            'notif'      => 'v_notif',
            'count_p'    => $count_p,
            'sum_p'      => $sum_p,
            'tanggal'      => $tanggal
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
        //
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
}

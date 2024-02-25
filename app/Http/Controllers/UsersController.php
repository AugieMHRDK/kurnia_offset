<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\TemplateMsg;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function index(Request $request)
    {
                                       
        $data = [
            // 'count_user' => User::latest()->count(),
            'menu'       => 'menu.'.auth()->user()->menu,
            'content'    => 'content.user',
            'title'      => 'Table User',
            'notif'      => 'v_notif',
        ];

        if ($request->ajax()) {
            $q_user = User::select('*')->orderByDesc('created_at');
            return Datatables::of($q_user)
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
                    ->addColumn('role', function($row){
                        if($row->level == '1'){
                            $role = '<span class="badge badge-success">Admin</span>';
                        } else {
                            $role = '<span class="badge badge-primary">User</span>';
                        }
                        
                        return $role;
                    })
                    ->rawColumns(['action','role'])
                    ->make(true);
        }

        return view('layouts.v_template',$data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        try{
            
            if($request->password == ""){
                $data = [
                        'number'            => $request->number,
                        'name'              => $request->name,
                        'email'             => $request->email,
                        'level'             => $request->level,
                        ];
            } else {
                $data = [
                        'number'            => $request->number,
                        'name'              => $request->name,
                        'email'             => $request->email,
                        'level'             => $request->level,
                        'password'          => Hash::make($request->password),
                        ];
            }

            User::updateOrCreate(['id' => $request->id], $data);
            
            \DB::commit();
                

            return response()->json(['status'=>true, 'message'=>'Data Berhasil Disimpan!']);
        
        } catch (\Illuminate\Database\QueryException $exception) {
            \DB::rollback();
            $errorInfo = $exception->errorInfo;
            return response()->json(['status'=>false, 'error'=>$errorInfo]);
        }
    }

    public function cekPass(Request $request)
    {
        $get_pass = User::find($request->id);

        if($get_pass->password != Hash::make($request->password_lama)){
            return response()->json(['status'=>false, 'error'=>'Password tidak sesuai']);
        }
        return response()->json(['status'=>true]);
    }

    public function edit($id)
    {
        $User = User::find($id);
        return response()->json($User);

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request, $id)
    {
        User::find($id)->delete();
        return response()->json(['status'=>true, 'message'=>'Data Berhasil Dihapus!']);
    }

    public function status()
    {
        $status = User::where('id', auth()->user()->id)->get();
        return response()->json($status);

    }
}

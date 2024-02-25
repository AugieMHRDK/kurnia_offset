<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use DateTime;
use App\Models\Outbox;
use App\Models\Broadcast;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->middleware(function ($request, $next) {
            $this->user_info = Auth::user();
            $this->data_user = User::select('*')->where('level','!=', 0)->where('id','=', $this->user_info->id)->first();
            return $next($request);
        });
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            'menu'       => 'menu.'.auth()->user()->menu,
            'content'    => 'content.laporan',
            'title'      => 'Report Message',
            'notif'      => 'v_notif',
            'user_id'    => auth()->user()->id
        ];

        if ($request->ajax()) {
            $broadcast = Broadcast::where('user_id', auth()->user()->id)->orderBy('broadcast_at','DESC');
            return Datatables::of($broadcast)
                    ->addIndexColumn()
                    ->addColumn('schedule', function($row){
                        if($row->is_schedule == '1'){
                            $schedule = '<span class="badge badge-light-primary">Scheduled</span>';
                        } else {
                            $schedule = '<span class="badge badge-light-success">Broadcast</span>';
                        }
    
                        return $schedule;
                    })
                    ->addColumn('success', function($row){
                        $success = Outbox::where([
                            ['broadcast_id', $row->id],
                            ['status', '!=', 'Q'],
                            ['status', '!=', 'X']
                        ])->count();
    
                        return $success;
                    })
                    ->addColumn('failed', function($row){
                        $success = Outbox::where([
                            ['broadcast_id', $row->id],
                            ['status', '=', 'X']
                        ])->count();
    
                        return $success;
                    })
                    ->addColumn('total', function($row){
                        $success = Outbox::where([
                            ['broadcast_id', $row->id]
                        ])->count();
    
                        return $success;
                    })
                    ->addColumn('detail', function($row){
                        $btn = '<a href="javascript:;" class="btn btn-light-primary btn-sm btn-icon detailReport"  data-id="'.$row->id.'" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Detail Message">
                            <i class="fa fa-eye"></i>
                        </a>';
 
                        return $btn;
                    })
                    ->rawColumns(['schedule','detail'])
                    ->make(true);
                    
        }

        return view('layouts.v_template',$data);
    }

    public function getDetailMessage(Request $request)
    {
        $broadcast = Outbox::where('broadcast_id', $request->id)->orderBy('schedule','DESC');
        return Datatables::of($broadcast)
                ->addIndexColumn()
                ->addColumn('stat', function($row){
                    if($row->status == '0'){
                        $stat = '<span class="badge badge-light">Pending</span>';
                    } else if($row->status == '1'){
                        $stat = '<span class="badge badge-light">Sent</span>';
                    } else if($row->status == '2'){
                        $stat = '<span class="badge badge-light">Received</span>';
                    } else if($row->status == '3'){
                        $stat = '<span class="badge badge-light">Read</span>';
                    } else if($row->status == '4'){
                        $stat = '<span class="badge badge-light">Played</span>';
                    } else if($row->status == 'Q'){
                        $stat = '<span class="badge badge-light">Wait to send</span>';
                    } else {
                        $stat = '<span class="badge badge-danger">Failed</span>';
                    }

                    return $stat;
                })
                ->rawColumns(['stat'])
                ->make(true);

    }

    public function getSession(Request $request)
    {
        if(isset($request->search)){
            $bmt = User::whereNotNull('bmt_id');
            if($this->data_user->level != 1){
                $bmt->where('bmt_id','=',$this->data_user->bmt_id);
            }
            $bmt = $bmt->pluck('bmt_id');
            $session = Bmt::select('nama AS text', 'unit_code AS id')->whereIn('id', $bmt)->where('nama', 'like', '%'.$request->search.'%')->get();
        } else {
            $bmt = User::whereNotNull('bmt_id');
            if($this->data_user->level != 1){
                $bmt->where('bmt_id','=',$this->data_user->bmt_id);
            }
            $bmt = $bmt->pluck('bmt_id');
            $session = Bmt::select('nama AS text', 'unit_code AS id')->whereIn('id', $bmt)->get();
        }
        return response()->json(array('results'=>$session));

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

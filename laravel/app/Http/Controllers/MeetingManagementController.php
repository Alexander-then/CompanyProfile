<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\MeetingManagement;
use App\Events\getTimerEvent;
use DataTables;
use Carbon\Carbon;

class MeetingManagementController extends Controller
{
    public function index(){
        $meeting = MeetingManagement::orderBy('created_at', 'DESC')->get();

        $checkStatus = array_map(array($this, "checkStatus"), $meeting->toArray());

    	return view('admin.meetingManagement');
    }

    public function loadTable(){
    	$meeting = MeetingManagement::orderBy('created_at', 'DESC')->get();

        $checkStatus = array_map(array($this, "checkStatus"), $meeting->toArray());

    	return DataTables::of($meeting)
    		->addIndexColumn()
    		->addColumn('action', function($meeting){
    			$button = '<button type="button" name="edit" id="'.$meeting->id.'" value="'.$meeting->id.'" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>';
    			$button .= '<button type="button" name="delete" id="'.$meeting->id.'" value="'.$meeting->id.'" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';

                if($meeting->status_presentasi == "belum aktif"){
                    $button .= '<button type="button" name="start" id="'.$meeting->id.'" value="'.$meeting->id.'" class="start btn btn-secondary btn-sm" disabled><i class="bi bi-hourglass-split"></i> Waiting</button>';
                }else if($meeting->status_presentasi == "selesai"){
                    $button .= '<button type="button" name="start" id="'.$meeting->id.'" value="'.$meeting->id.'" class="start btn btn-secondary btn-sm" disabled><i class="bi bi-bell-slash"></i> Ended</button>';
                }else{
                    $button .= '<button type="button" name="start" id="'.$meeting->id.'" value="'.$meeting->id.'" class="start btn btn-primary btn-sm" ><i class="fa fa-stopwatch"></i> Mulai</button>';
                }

    			return $button;
    		})
    		->make(true);
    }

    public function store(Request $request) {
    	$validator = Validator::make($request->all(), [
    		'nama_event'=> 'required',
    		'narasumber' => 'required',
    		'jumlah_menit' => 'required',
    		'jam_mulai' => 'required',
    		'jam_selesai' => 'required'
    	]);

    	if($validator->fails()){
    		return Redirect::back()->withErrors($validator->messages());
    	}

    	$meetingManagement = new MeetingManagement();
    	$meetingManagement->nama_event = $request->nama_event;
    	$meetingManagement->narasumber = $request->narasumber;
    	$meetingManagement->jumlah_menit = $request->jumlah_menit;
    	$meetingManagement->sisa_waktu = $request->jumlah_menit * 60;
    	$meetingManagement->status_presentasi = "belum aktif";
        $meetingManagement->status = "belum aktif";
    	$meetingManagement->jam_mulai = $request->jam_mulai;
    	$meetingManagement->jam_selesai = $request->jam_selesai;
    	$meetingManagement->save();

    	return Redirect::back()->with('success', 'Data Berhasil dimasukkan');
    }

    public function editData($id) {
        $meeting = MeetingManagement::find($id);
        return $meeting;
    }

    public function updateData(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_event' => 'required',
            'narasumber' => 'required',
            'jumlah_menit' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        if($validator->fails()){
            $message =  [
                "status" => 'error',
                "message" => $validator->messages()
            ];

            return $message;
        }

        $meeting = MeetingManagement::find($request->id);
        $meeting->nama_event = $request->nama_event;
        $meeting->narasumber = $request->narasumber;
        $meeting->jumlah_menit = $request->jumlah_menit;
        $meeting->sisa_waktu = $request->jumlah_menit * 60;
        $meeting->jam_mulai = $request->jam_mulai;
        $meeting->jam_selesai = $request->jam_selesai;
        $meeting->update();

        $this->loadTable();

        return ["status" => "success"];
    }

    public function deleteData($id){
        $meeting = MeetingManagement::find($id);
        $meeting->delete();

        $this->loadTable();
        return ["message" => "Data berhasil dihapus"];
    }

    private function checkStatus($meeting){
        if(Carbon::now()->format('Y-m-d H:i:s') < $meeting["jam_mulai"]){
            $meeting = $this->updateStatus($meeting["id"], 'belum aktif');
        }else if(Carbon::now()->format('Y-m-d H:i:s') > $meeting["jam_selesai"]){
            $meeting = $this->updateStatus($meeting["id"], 'selesai');
        }else if(Carbon::now()->format('Y-m-d H:i:s') > $meeting["jam_mulai"] && Carbon::now()->format('Y-m-d H:i:s') < $meeting["jam_selesai"]){
            $meeting = $this->updateStatus($meeting["id"], 'aktif');
        }

        return $meeting;
    }

    private function updateStatus($id, $status){
        try {
            $meeting = MeetingManagement::find($id);
            $meeting->status = $status;
            if($meeting->status_presentasi != 'selesai'){
                $meeting->status_presentasi = $status;
            }
            $meeting->slug = Carbon::now()->format('Y-m-').$meeting->nama_event;
            $meeting->update();

            $queryStatus = $status;
        } catch (Exception $e) {
            $queryStatus = "failed";
        }

        return $queryStatus;
    }

    public function startCount($id){
        $meeting = MeetingManagement::find($id);
        if(Carbon::now()->format('Y-m-d H:i:s') > $meeting->jam_selesai){
            return ["status" => "habis"];
        }

        $meeting->waktu_timer = Carbon::now()->format('Y-m-d H:i:s');
        // $meeting->update();

        event(new getTimerEvent($meeting->sisa_waktu, $meeting->waktu_timer, $meeting->jumlah_menit, $meeting->id));

        $meetingData = [
            "id" => $meeting->id,
            "nama_event" => ucfirst($meeting->nama_event),
            "sisa_waktu" => $meeting->sisa_waktu,
            "jam_mulai" => date('H:i',strtotime($meeting->jam_mulai)),
            "jam_selesai" => date('H:i',strtotime($meeting->jam_selesai))
        ];

        $data = ($meeting->sisa_waktu != 0)? ["status" => "aktif", "meeting" => $meetingData] : ["status" => "waktu habis"];

        return $data;
    }

    public function endCount($id){
        $meeting = MeetingManagement::find($id);
        $meeting->sisa_waktu = 0;
        $meeting->status_presentasi = 'selesai';
        $meeting->update();

        $this->loadTable();
    }
}

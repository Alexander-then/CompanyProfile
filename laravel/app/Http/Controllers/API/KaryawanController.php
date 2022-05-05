<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function index(){
        $karyawan = Karyawan::with('media')->get();
        // return $karyawan;
        $Karyawan = [];
        foreach($karyawan as $key => $kary){
            $Karyawan[$key]['id'] = $key;
            $Karyawan[$key]['nama'] = $kary->nama;
            $Karyawan[$key]['jabatan'] = $kary->jabatan;
            $Karyawan[$key]['image'] = $kary->image;

        }
        return response()->json($Karyawan, 200);
    }
}
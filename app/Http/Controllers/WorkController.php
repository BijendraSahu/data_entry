<?php

namespace App\Http\Controllers;

use App\SchoolData;
use App\SchoolValue;
use Carbon\Carbon;
use Illuminate\Http\Request;

session_start();

class WorkController extends Controller
{
    public function works()
    {
        $work_data = SchoolData::get();
        return view('work.view_work')->with(['work_data' => $work_data]);
    }

    public function work_done()
    {
        $work_data = SchoolData::where(['IS_WORK_DONE' => 1])->get();
        return view('work.view_work')->with(['work_data' => $work_data]);
    }

    public function my_works()
    {
        $work_data = SchoolData::where(['IS_WORK_DONE' => 1, 'WORK_DONE_BY' => $_SESSION['admin_master']['id']])->get();
        return view('work.view_work')->with(['work_data' => $work_data]);
    }

    public function view_work_done()
    {
        $work_id = request('work_id');
        $work_data = SchoolData::find($work_id);
        if (isset($work_data)) {
//            $work_value_s_name = SchoolValue::where(['SRID' => $work_data->SRID, 'BLKNM' => 103])->first();
//            $work_value_f_name = SchoolValue::where(['SRID' => $work_data->SRID, 'BLKNM' => 104])->first();
            return view('work.view_work_details')->with(['work_data' => $work_data]);
        } else {
            return view('work.view_work_details')->with([$work_data => []]);
        }
    }

    public function start_work()
    {
//        $work_data = SchoolData::where(['IS_OPEN' => 0, 'IS_WORK_DONE' => 0])->get();
//
//        foreach ($work_data as $work_datum)
//        {
//            $d = '_';
//            $work_datum->IMAGE_PATH = "BSGP_2018/1001/$work_datum->TESTID$d$work_datum->FRMID.jpg";
//            $work_datum->save();
//        }
//        echo "Done";
        $work_data = SchoolData::where(['IS_OPEN' => 0, 'IS_WORK_DONE' => 0])->first();
        if (isset($work_data)) {
            return view('work.create_work')->with(['work_data' => $work_data]);
        } else {
            return view('work.create_work')->with([$work_data => []]);
        }
    }

    public function save_work()
    {
        $data_id = request('data_id');
        $data = SchoolData::find($data_id);
        $data->IS_OPEN = 1;
        $data->IS_WORK_DONE = 1;
        $data->WORK_DONE_BY = $_SESSION['admin_master']->id;
        $data->f103 = request('s_name');
        $data->f104 = request('f_name');
        $data->READTIME = Carbon::now('Asia/Kolkata');
        $data->save();
        return redirect('start_work')->with('message', 'Details has been saved');
    }
}

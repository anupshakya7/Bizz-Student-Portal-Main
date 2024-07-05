<?php

namespace App\Http\Controllers;

use App\Models\CRM\Processing;
use App\Models\CRM\StudentRecordCRM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function index(){
        $std = StudentRecordCRM::where('mobile_number',auth()->user()->mobile)->first();

        if($std){
            $processing = Processing::join('universities','universities.id','=','processing.u_id')->select('processing.*','universities.id','universities.name as uni_name')->where([['std_id',$std->id],['processing_type','primary']])->first();
            $visainterview = DB::connection('mysql2')->table('visa_interview')->where('std_id',$std->id)->select('booked_date','booked_url','passed_on','failed_on','status')->get();

            return view('status.index',compact('std','processing','visainterview'));
        }else{
            $std = [];
            $processing = [];
            $visainterview = [];
            return view('status.index',compact('std','processing','visainterview'));
        }
    }
}

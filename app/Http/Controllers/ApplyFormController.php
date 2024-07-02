<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplyFormController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->cname)) {
            $country = $request->cname;
        } else {
            $country = "";
        }

        if (isset($request->uid)) {
            $university = $request->uid;
        } else {
            $university = "";
        }

        if (isset($request->couid)) {
            $course = $request->couid;
        } else {
            $course = "";
        }

        if (isset($request->couid)) {
            $intake = DB::connection('mysql2')->table('uni_course')->select('course_id', 'intake')->where('uni_id', $university)->where('course_id', $course)->first();
            $months = explode(',', $intake->intake);
            $currentMonth = Carbon::now()->format('M');

            $nextIntakeMonthIndex = -1;
            foreach ($months as $index => $month) {

                // Trim the month to remove any extra spaces or characters
                $trimmedMonth = trim($month);
                if (Carbon::createFromFormat('M', $trimmedMonth)->gt(Carbon::now())) {
                    $nextIntakeMonthIndex = $index;
                    break;
                }
            }

            // If no upcoming intake month is found, set the index to the first month
            if ($nextIntakeMonthIndex === -1) {
                $nextIntakeMonthIndex = 0;
            }

            // Get the next intake month
            $nextIntakeMonth = $months[$nextIntakeMonthIndex];
            $intake_month = str_replace(' ', '', $nextIntakeMonth);
        } else {
            $intake_month = "";
        }

        return view('applyform.index', compact('country', 'university', 'course', 'intake_month'));
    }
}

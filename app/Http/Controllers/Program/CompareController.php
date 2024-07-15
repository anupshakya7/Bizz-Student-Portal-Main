<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompareController extends Controller
{
    public function index(){
        return view('programs.compare.index');
    }

    public function compare(Request $request){
        if($request->filled('university') && $request->filled('course')){
            $select = 'universities.id as uni_id, universities.country as country, universities.logo, universities.name as university, uni_course.intake, uni_course.ielts_requirement, uni_course.pte_requirement, uni_course.tuition_fees,uni_course.scholarship, courses.id as course_id, courses.title as course_title, courses.level';
            $join = 'JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id';
            $where = '';
            $where .= ' AND universities.id='.$request->university.' AND courses.id='.$request->course;

            $query = 'SELECT DISTINCT '.$select.' FROM universities '.$join.' WHERE 1 '.$where.' LIMIT 1';
            $result = DB::connection('mysql2')->selectOne(DB::raw($query));
        }else{
            $result = 'No Result Found';
        }

        return response()->json([
            'status'=>200,
            'result'=>$result
        ]); 
    }
}

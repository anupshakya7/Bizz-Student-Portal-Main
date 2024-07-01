<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CourseSearchController extends Controller
{
    public function index()
    {
        $query = 'SELECT DISTINCT universities.id as id,universities.name as university_name,universities.country as country,universities.logo as university_logo,universities.uni_intake as intake FROM universities JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id WHERE universities.name != "any" AND courses.title !="any" AND universities.status="ON";';

        //Number of items per page
        $perPage = 5;

        //Get the current page from the query parameters
        $page = request()->get('page', 1);

        //Execute the query to get all results
        $results = DB::connection('mysql2')->select(DB::raw($query));

        //Calculate the offset for the items on the current page
        $offset = ($page - 1) * $perPage;

        //Get the items for the current page
        $currentPageItems = array_slice($results, $offset, $perPage);

        //Create a LengthAwarePaginator instance
        $search = new LengthAwarePaginator($currentPageItems, count($results), $perPage, $page, [
            'path' => url()->current(),
            'query' => request()->query(),
        ]);

        $result_count = count($results);
        return view('course-search.index', compact('search', 'result_count'));
    }

    public function advanceSearch(Request $request)
    {
        $query = 'SELECT DISTINCT universities.id as id,universities.name as university_name,universities.country as country,universities.logo as university_logo,universities.uni_intake as intake FROM universities JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id WHERE universities.name != "any" AND courses.title !="any" AND universities.status="ON"';

        if($request->filled('country')) {
            $query .= 'AND universities.country = "'.$request->country.'"';
        }
        if($request->filled('university')) {
            $query .= 'AND universities.id = '.$request->university.'';
        }
        if($request->filled('intake')) {
            $query .= 'AND universities.uni_intake LIKE "'.$request->intake.'"';
        }
        if($request->filled('level')) {
            $query .= 'courses.level = "'.$request->level.'"';
        }
        if($request->filled('stream')) {
            $query .= 'AND courses.stream = "'.$request->level.'"';
        }

        $search = DB::connection('mysql2')->select(DB::raw($query));
        return ;
    }

    //Search University & Courses
    public function searchUniversity(Request $request)
    {
        if(!empty($request->courses) || !empty($request->university)) {
            $select = 'universities.id as uni_id,universities.name as university_name,universities.country as country,universities.logo as university_logo,uni_course.entry_requirement as requirement,uni_course.ielts_requirement,uni_course.pte_requirement,courses.id as courses_id,courses.title as courses_name, courses.level, courses.stream ,uni_course.intake as intake,uni_course.tuition_fees as fees,uni_course.scholarship as scholarship';
            $withoutany = 'AND universities.name != "any" AND courses.title != "any" AND universities.status="ON" AND uni_course.status="on" AND uni_course.intake != ""';
        } else {
            $select = 'universities.id as id,universities.name as university_name,universities.country as country,universities.logo as university_logo,universities.uni_intake as intake';
            $withoutany = 'AND universities.name != "any" AND courses.title != "any" AND universities.status="ON" AND uni_course.status="on"';
        }

        $join = 'JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id';
        $where = '';
        if(isset($request->country) && !empty($request->country)) {
            $where .= ' AND universities.country="'.$request->country.'"';
        }
        if(isset($request->level) && !empty($request->level)) {
            $where .= ' AND courses.level="'.$request->level.'"';
        }
        if(isset($request->stream) && !empty($request->stream)) {
            $where .= ' AND courses.stream="'.$request->stream.'"';
        }
        if(isset($request->university) && !empty($request->university)) {
            $where .= ' AND universities.id="'.$request->university.'"';
        }
        if(isset($request->courses) && !empty($request->courses)) {
            $where .= ' AND courses.id="'.$request->courses.'"';
        }
        if(!empty($request->courses) || !empty($request->university)) {
            if(isset($request->intake) && !empty($request->intake)) {
                $where .= ' AND uni_course.intake LIKE "%'.$request->intake.'%"';
            }
        } else {
            if(isset($request->intake) && !empty($request->intake)) {
                $where .= ' AND universities.uni_intake LIKE "%'.$request->intake.'%"';
            }
        }

        // Your raw SQL query
        $query = 'SELECT DISTINCT '.$select.' FROM universities '.$join.' WHERE 1'.$where.' '.$withoutany.'';

        // Number of items per page
        $perPage = 5;

        // Get the current page from the query parameters
        $page = request()->get('page', 1);

        // Execute the query to get all results
        $results = DB::connection('mysql2')->select(DB::raw($query));

        // Calculate the offset for the items on the current page
        $offset = ($page - 1) * $perPage;

        // Get the items for the current page
        $currentPageItems = array_slice($results, $offset, $perPage);

        // Create a LengthAwarePaginator instance
        $search = new LengthAwarePaginator($currentPageItems, count($results), $perPage, $page, [
            'path' => url()->current(),
            'query' => request()->query(),
        ]);

        $result_count = count($results);

        if(!empty($request->courses) || !empty($request->university)) {
            return view('course-search.partials.course_university', compact('search', 'result_count'))->render();
        } else {
            return view('course-search.partials.other', compact('search', 'result_count'))->render();
        }


    }

    //Filter University
    public function filterUniversity(Request $request)
    {
        $country = $request->country;
        if(!empty($country)) {
            $universities = DB::connection('mysql2')->select('SELECT DISTINCT universities.id as university_id, universities.name as university_name FROM universities JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id WHERE 1 AND universities.name != "any" AND courses.title != "any" AND courses.level!="" AND universities.status="ON" AND universities.country="'.$country.'" ORDER BY universities.name');
        } else {
            $universities = DB::connection('mysql2')->select('SELECT DISTINCT universities.id as university_id, universities.name as university_name FROM universities JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id WHERE 1 AND universities.name != "any" AND courses.title != "any" AND courses.level!="" AND universities.status="ON" ORDER BY universities.name');
        }

        return response()->json([
            'status' => 200,
            'universities' => $universities
        ]);
    }

    //Filter Courses
    public function filterCourse(Request $request)
    {
        $university = $request->university;
        if(!empty($university)) {
            $courses = DB::connection('mysql2')->select('SELECT DISTINCT courses.id as id,courses.title as course FROM universities JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id WHERE 1 AND universities.name != "any" AND courses.title != "any" AND courses.level!="" AND universities.status="ON" AND universities.id="'.$university.'" AND uni_course.status="on" AND courses.title REGEXP "^[A-Za-z]" ORDER BY courses.title');
        } else {
            $courses = DB::connection('mysql2')->select('SELECT DISTINCT courses.id as id,courses.title as course FROM universities JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id WHERE 1 AND universities.name != "any" AND courses.title != "any" AND courses.level!="" AND universities.status="ON" AND uni_course.status="on" AND courses.title REGEXP "^[A-Za-z]" ORDER BY courses.title');
        }

        return response()->json([
            'status' => 200,
            'courses' => $courses
        ]);
    }

    //Filter Intake Month
    public function filterIntake(Request $request)
    {
        $intake = DB::connection('mysql2')->select("SELECT uni_intake FROM `universities` WHERE id=".$request->university.";");
        $intake_key_month = array();
        foreach($intake as $intakemonth) {
            $intake_months = explode(',', $intakemonth->uni_intake);
            foreach($intake_months as $intake_main_month) {
                if($intake_main_month != null) {
                    $full_month = date('F', strtotime($intake_main_month . '01'));
                    if (!array_key_exists($intake_main_month, $intake_key_month)) {
                        $intake_key_month[$intake_main_month] = array('month' => $full_month, 'value' => $intake_main_month);
                    }
                }
            }
        }

        $intake_main = array_values($intake_key_month);
        // Removing duplicates while preserving original order
        $uniqueArray = array_reduce(
            $intake_main,
            function ($carry, $item) {
                $month = $item['month'];
                if (!isset($carry[$month])) {
                    $carry[$month] = $item;
                }
                return $carry;
            },
            []
        );

        // Re-indexing the array to reset keys
        $uniqueArray = array_values($uniqueArray);
        usort($uniqueArray, function ($a, $b) {
            $months = [
                "January" => 1,
                "February" => 2,
                "March" => 3,
                "April" => 4,
                "May" => 5,
                "June" => 6,
                "July" => 7,
                "August" => 8,
                "September" => 9,
                "October" => 10,
                "November" => 11,
                "December" => 12
            ];

            return $months[$a['month']] - $months[$b['month']];
        });

        if (!empty($uniqueArray)) {
            return response()->json([
                'status' => 200,
                'intake' => $uniqueArray
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Intake Month Not Found'
            ]);
        }
    }
}

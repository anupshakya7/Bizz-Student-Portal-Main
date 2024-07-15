@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card p-4 mt-3 shadow">
                <form id="handleSearch">
                    <h3 class="heading text-center">Hi! How can we help You?</h3>
                    <div class="d-flex justify-content-center px-5">
                        <?php
                        $university = Illuminate\Support\Facades\DB::connection('mysql2')->select('SELECT DISTINCT universities.id as university_id, universities.name as university_name FROM universities JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id WHERE 1 AND universities.name != "any" AND courses.title != "any" AND courses.level!="" AND universities.status="ON" ORDER BY universities.name');
                        ?>
                        <div class="search mx-1">
                            <select class="form-select s-example-basic-single university" id="university" name="university"
                                style="width: 150px;">
                                <option value="">Select University</option>
                                @foreach ($university as $universities)
                                    <option value="{{ $universities->university_id }}">{{ $universities->university_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <?php
                        $courses = Illuminate\Support\Facades\DB::connection('mysql2')->select("SELECT DISTINCT courses.id as courses_id,courses.title as courses_title FROM courses JOIN uni_course ON courses.id = uni_course.course_id WHERE courses.title !='any' AND courses.title REGEXP '^[A-Za-z]' ORDER BY courses.title;");
                        ?>
                        <div class="search mx-1">
                            <select class="form-select s-example-basic-single courses" id="courses" name="courses"
                                style="width: 150px;">
                                <option value="">Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->courses_id }}">{{ $course->courses_title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card p-4 mt-3 shadow">
                <div class="loader" id="loader" style="display:none;justify-content:center;margin-top:40px;">
                    <img src="{{ asset('images/loader.gif') }}">
                </div>
                <div class="search_result intake">
                    <div class="search_result_inner boxDesign">
                        <h3>Please Select Course</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 mt-3 shadow">
                <form id="handleSearch">
                    <h3 class="heading text-center">Hi! How can we help You?</h3>
                    <div class="d-flex justify-content-center px-5">
                        <?php
                        $university = Illuminate\Support\Facades\DB::connection('mysql2')->select('SELECT DISTINCT universities.id as university_id, universities.name as university_name FROM universities JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id WHERE 1 AND universities.name != "any" AND courses.title != "any" AND courses.level!="" AND universities.status="ON" ORDER BY universities.name');
                        ?>
                        <div class="search mx-1">
                            <select class="form-select s-example-basic-single university" id="university" name="university"
                                style="width: 150px;">
                                <option value="">Select University</option>
                                @foreach ($university as $universities)
                                    <option value="{{ $universities->university_id }}">{{ $universities->university_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <?php
                        $courses = Illuminate\Support\Facades\DB::connection('mysql2')->select("SELECT DISTINCT courses.id as courses_id,courses.title as courses_title FROM courses JOIN uni_course ON courses.id = uni_course.course_id WHERE courses.title !='any' AND courses.title REGEXP '^[A-Za-z]' ORDER BY courses.title;");
                        ?>
                        <div class="search mx-1">
                            <select class="form-select s-example-basic-single courses" id="courses" name="courses"
                                style="width: 150px;">
                                <option value="">Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->courses_id }}">{{ $course->courses_title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card p-4 mt-3 shadow">
                <div class="loader" id="loader" style="display:none;justify-content:center;margin-top:40px;">
                    <img src="{{ asset('images/loader.gif') }}">
                </div>
                <div class="search_result intake">
                    <div class="search_result_inner boxDesign">
                        <h3>Please Select Course</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('.university').change(function(){
            let university = $(this).val();

            if(university != ""){
                let closestCourses = $(this).closest('form').find('.courses');

                $.ajax({
                    url:"{{route('api.filterCourse')}}",
                    method:"GET",
                    data:{
                        university:university
                    },
                    success:function(response){
                        closestCourses.html('');
                        closestCourses.append('<option value="">Select Courses</option>');
                        $.each(response.courses,function(key,item){
                            closestCourses.append('<option value="' + item.id +'">' + item.course + '</option>');
                        });
                    }
                });
            }
        });

        $('.university,.courses').change(function(){
            let university_id = $(this).closest('form').find('.university').val();
            let courses_id = $(this).closest('form').find('.courses').val();
            if(university_id != "" && courses_id != ""){
                let boxDesign = $(this).closest('.col-md-6').find('.boxDesign');
                let loader = $(this).closest('.col-md-6').find('.loader');
                universityResult(university_id,courses_id,boxDesign,loader);
            }
        });

        function universityResult(university,course,boxDesign,loader){
            loader.css('display','flex');
            $.ajax({
                url:"{{route('compare')}}",
                method:"GET",
                data:{
                    university:university,
                    course:course
                },
                success:function(response){
                    if(response.result != "No Result Found"){
                        let result = response.result;
                        console.log(result);
                        loader.css('display','none');
                        boxDesign.html('');
                        boxDesign.append('<div class="search_result_inner boxDesign">\
                        <div class="row g-0 p-0">\
                            <div class="col-sm-5 border-line equal_height d-flex align-items-end">\
                                <div style="display:inline-block; width:100%;">\
                                    <div class="university_logo text-center">\
                                        <img src="https://mis.bizzeducation.com/backend/web/'+result.logo+'" alt="">\
                                    </div>\
                                    <h5 class="uni_name d-none d-sm-flex">'+result.university+'</h5>\
                                    <div class="location d-none d-sm-flex justify-content-center">\
                                        <h4>'+result.country+'</h4>\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="col-sm-7 border-line ">\
                                <div class="uni_details equal_height">\
                                    <ul class="heading-top">\
                                        <li class="red justify-content-center">'+result.intake+'</li>\
                                        <li class="justify-content-center">'+result.level+'</li>\
                                    </ul>\
                                    <h3 class="text-center">'+result.course_title+'</h3>\
                                    <table>\
                                        <thead>\
                                            <tr>\
                                                <th>Requirements</th>\
                                                <th>IELTS</th>\
                                                <th>PTE</th>\
                                            </tr>\
                                        </thead>\
                                        <tbody>\
                                            <tr>\
                                                <td>'+result.course_title+'</td>\
                                                <td>'+result.ielts_requirement+'</td>\
                                                <td>'+result.pte_requirement+'</td>\
                                            </tr>\
                                        </tbody>\
                                    </table>\
                                    <table>\
                                        <thead>\
                                            <tr>\
                                                <th>Fees</th>\
                                                <th>Scholarship</th>\
                                            </tr>\
                                        </thead>\
                                        <tbody>\
                                            <tr>\
                                                <td>'+(result.tuition_fees ? result.tuition_fees:0)+'</td>\
                                                <td>'+(result.scholarship ? result.scholarship:0)+'</td>\
                                            </tr>\
                                        </tbody>\
                                    </table>\
                                </div>\
                            </div>\
                        </div>\
                    </div>');
                    }else{
                        boxDesign.html('');
                        boxDesign.append('<h3 style="margin: 30px; text-align: center;">Data Not Found</h3>'); 
                    }
                }
            })
        }
    });
</script>
@endsection

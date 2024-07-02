@extends('layout.main')
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card p-4 mt-3 shadow">
            <form id="handleSearch">
                <h3 class="heading text-center">Hi! How can we help You?</h3>
                <div class="d-flex justify-content-center px-5">

                    <div class="search mx-1">
                        <select class="form-select" id="country" name="country" style="width: 150px;">
                            <option value="">Select Country</option>
                            <option value="Australia">Australia</option>
                            <option value="UK">UK</option>
                            <option value="Canada">Canada</option>
                        </select>
                    </div>
                    <?php
                        $university = Illuminate\Support\Facades\DB::connection('mysql2')->select('SELECT DISTINCT universities.id as university_id, universities.name as university_name FROM universities JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id WHERE 1 AND universities.name != "any" AND courses.title != "any" AND courses.level!="" AND universities.status="ON" ORDER BY universities.name');
                        ?>
                    <div class="search mx-1">
                        <select class="form-select s-example-basic-single" id="university" name="university"
                            style="width: 150px;">
                            <option value="">Select University</option>
                            @foreach ($university as $universities)
                            <option value="{{ $universities->university_id }}">{{ $universities->university_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search mx-1">
                        <select class="form-select select2" id="intake" name="intake" aria-placeholder="Intake Month"
                            style="width: 150px;">
                            <option value="">Select Intake</option>
                            <option value="Jan">Jan</option>
                            <option value="Feb">Feb</option>
                            <option value="Mar">Mar</option>
                            <option value="Apr">Apr</option>
                            <option value="May">May</option>
                            <option value="Jun">Jun</option>
                            <option value="Jul">Jul</option>
                            <option value="Aug">Aug</option>
                            <option value="Sep">Sep</option>
                            <option value="Oct">Oct</option>
                            <option value="Nov">Nov</option>
                            <option value="Dec">Dec</option>
                        </select>
                    </div>
                    <?php
                        $course = Illuminate\Support\Facades\DB::connection('mysql2')->select("SELECT DISTINCT courses.id as courses_id,courses.title as courses_title FROM courses JOIN uni_course ON courses.id = uni_course.course_id WHERE courses.title !='any' AND courses.title REGEXP '^[A-Za-z]' ORDER BY courses.title;");
                        ?>
                    <div class="search mx-1">
                        <select class="form-select s-example-basic-single" id="courses" name="courses"
                            style="width: 150px;">
                            <option value="">Select Course</option>
                            @foreach ($course as $courses)
                            <option value="{{ $courses->courses_id }}">{{ $courses->courses_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <?php
                        $level = Illuminate\Support\Facades\DB::connection('mysql2')->select('SELECT DISTINCT courses.level as levels FROM universities JOIN uni_course ON universities.id = uni_course.uni_id JOIN courses ON uni_course.course_id = courses.id WHERE 1 AND universities.name != "any" AND courses.title != "any" AND courses.level!="" AND universities.status="ON";');
                        ?>
                    <div class="search mx-1">
                        <select class="form-select" id="level" name="level" style="width: 150px;">
                            <option value="">Select level</option>
                            @foreach ($level as $levels)
                            <option value="{{ $levels->levels }}">{{ $levels->levels }}</option>
                            @endforeach
                        </select>
                    </div>
                    <?php
                        $stream = Illuminate\Support\Facades\DB::connection('mysql2')->select("SELECT DISTINCT courses.stream as stream FROM courses JOIN uni_course ON courses.id = uni_course.course_id WHERE courses.stream IS NOT NULL AND courses.stream !='' ORDER BY courses.stream");
                        ?>
                    <div class="search mx-1">
                        <select class="form-select s-example-basic-single" id="stream" name="stream"
                            style="width: 150px;">
                            <option value="">Select Stream</option>
                            @foreach ($stream as $streams)
                            <option value="{{ $streams->stream }}">{{ $streams->stream }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card p-4 mt-3 shadow">
            <h5 class="heading text-center">Advanced Search</h5>
            <div>
                <div class="search my-1">
                    <label for="fees" class="form-label">Fees (0 to <span id="fees_range"></span>)</label>
                    <input type="range" class="form-range" name="fees" min="0" max="20000" step="500" value="0"
                        id="fees" disabled>
                </div>
                <div class="search my-1">
                    <label for="duration" class="form-label">Scholarships (0 to <span
                            id="scholarships_range"></span>)</label>
                    <input type="range" class="form-range" name="scholarship" min="0" max="5000" step="100" value="0"
                        id="scholarship" disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="card p-4 mt-3 shadow">
            <div class="search-top">
                <div class="count">
                    <span class="number" id="count_unversities">{{ $result_count }}</span>
                    <span class="text"><span id="search_type">University</span> available</span>
                </div>
            </div>
            <div class="loader" id="loader" style="display:none;justify-content:center;margin-top:40px;">
                <img src="{{ asset('images/loader.gif') }}">
            </div>
            <div class="search_result course" style="display:none" id="result_course_university">

            </div>

            <div class="search_result intake" id="result_without_course_university">
                <div class="row" id="other_search_row">
                    @if (count($search) > 0)
                    @foreach ($search as $searchdata)
                    <div class="col-md-12">
                        <div class="search_result_inner">
                            <div class="row g-0 p-0">
                                <div class="col-sm-7 border-line equal_height">
                                    <div style="display:inline-block; width:100%;">
                                        <div class="university_logo text-center">
                                            <a onClick="universitySelect({{ $searchdata->id }})"
                                                style="cursor: pointer !important;">
                                                <img src="https://mis.bizzeducation.com/backend/web/{{ $searchdata->university_logo }}"
                                                    alt="">
                                            </a>
                                        </div>

                                        <h5 class="uni_name">{{ $searchdata->university_name }}</h5>
                                        <div class="location justify-content-center">
                                            <!--<img src="https://cdn.britannica.com/25/4825-004-F1975B92/Flag-United-Kingdom.jpg" alt="">-->
                                            <h4 class="text-center">{{ $searchdata->country }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5 border-line ">
                                    <div class="uni_details equal_height">
                                        <ul class="heading-top">
                                            <li class="red">Available Intake</li>
                                        </ul>
                                        @if (!empty($searchdata->intake))
                                        <h3>{{ $searchdata->intake }}</h3>
                                        @else
                                        <h3>Intake Month Not Found</h3>
                                        @endif
                                        <div class="button text-end">
                                            <form method="GET" action="{{route('applynow.index')}}">
                                                <input type="hidden" name="cname" value="{{ $searchdata->country }}">
                                                <input type="hidden" name="uid" value="{{ $searchdata->id }}">
                                                <button type="submit" class="btn btn-button btn-primary">Apply</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="d-flex justify-content-center">
                        {!! $search->onEachSide(1)->links() !!}
                    </div>
                    @else
                    <h3 style="margin: 30px; text-align: center;">Data Not Found</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#fees').change(function() {
            var fees = $(this).val();
            $('#fees_range').text(fees);
        });

        $('#scholarship').change(function() {
            var scholarship = $(this).val();
            $('#scholarships_range').text(scholarship);
        });
    });


    //Search Part
    $(document).ready(function() {
        $('.s-example-basic-single').select2();
        $('#country,#level,#stream,#intake,#university,#courses').on('change', function(e) {
            e.preventDefault();
            search();
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            events(page);
        });

        //Filter University
        $('#country').change(function() {
            let country = $('#country').val();
            $.ajax({
                url: "{{ route('api.filterUniversity') }}",
                method: "GET",
                data: {
                    country: country
                },
                success: function(response) {
                    //console.log(response);
                    $('#university').html('');
                    $('#university').append('<option value="">Select University</option>');
                    $.each(response.universities, function(key, item) {
                        $('#university').append('<option value="' + item
                            .university_id + '">' + item.university_name +
                            '</option>');
                    });
                }

            });


        });

        $('#university').change(function() {
            let university = $('#university').val();

            if (university != "") {
                $.ajax({
                    url: "{{ route('api.filterCourse') }}",
                    method: "GET",
                    data: {
                        university: university
                    },
                    success: function(response) {
                        console.log(response);
                        $('#courses').html('');
                        $('#courses').append(' <option value="">Select Courses</option>');
                        $.each(response.courses, function(key, item) {
                            $('#courses').append('<option value="' + item.id +
                                '">' + item.course + '</option>');
                        });
                    }
                });

                $.ajax({
                    url: "{{route('api.filterIntakemonth')}}",
                    method: "GET",
                    data: {
                        university: university
                    },
                    success: function(response) {
                        $('#intake').html('');
                        $('#intake').append(' <option value="">Select Intake</option>');
                        $.each(response.intake, function(key, item) {
                            $(intake).append('<option value="' + item.value + '">' +
                                item.month + '</option>');
                        });
                    }
                });
            }
        });

        //
    });


    function universitySelect(id) {
        $('#university').val(id).change();
    }

    function events(page) {
        let country = $('#country').val();
        let level = $('#level').val();
        let stream = $('#stream').val();
        let intake = $('#intake').val();
        let university = $('#university').val();
        let courses = $('#courses').val();
        let url = '';
        let search = '';
        if (country != "" || level != "" || stream != "" || intake != "" || university != "" || courses != "") {
            if (country != "") {
                if (search == "") {

                } else {
                    search += '&';
                }
                search += 'country=' + country;
            }
            if (level != "") {
                if (search == "") {

                } else {
                    search += '&';
                }
                search += 'level=' + level;
            }
            if (stream != "") {
                if (search == "") {

                } else {
                    search += '&';
                }
                search += 'stream=' + stream;
            }
            if (intake != "") {
                if (search == "") {

                } else {
                    search += '&';
                }
                search += 'intake=' + intake;
            }
            if (university != "") {
                if (search == "") {

                } else {
                    search += '&';
                }
                search += 'university=' + university;
            }
            if (courses != "") {
                if (search == "") {

                } else {
                    search += '&';
                }
                search += 'courses=' + courses;
            }
            url = 'http://127.0.0.1:8000/courses/universities-api-search?' + search + '&page=' + page
        } else {
            url = 'http://127.0.0.1:8000/courses/universities-api-search?page=' + page
        }
        console.log(url);
        $.ajax({
            url: url,
            success: function(res) {
                if (university != "" || courses != "") {
                    $('#result_course_university').html(res);
                } else {
                    $('#result_without_course_university').html(res);
                }
                $(".equal_height").matchHeight();
                $(".equal_height_inner").matchHeight();
            }

        });
    }

    function search() {
        let country = $('#country').val();
        let level = $('#level').val();
        let stream = $('#stream').val();
        let intake = $('#intake').val();
        let university = $('#university').val();
        let courses = $('#courses').val();

        //console.log('country: '+country+'level: '+level+'stream: '+stream+'intake: '+intake+'unversity: '+unversity+'courses: '+courses);

        $('#loader').css('display', 'flex');
        $('#result_without_course_university').html('');
        $('#result_without_course_university').css('display', 'none');
        $('#result_course_university').html('');
        $('#result_course_university').css('display', 'none');
        if (country != "" || level != "" || stream != "" || intake != "" || university != "" || courses != "") {
            $.ajax({
                url: "{{ route('university.searchapi') }}",
                method: 'GET',
                data: {
                    country: country,
                    level: level,
                    stream: stream,
                    intake: intake,
                    university: university,
                    courses: courses,
                },
                success: function(response) { 
                    $('#result_without_course_university').html('');
                    $('#result_course_university').html('');
                    if (courses != '' || university != '') {
                        $('#result_without_course_university').css('display', 'none');
                        $('#result_course_university').css('display', '');
                        $('#fees').attr('disabled',false);
                        $('#scholarship').attr('disabled',false);
                        $('#loader').css('display', 'none');
                        $('#result_course_university').html(response);
                        $(".equal_height").matchHeight();
                        $(".equal_height_inner").matchHeight();
                        $(".heading-top li").matchHeight();
                        $('#search_type').text("Course");
                    } else {
                        $('#result_course_university').css('display', 'none');
                        $('#result_without_course_university').css('display', '');
                        $('#fees').attr('disabled',true);
                        $('#scholarship').attr('disabled',true);
                        $('#loader').css('display', 'none');
                        $('#result_without_course_university').html(response);
                        $(".equal_height").matchHeight();
                        $(".equal_height_inner").matchHeight();
                        $('#search_type').text("University");
                    }
                    let countData = $('#count_result').val();
                    //console.log(countData);	

                    if (countData > 0) {
                        $('#count_unversities').text(countData);
                    } else {
                        $('#count_unversities').text('0');
                    }
                }
            });
        } else {
            $('#loader').css('display', 'none');
            $('#result_without_course_university').html('');
            $('#result_without_course_university').css('display', 'none');
            $('#result_course_university').html('');
            $('#result_course_university').css('display', 'none');
            $('#count_unversities').text('0');
        }
    }
</script>
@endsection
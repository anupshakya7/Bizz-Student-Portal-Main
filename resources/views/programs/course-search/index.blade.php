@extends('layout.main')
@section('style')
    <style>
        .wrapper {
            padding: 20px;
        }

        .fees-price-input,
        .scholarship-price-input {
            width: 100%;
            display: flex;
            margin: 30px 0 35px;
        }

        .fees-price-input .field,
        .scholarship-price-input .field {
            display: flex;
            width: 100%;
            height: 45px;
            align-items: center;
        }

        .field input {
            width: 100%;
            height: 100%;
            outline: none;
            font-size: 19px;
            margin-left: 7px;
            border-radius: 5px;
            text-align: center;
            border: 1px solid #999;
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .fees-price-input .separator,
        .scholarship-price-input .separator {
            width: 130px;
            display: flex;
            font-size: 19px;
            align-items: center;
            justify-content: center;
        }

        .fees-slider,
        .scholarship-slider {
            height: 5px;
            position: relative;
            background: #ddd;
            border-radius: 5px;
        }

        .fees-slider .fees-progress {
            height: 100%;
            left: 25%;
            right: 44%;
            position: absolute;
            border-radius: 5px;
            background: #17a2b8;
        }

        .scholarship-slider .scholarship-progress {
            height: 100%;
            left: 15%;
            right: 43%;
            position: absolute;
            border-radius: 5px;
            background: #17a2b8;
        }

        .fees-range-input,
        .scholarship-range-input {
            position: relative;
        }

        .fees-range-input input {
            position: absolute;
            width: 100%;
            height: 5px;
            top: -5px;
            background: none;
            pointer-events: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .scholarship-range-input input {
            position: absolute;
            width: 100%;
            height: 5px;
            top: -5px;
            background: none;
            pointer-events: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        input[type="range"]::-webkit-slider-thumb {
            height: 17px;
            width: 17px;
            border-radius: 50%;
            background: #17a2b8;
            pointer-events: auto;
            -webkit-appearance: none;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
        }

        input[type="range"]::-moz-range-thumb {
            height: 17px;
            width: 17px;
            border: none;
            border-radius: 50%;
            background: #17a2b8;
            pointer-events: auto;
            -moz-appearance: none;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection
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
                            <select class="form-select select2" id="intake" name="intake"
                                aria-placeholder="Intake Month" style="width: 150px;">
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
                        $courses = Illuminate\Support\Facades\DB::connection('mysql2')->select("SELECT DISTINCT courses.id as courses_id,courses.title as courses_title FROM courses JOIN uni_course ON courses.id = uni_course.course_id WHERE courses.title !='any' AND courses.title REGEXP '^[A-Za-z]' ORDER BY courses.title;");
                        ?>
                        <div class="search mx-1">
                            <select class="form-select s-example-basic-single" id="courses" name="courses"
                                style="width: 150px;">
                                <option value="">Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->courses_id }}">{{ $course->courses_title }}</option>
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
        <div class="col-sm-4">
            <div class="card p-4 mt-3 shadow">
                <h5 class="heading text-center">Advanced Search</h5>
                <div>
                    <div class="loader" id="adv-loader" style="display:none;justify-content:center;margin-top:40px;">
                        <img src="{{ asset('images/loader.gif') }}">
                    </div>
                    <div class="wrapper">
                        <label for="">Tuition Fees</label>
                        <div class="fees-price-input">
                            <div class="field">
                                <span>Min</span>
                                <input type="number" class="fees-input-min" value="10000" disabled>
                            </div>
                            <div class="separator">-</div>
                            <div class="field">
                                <span>Max</span>
                                <input type="number" class="fees-input-max" value="30000" disabled>
                            </div>
                        </div>
                        <div class="fees-slider">
                            <div class="fees-progress"></div>
                        </div>
                        <div class="fees-range-input">
                            <input type="range" class="fees-range-min" min="0" max="50000" value="10000"
                                step="100" name="min_fees" id="min_fees" disabled>
                            <input type="range" class="fees-range-max" min="0" max="50000" value="30000"
                                step="100" name="max_fees" id="max_fees" disabled>
                        </div>
                    </div>

                    <div class="wrapper">
                        <label for="">Scholarship</label>
                        <div class="scholarship-price-input">
                            <div class="field">
                                <span>Min</span>
                                <input type="number" class="scholarship-input-min" value="1000" disabled>
                            </div>
                            <div class="separator">-</div>
                            <div class="field">
                                <span>Max</span>
                                <input type="number" class="scholarship-input-max" value="6000" disabled>
                            </div>
                        </div>
                        <div class="scholarship-slider">
                            <div class="scholarship-progress"></div>
                        </div>
                        <div class="scholarship-range-input">
                            <input type="range" class="scholarship-range-min" min="0" max="10000"
                                value="1000" step="100" name="min_scholarship" id="min_scholarship" disabled>
                            <input type="range" class="scholarship-range-max" min="0" max="10000"
                                value="6000" step="100" name="max_scholarship" id="max_scholarship" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
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
                                                        <form method="GET" action="{{ route('applynow.index') }}">
                                                            <input type="hidden" name="cname"
                                                                value="{{ $searchdata->country }}">
                                                            <input type="hidden" name="uid"
                                                                value="{{ $searchdata->id }}">
                                                            <button type="submit"
                                                                class="btn btn-button btn-primary">Apply</button>
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
        //Search Part
        $(document).ready(function() {
            $('.s-example-basic-single').select2();

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

            //Filter Courses and Intake
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
                        url: "{{ route('api.filterIntakemonth') }}",
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

            //Search University and Courses
            $('#country,#level,#stream,#intake,#university,#courses,#min_fees,#max_fees,#min_scholarship,#max_scholarship')
                .on('change', function(e) {
                    e.preventDefault();
                    search();
                });

            //Pagination Listed Data
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                events(page);
            });
        });

        //OnClick Function For Logo
        function universitySelect(id) {
            $('#university').val(id).change();
        }

        //Function For Pagination
        function events(page) {
            let country = $('#country').val();
            let level = $('#level').val();
            let stream = $('#stream').val();
            let intake = $('#intake').val();
            let university = $('#university').val();
            let courses = $('#courses').val();
            var minfees = '';
            var maxfees = '';
            var minscholarship = '';
            var maxscholarship = '';
            if (university != "" || courses != "") {
                minfees = $('#min_fees').val();
                maxfees = $('#max_fees').val();
                minscholarship = $('#min_scholarship').val();
                maxscholarship = $('#max_scholarship').val();
            }else{
                minfees = '';
                maxfees = '';
                minscholarship = '';
                maxscholarship = ''; 
            }
            getFeesScholarship(university,courses);

            let url = '';
            let search = '';
            if (country != "" || level != "" || stream != "" || intake != "" || university != "" || courses != "" ||
                minfees !=
                "" || maxfees != "" || minscholarship != "" || maxscholarship != "") {
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
                if (minfees != "" && maxfees != "") {
                    if (search == "") {

                    } else {
                        search += '&';
                    }
                    search += 'minfees=' + minfees + '&maxfees=' + maxfees;
                }
                if (minscholarship != "" && maxscholarship != "") {
                    if (search == "") {

                    } else {
                        search += '&';
                    }
                    search += 'minscholarship=' + minscholarship + '&maxscholarship=' + maxscholarship;
                }

                url = 'http://127.0.0.1:8000/courses/universities-api-search?' + search + '&page=' + page
            } else {
                url = 'http://127.0.0.1:8000/courses/universities-api-search?page=' + page
            }
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
            var minfees = '';
            var maxfees = '';
            var minscholarship = '';
            var maxscholarship = '';
            if (university != "" || courses != "") {
                minfees = $('#min_fees').val();
                maxfees = $('#max_fees').val();
                minscholarship = $('#min_scholarship').val();
                maxscholarship = $('#max_scholarship').val();
            }else{
                minfees = '';
                maxfees = '';
                minscholarship = '';
                maxscholarship = ''; 
            }
            getFeesScholarship(university,courses);

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
                        minfees: minfees,
                        maxfees: maxfees,
                        minscholarship: minscholarship,
                        maxscholarship: maxscholarship
                    },
                    success: function(response) {
                        $('#result_without_course_university').html('');
                        $('#result_course_university').html('');
                        if (courses != '' || university != '') {
                            $('#result_without_course_university').css('display', 'none');
                            $('#result_course_university').css('display', '');
                            $('#fees').attr('disabled', false);
                            $('#scholarship').attr('disabled', false);
                            $('#loader').css('display', 'none');
                            $('#result_course_university').html(response);
                            $(".equal_height").matchHeight();
                            $(".equal_height_inner").matchHeight();
                            $(".heading-top li").matchHeight();
                            $('#search_type').text("Course");
                        } else {
                            $('#result_course_university').css('display', 'none');
                            $('#result_without_course_university').css('display', '');
                            $('#fees').attr('disabled', true);
                            $('#scholarship').attr('disabled', true);
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

        function getFeesScholarship(university,courses) {
            if (university != "" || courses != "") {
                $('#min_fees').attr('disabled', false);
                $('#max_fees').attr('disabled', false);
                $('#min_scholarship').attr('disabled', false);
                $('#max_scholarship').attr('disabled', false); 
            } else {
                $('#min_fees').attr('disabled', true);
                $('#max_fees').attr('disabled', true);
                $('#min_scholarship').attr('disabled', true);
                $('#max_scholarship').attr('disabled', true);
            }
        }
    </script>
    <script>
        //Fees Input
        const feeRangeInput = document.querySelectorAll(".fees-range-input input"),
            feePriceInput = document.querySelectorAll(".fees-price-input input"),
            feeRange = document.querySelector(".fees-slider .fees-progress");
        let priceGap = 1000;

        feePriceInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minPrice = parseInt(feePriceInput[0].value),
                    maxPrice = parseInt(feePriceInput[1].value);

                if (maxPrice - minPrice >= priceGap && maxPrice <= feeRangeInput[1].max) {
                    if (e.target.className === "fees-input-min") {
                        feeRangeInput[0].value = minPrice;
                        feeRange.style.left = (minPrice / feeRangeInput[0].max) * 100 + "%";
                    } else {
                        feeRangeInput[1].value = maxPrice;
                        feeRange.style.right = 100 - (maxPrice / feeRangeInput[1].max) * 100 + "%";
                    }
                }
            });
        });

        feeRangeInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minVal = parseInt(feeRangeInput[0].value),
                    maxVal = parseInt(feeRangeInput[1].value);
                if (maxVal - minVal < priceGap) {
                    if (e.target.className === "fees-range-min") {
                        feeRangeInput[0].value = maxVal - priceGap;
                    } else {
                        feeRangeInput[1].value = minVal + priceGap;
                    }
                } else {
                    feePriceInput[0].value = minVal;
                    feePriceInput[1].value = maxVal;
                    feeRange.style.left = (minVal / feeRangeInput[0].max) * 100 + "%";
                    feeRange.style.right = 100 - (maxVal / feeRangeInput[1].max) * 100 + "%";
                }
            });
        });

        //Scholarship Input
        const scholarshipRangeInput = document.querySelectorAll(".scholarship-range-input input"),
            scholarshipPriceInput = document.querySelectorAll(".scholarship-price-input input"),
            scholarshipRange = document.querySelector(".scholarship-slider .scholarship-progress");

        scholarshipPriceInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minPrice = parseInt(scholarshipPriceInput[0].value),
                    maxPrice = parseInt(scholarshipPriceInput[1].value);

                if (maxPrice - minPrice >= priceGap && maxPrice <= scholarshipRangeInput[1].max) {
                    if (e.target.className === "scholarship-input-min") {
                        scholarshipRangeInput[0].value = minPrice;
                        scholarshipRange.style.left = (minPrice / scholarshipRangeInput[0].max) * 100 + "%";
                    } else {
                        scholarshipRangeInput[1].value = maxPrice;
                        scholarshipRange.style.right = 100 - (maxPrice / scholarshipRangeInput[1].max) *
                            100 + "%";
                    }
                }
            });
        });

        scholarshipRangeInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minVal = parseInt(scholarshipRangeInput[0].value),
                    maxVal = parseInt(scholarshipRangeInput[1].value);
                if (maxVal - minVal < priceGap) {
                    if (e.target.className === "scholarship-range-min") {
                        scholarshipRangeInput[0].value = maxVal - priceGap;
                    } else {
                        scholarshipRangeInput[1].value = minVal + priceGap;
                    }
                } else {
                    scholarshipPriceInput[0].value = minVal;
                    scholarshipPriceInput[1].value = maxVal;
                    scholarshipRange.style.left = (minVal / scholarshipRangeInput[0].max) * 100 + "%";
                    scholarshipRange.style.right = 100 - (maxVal / scholarshipRangeInput[1].max) * 100 +
                        "%";
                }
            });
        });
    </script>
@endsection

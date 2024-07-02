@extends('layout.main')
@section('content')
    <!-- start form -->
    <div class="mt-5">
        <div class="new-about-wrapper" id="apply_now">
            <div class="row m-0 p-0">
                <form method="post" class="col-md-12" action="#" enctype="multipart/form-data">
                    @csrf
                    <?php
                    $crm_universities = DB::connection('mysql2')->table('universities')->where('status', 'on')->get();
                    $countriess = DB::connection('mysql2')->select('SELECT DISTINCT universities.country FROM `universities` JOIN uni_course ON universities.id=uni_course.uni_id WHERE universities.status="On" ORDER BY universities.country;');
                    if (isset($course) && !empty($course)) {
                        $courses = DB::connection('mysql2')->table('courses')->select('id', 'title')->where('id', $course)->first();
                    }
                    $user_info = auth()->user();
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card p-4" id="Register_Now">
                                <div class="new-form-wrapper row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fullname">Full Name<span class="text-danger sign">*</span></label>
                                            <input type="text" class="form-control" id="fullname" name="fullname"
                                                value="{{ old('fullname', $user_info->firstname . ' ' . $user_info->lastname) }}"
                                                placeholder="Ex : John" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="phone">Contact Number<span
                                                    class="text-danger sign">*</span></label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="{{ old('phone') }}" placeholder="9841XXXXXX" maxlength="10" disabled
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger sign">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email', $user_info->email) }}" placeholder="abc@gmail.com"
                                                disabled required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="address">Address <span class="text-danger sign">*</span></label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                value="{{ old('address') }}" placeholder="Your Location">
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group custom-select">
                                            <label for="interest_country">Interested Country <span
                                                    class="text-danger sign">*</span></label>
                                            <select name="interest_country" id="interest_country" class="form-control"
                                                @if (isset($country) && !empty($country)) disabled @endif required>
                                                <option value="" selected="selected">Please Select</option>
                                                @foreach ($countriess as $countrywithcourse)
                                                    <option @if (isset($country) && !empty($country) && $country == $countrywithcourse->country) selected @endif
                                                        value="{{ $countrywithcourse->country }}">
                                                        {{ $countrywithcourse->country }}</option>
                                                @endforeach
                                            </select>
                                            @if (isset($country) && !empty($country))
                                                <input type="hidden" name="interest_country" value="{{ $country }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="university">Choose University <span
                                                    class="text-danger sign">*</span></label>
                                            <select name="university" id="university" class="s-example-basic-single"
                                                disabled required>
                                                <option value="" selected="selected">Please Select</option>
                                                @foreach ($crm_universities as $universitys)
                                                    <option @if (isset($university) && !empty($university) && $university == $universitys->id) selected @endif
                                                        value="{{ $universitys->id }}">{{ $universitys->name }}</option>
                                                @endforeach
                                            </select>
                                            @if (isset($university) && !empty($university))
                                                <input type="hidden" name="university" value="{{ $university }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="intake">Choose Intake Month <span
                                                    class="text-danger sign">*</span></label>
                                            @if (isset($intake_month) && !empty($intake_month))
                                                <select name="intake" class="form-select" disabled required>
                                                    <option @if ($intake_month == 'Jan') selected @endif
                                                        value="Jan">
                                                        January</option>
                                                    <option @if ($intake_month == 'Feb') selected @endif
                                                        value="Feb">
                                                        February</option>
                                                    <option @if ($intake_month == 'March') selected @endif
                                                        value="March">
                                                        March</option>
                                                    <option @if ($intake_month == 'Apr') selected @endif
                                                        value="Apr">
                                                        April</option>
                                                    <option @if ($intake_month == 'May') selected @endif
                                                        value="May">
                                                        May</option>
                                                    <option @if ($intake_month == 'Jun') selected @endif
                                                        value="Jun">
                                                        June</option>
                                                    <option @if ($intake_month == 'Jul') selected @endif
                                                        value="Jul">
                                                        July</option>
                                                    <option @if ($intake_month == 'Aug') selected @endif
                                                        value="Aug">
                                                        August</option>
                                                    <option @if ($intake_month == 'Sept') selected @endif
                                                        value="Sept">
                                                        September</option>
                                                    <option @if ($intake_month == 'Oct') selected @endif
                                                        value="Oct">
                                                        October</option>
                                                    <option @if ($intake_month == 'Nov') selected @endif
                                                        value="Nov">
                                                        November</option>
                                                    <option @if ($intake_month == 'Dec') selected @endif
                                                        value="Dec">
                                                        December</option>
                                                </select>
                                                <input type="hidden" name="intake" value="{{ $intake_month }}">
                                            @else
                                                <select name="intake" id="intake" class="form-select"
                                                    @if (!isset($university) && empty($university)) disabled @endif required>
                                                    <option value="" selected="selected">Please Select</option>
                                                    <option value="Jan">January</option>
                                                    <option value="Feb">February</option>
                                                    <option value="March">March</option>
                                                    <option value="Apr">April</option>
                                                    <option value="May">May</option>
                                                    <option value="Jun">June</option>
                                                    <option value="Jul">July</option>
                                                    <option value="Aug">August</option>
                                                    <option value="Sept">September</option>
                                                    <option value="Oct">October</option>
                                                    <option value="Nov">November</option>
                                                    <option value="Dec">December</option>
                                                </select>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group custom-select">

                                            <label for="int_course_level">Interested Course <span
                                                    class="text-danger sign">*</span></label>
                                            @if (isset($course) && !empty($course))
                                                <select name="int_course_level" class="s-example-basic-single" disabled
                                                    required>
                                                    <option value="{{ $courses->id }}" selected="selected"
                                                        class="gf_placeholder">{{ $courses->title }}</option>
                                                </select>
                                                <input type="hidden" name="int_course_level"
                                                    value="{{ $courses->id }}">
                                            @else
                                                <select name="int_course_level" id="course"
                                                    class="s-example-basic-single" disabled required>
                                                    <option value="" selected="selected" class="gf_placeholder">
                                                        Please
                                                        Select:</option>
                                                </select>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="form-group custom-select">
                                            <label for="qualification">Last Academic Qualification <span
                                                    class="text-danger sign">*</span></label>
                                            <select name="qualification" class="form-select" required>
                                                <option value="" selected="selected">Please Select</option>
                                                <option value="+2">+2</option>
                                                <option value="Diploma">Diploma</option>
                                                <option value="Bachelor">Bachelor</option>
                                                <option value="Master">Master</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="english">Academic Scores <span
                                                    class="text-danger sign">*</span></label>
                                            <input type="text" class="form-control" id="score" name="score"
                                                placeholder="Your Scores" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group custom-select">
                                            <label for="english">English</label>
                                            <select name="english" class="form-select">
                                                <option value="" selected="selected" class="gf_placeholder">Please
                                                    Select:</option>
                                                <option value="+2">+2</option>
                                                <option value="IELTS">IELTS</option>
                                                <option value="PTE">PTE</option>
                                                <option value="Duolingo">Duolingo</option>
                                                <option value="Oxford Test">Oxford Test</option>
                                                <option value="TOFEL">TOFEL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="english">English Scores</label>
                                            <input type="text" class="form-control" id="eng_score" name="eng_score"
                                                placeholder="Eg: B">
                                        </div>
                                    </div>


                                    <div class="col-md-6 ">
                                        <div class="form-group custom-select">
                                            <label for="passed_year">Passed Year <span
                                                    class="text-danger sign">*</span></label>
                                            <select name="passed_year" id="passed_year" class="form-control" required>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="form-group custom-select">
                                            <label for="intake_year">Choose Intake Year</label>
                                            <select name="intake_year" id="intake_year" class="form-control">
                                                <option value="2024" selected>2024</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" id="Register_Now">
                            <div class="card p-4">
                                <div class="new-form-wrapper px-3">
                                    <div class="col-lg-12">
                                        <div class="choose-title">Choose Files</div>
                                    </div>
                                    <div class="row p-0 m-0">
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="master">Master Degree Certificate</label>
                                                <input name="con_doc[]" type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="bachelor">Bachelor Degree Certificate</label>
                                                <input name="con_doc[]" type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="diploma">Diploma</label>
                                                <input name="con_doc[]" type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="grade">Grade 12 Certificate</label>
                                                <input name="con_doc[]" type="file" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="cv">CV</label>
                                                <input name="con_doc[]" type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="passport">Passport</label>
                                                <input name="con_doc[]" type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="ielts">IELTS</label>
                                                <input name="con_doc[]" type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="oxford">Oxford (ELLT) English</label>
                                                <input name="con_doc[]" type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="other">Others</label>
                                                <input name="con_doc[]" type="file" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group consent" style="align-items:center;">
                                        <div class="col-md-12">
                                            <div class="flex pb-10">
                                                <input type="checkbox" class="me-2" name="confirm" value="Yes"
                                                    required>Your
                                                Consent
                                            </div>

                                            <p style="line-height: 1.5;font-size: 13px;text-align: justify;">I agree to
                                                receive other communications from Bizz Education.
                                            </p>

                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" id="apply_now_btn">Apply Now</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end form -->

    <!--new bizz apply form-->
    <div class="clearfix"></div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.s-example-basic-single').select2();
            filterIntake();
        });
    </script>
    <script>
        function filterIntake() {
            if ($('#university').val() != "" && $('#interest_country').val() != "") {
                $('#intake').removeAttr('disabled');
                let university_id = $('#university').val();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('api.filterIntakemonth') }}",
                    data: {
                        university: university_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            console.log(response);
                            /**let allMonths = ['Jan','Feb','Mar', 'Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'];
                            let month = [];**/
                            $('#intake').html('');
                            $('#intake').append('<option value="" selected>Please Select</option>');
                            $.each(response.intake, function(key, item) {
                                if (item.value != "") {
                                    $('#intake').append('<option value="' + item.value + '">' + item
                                        .month + '</option>');
                                }
                            });


                        } else {
                            $('#intake').html("");
                            $('#intake').prop('disabled', true);
                            $('#intake').append('<option value="">' + response.message + '</option>');
                        }
                    }
                });
            } else {
                $('#intake').prop('disabled', true);
                $('#intake').html("");
                $('#intake').append('<option value="" selected>Select Course</option>');
            }
        }

        function filterCourses() {
            if ($('#university').val() != "" && $('#intake').val() != "") {
                $('#course').removeAttr('disabled');
                let university_id = $('#university').val();
                let intake_month = $('#intake').val();
                $.ajax({
                    type: 'GET',
                    url: "{{route('api.filterCourse')}}",
                    data: {
                        university: university_id,
                        intake: intake_month
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            $('#course').html("");
                            $('#course').append('<option value="" selected>Select Course</option>');
                            $.each(response.courses, function(key, item) {
                                //console.log(item);
                                $('#course').append('<option value="' + item.course_id + '">' + item
                                    .course_title + '</option>');
                            });
                        } else {
                            $('#course').html("");
                            $('#course').prop('disabled', true);
                            $('#course').append('<option value="' + response.message + '">' + response.message +
                                '</option>');
                        }

                    }
                });
            } else {
                $('#course').prop('disabled', true);
                $('#course').html("");
                $('#course').append('<option value="" selected>Select Course</option>');
            }
        }
    </script>
@endsection

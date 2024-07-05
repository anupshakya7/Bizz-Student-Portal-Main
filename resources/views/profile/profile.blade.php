@extends('layout.main')
@section('style')
    <style>
        label.invalid {
            color: red;
            font-size: 14px;
        }

        input.invalid {
            border: 2px solid red;
        }

        input.success {
            border: 2px solid green;
        }
    </style>
@endsection
@section('content')
    <div class="card p-3 mt-3">
        <h2>Edit Profile</h2>
        <form action="{{route('profile.updateProfile')}}" method="POST" id="edit_profile_form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div id="image-preview-container">
                        <img id="image-preview" src="{{!empty($user->profile_image) ? asset('images/users/'.$user->profile_image) : asset('images/default.png')}}" alt="Image Preview" style="display:block; border-radius:50%;margin:auto; width:120px; height:120px;object-fit: contain;">
                    </div>
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control" value="{{$user->profile_image}}" id="profile_image" accept="image/png, image/gif, image/jpeg" onchange="previewImage(event)">
                        @if ($errors->has('profile_image'))
                            <span class="text-danger">{{ $errors->first('profile_image') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" name="firstname" class="form-control" id="firstname"
                            value="{{ old('firstname',$user->firstname) }}" placeholder="Enter First Name">
                        @if ($errors->has('firstname'))
                            <span class="text-danger">{{ $errors->first('firstname') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" name="lastname" class="form-control" id="lastname"
                            value="{{ old('lastname',$user->lastname) }}" placeholder="Enter Last Name">
                        @if ($errors->has('lastname'))
                            <span class="text-danger">{{ $errors->first('lastname') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <div class="cpi-input">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <div class="input-group border rounded">
                                <button class="btn btn-light dropdown-toggle d-flex align-items-center cpi-drop"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="me-1">🇳🇵</span>
                                </button>
                                <div class="dropdown-menu w-100">
                                    <button type="button" class="dropdown-item" data-cpi-icon="🇳🇵" data-cpi-ext="+977"
                                        data-cpi-min-length="10" data-cpi-max-length="10">
                                        🇳🇵 Nepal (+977)
                                    </button>
                                    <button type="button" class="dropdown-item" data-cpi-icon="🇬🇧" data-cpi-ext="+44"
                                        data-cpi-min-length="8" data-cpi-max-length="10">
                                        🇬🇧 United Kingdom (+44)
                                    </button>
                                </div>
                                <span class="input-group-text bg-white text-muted border-0 cpi-ext-txt">+977</span>
                                <input type="text" class="form-control border-0 phone-input flex-shrink-1"
                                    style="outline: none;" name="mobile" id="mobile" value="{{ old('mobile',$user->mobile) }}"
                                    pattern="[0-9]+" required minlength="10" maxlength="10">
                            </div>
                            <input type="hidden" name="country_code" class="country-code-input" value="+977">
                            @if(empty($user->mobile_verified_at))
                            <div class="alert alert-danger mt-2" role="alert">
                                Please verify your Mobile Number first to check the status and apply for courses of interest.
                                <a href="{{route('profile.otp')}}" class="btn btn-danger ms-4">Verify Mobile Number</a>
                            </div>
                            @else
                                <span class="text-success ms-2" style="font-size: 90%;font-weight:bold;">Verified</span>
                            @endif
                        </div>
                        @if ($errors->has('mobile'))
                            <span class="text-danger">{{ $errors->first('mobile') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address" value="{{ old('address',$user->address) }}"
                            placeholder="Enter Address">
                        @if ($errors->has('address'))
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
@section('script')
    <script>
        function previewImage(event){
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function(){
                var imagePreview = document.getElementById('image-preview');
                imagePreview.src = reader.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#edit_profile_form").validate({
                errorClass: "invalid",
                validClass: "success",
                rules: {
                    firstname: {
                        required: true,
                        minlenght: 2,
                        maxlength: 100,
                    },
                    lastname: {
                        required: true,
                        minlenght: 2,
                        maxlength: 100,
                    }
                },
                messages: {
                    firstname: {
                        required: "Please Enter First Name",
                    },
                    lastname: {
                        required: "Please Enter Last Name",
                    }
                },
                submitHandler: function(form) {
                    $.LoadingOverlay("show");
                    form.submit();
                }
            });
        });
    </script>
@endsection

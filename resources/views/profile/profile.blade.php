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
        <form action="{{route('profile.updateProfile')}}" method="POST" id="edit_profile_form">
            @csrf
            @method('PUT')
            <div class="row">
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
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
@section('script')
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

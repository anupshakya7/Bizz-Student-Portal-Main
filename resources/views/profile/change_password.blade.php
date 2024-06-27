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
    <h2>Change Password</h2>
    <form action="{{route('profile.updatePassword')}}" method="POST" id="change_password_form">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="old_password" class="form-label">Old Password</label>
                    <input type="password" name="old_password" class="form-control" id="old_password"
                    placeholder="Enter Old Password">
                    @if ($errors->has('old_password'))
                        <span class="text-danger">{{ $errors->first('old_password') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" id="new_password"
                    placeholder="Enter New Password">
                    @if ($errors->has('new_password'))
                        <span class="text-danger">{{ $errors->first('new_password') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                    placeholder="Enter Confirm Password">
                    @if ($errors->has('confirm_password'))
                        <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>
@endsection
@section('script')
<script>
    //   $(document).ready(function() {
    //         $("#change_password_form").validate({
    //             errorClass: "invalid",
    //             validClass: "success",
    //             rules: {
    //                 oldpassword:{
    //                     required:true,
    //                     minlength:6,
    //                     maxlength:100
    //                 },
    //                 newpassword: {
    //                     required: true,
    //                     minlenght: 6,
    //                     maxlength: 100,
    //                 },
    //                 confirmpassword: {
    //                     required: true,
    //                     equalTo: "#newpassword",
    //                 }
    //             },
    //             messages: {
    //                 oldpassword: {
    //                     required: "Please Enter Old Password",
    //                 },
    //                 newpassword: {
    //                     required: "Please Enter New Password",
    //                 },
    //                 confirmpassword: {
    //                     required: "Need to Confirm Password",
    //                 }
    //             },
    //             submitHandler: function(form) {
    //                 $.LoadingOverlay("show");
    //                 form.submit();
    //             }
    //         });
    //     });
</script>
@endsection
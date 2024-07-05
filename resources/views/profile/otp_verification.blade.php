@extends('layout.main')
@section('content')
<div class="card p-3 mt-3">
    <h2>Verify Mobile</h2>
    <form action="{{route('profile.otp.verification')}}" method="POST" id="change_password_form">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <div class="cpi-input">
                        <label for="mobile" class="form-label">Mobile Number</label>
                        <div class="input-group mb-3 border rounded">
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
                                style="outline: none;" name="mobile" id="mobile" value="{{ old('mobile',auth()->user()->mobile) }}"
                                pattern="[0-9]+" required minlength="10" maxlength="10" readonly>
                        </div>
                        <input type="hidden" name="country_code" class="country-code-input" value="+977">
                    </div>
                    @if ($errors->has('mobile'))
                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="otp" class="form-label">OTP</label>
                    <input type="text" name="otp" class="form-control" id="otp" value="{{ old('otp') }}"
                        placeholder="Enter OTP">
                    @if ($errors->has('otp'))
                        <span class="text-danger">{{ $errors->first('otp') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
</div>
@endsection
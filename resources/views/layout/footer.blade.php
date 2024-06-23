</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="{{asset('js/script.js')}}"></script>
<script type="text/javascript">
    window.baseUrl = "{{URL::to('/')}}";
    @if(session('success'))
        toastr.success("{{session('success')}}",'Success',{timeOut:5000});
    @endif

    @if(session('error'))
        toastr.success("{{session('error')}}",'Error',{timeOut:5000});
    @endif
</script>
@yield('script')
</body>

</html>
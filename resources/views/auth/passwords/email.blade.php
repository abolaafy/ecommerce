@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                        @csrf

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">E_Mobil Number</label>

                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control " name="mobile" value="{{ old('mobile') }}" >


                                    <span class="invalid-feedback" role="alert"  style="display: block;">
                                        <strong id="message" ></strong>
                                    </span>

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="checkMobile()">
                                Send Code Reset SMS
                                </button>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
                function checkMobile ()
                {

                    var mobile = document.getElementById('mobile').value;

                    if (mobile.length == 11)
                    {
                        document.getElementById('message').innerHTML ='';

                    var xml = new XMLHttpRequest ();
                    xml.open('get' , 'http://localhost/shop7/public/password/rest/mobile-check?mobile=' +mobile);

                    xml.send();
                    xml.onreadystatechange = function ()
                    {
                        if(xml.readyState === 4 && xml.status == 200)
                        {
                            var status = JSON.parse(xml.responseText).status;
                            console.log(status);
                            if (status == 'success')
                            {
                                window.location.replace('http://localhost/shop7/public/password/rest/code');

                            }
                            else
                            {
                                document.getElementById('message').innerHTML = "الرقم غير مسجل من قبل";

                            }
                        }
                    }

                    }
                    else
                    {


                        document.getElementById('message').innerHTML = "الرقم غير صحيح";
                    }

                }
</script>
@endsection

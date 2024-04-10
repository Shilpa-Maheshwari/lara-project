@extends('layouts.site')

@section('content')
<style>
.input-group{
    position: relative;
}


.fa.fa-check {
    display: none;
    position: absolute;
    color: green;
    right: 12px;
    top: 50%;
    z-index: 5;
    transform: translateY(-50%);
}

.verified{
    display: inline !important;
}
</style>
<div class="row justify-content-center mt-3">
    <div class="col-md-6">
        <div class="card ">
            <div class="card-body">
                <h4 class="text-center my-4">User Registration </h4>
                <input type="hidden" name="latitude" id="latitude" value="">
                <input type="hidden" name="longitude" id="longitude" value="">
                <input type="hidden" name="requestId" id="requestId" value="">

                <div id="mobile-group">
                    <div class="row mb-3 align-items-end verification-changes">
                        <div class="col-md-9" >
                            <label>Mobile number: </label>
                            <div class="input-group">
                                <input type="text" onkeydown="return isNumber(event)" id="mobile_no" class="form-control rounded-0" name="mobile_no" maxlength="10">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="col-md-3" >
                            <button type="button" id="send_mobile_otp_btn" onclick="sendMobileOtp(this)" class="btn btn-block btn-xs btn-info">Continue</button>
                        </div>
                    </div>
                    <div class="row mb-3 d-none align-items-end" id="mobile-otp-div">
                        <div class="col-md-6">
                            <input type="text" id="mobile_otp_code" onkeydown="return isNumber(event)" name="mobile_otp_code" maxlength="6" placeholder="OTP code" class="form-control rounded-0">
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="verify_mobile_otp_btn" onclick="verifyMobileOtp(this)" class="btn btn-info btn-block">Verify OTP</button>
                        </div>
                    </div>
                </div>
                
                <div id="email-group" class="d-none">
                    <div class="row mb-3 align-items-end verification-changes">
                        <div class="col-md-9">
                            <label>Email Address: </label>
                            <div class="input-group">
                                <input type="email" id="email" class="form-control rounded-0" name="email">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="send_email_otp_btn" onclick="sendEmailOtp(this)" class="btn btn-block btn-xs btn-info">Continue</button>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end d-none" id="email-otp-div">
                        <div class="col-md-6">
                            <input type="text" id="email_otp_code" onkeydown="return isNumber(event)" name="email_otp_code" maxlength="6" placeholder="OTP code" class="form-control rounded-0">
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="verify_email_otp_btn" onclick="verifyEmailOtp(this)" class="btn btn-info btn-block">Verify OTP</button>
                        </div>
                    </div>
                </div>

                <div id="pan-group" class="d-none">
                    <div class="row mb-3 align-items-end verification-changes">
                        <div class="col-md-9">
                            <label>Pan number: </label>
                            <div class="input-group">
                                <input type="text" id="pan"  class="form-control rounded-0" name="pan">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="confirm_pan_btn" onclick="confirmPan(this)" class="btn btn-block btn-xs btn-info">Continue</button>
                        </div>
                    </div>
                </div>

                <div id="account-group" class="d-none">
                    <div class="form-group">
                        <label>Password</label>
                        <div class="pwd-group">
                            <input type="password" id="password" placeholder="Password" class="form-control rounded-0" name="password">
                            <i class="fa fa-eye pwd-show-btn"></i>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="pwd-group">
                            <input type="password" id="confirm-password" placeholder="Confirm Password" class="form-control rounded-0" name="confirm_password">
                            <i class="fa fa-eye pwd-show-btn"></i>
                        </div>
                    </div>
                    <a class="text-danger" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Password Rules
                    </a>
                    <div class="collapse form-inline" id="collapseExample">
                        <ul>
                            <li>A lowercase letter</li>
                            <li>A capital (uppercase) letter</li>
                            <li>A number</li>
                            <li>A special character #@$&*</li>
                            <li>Minimum 8 and 16 characters</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <button type="button" id="create_account_btn" onclick="create_account(this)" class="btn btn-block btn-xs btn-info">Create Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

let countDownInterval;

function count_down(element)
{
    var timer = 10;
    countDownInterval = setInterval(function()
	{
		var seconds = timer;
		--seconds;

		if(seconds < 1){
			clearInterval(countDownInterval);
		}
		if(seconds==0){
			$(element).prop('disabled',false);
			$(element).html('Re-send');
            $('#mobile_no').prop('disabled', false);
            $('#email').prop('disabled', false);

		}else{
			$(element).prop('disabled',true);
		
            if(seconds < 10){
				displaySecond = "00:0"+seconds
			}else{
				displaySecond = "00:"+seconds
			}

            $(element).html(displaySecond);
			timer = seconds;
		}
	}, 1000);
}


function sendMobileOtp(element)
{ 
    var mobile_no = $('#mobile_no').val();
    var mobile_pattern = /^[6789]\d{9}$/;

    if(mobile_no.length==10) 
    {
        if(! mobile_no.match(mobile_pattern))
        {
            Swal.fire({
                icon:'error',
                text:'Please enter valid mobile number'
            })
            return false;
        }
        Swal.fire({
            title: 'Are you sure?',
            html: "Mobile Number once submited, can not be changed",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm and Submit'
		}).then((result) => {
            if(result.isConfirmed)
            {
                $('#mobile_no').prop('readonly', true);
                $('#verify_mobile_otp_btn').prop('disabled', false);
               
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    url:'{{ route("send-mobile-otp") }}',
                    method:'POST',
                    data:'mobile_no='+mobile_no,
                    success:function(response)
                    {
                        if(response.status=="10" || response.status=="0")
                        {
                            Swal.fire({
                                icon:'error',
                                text:response.message
                            })
                            $('#mobile_no').prop('readonly', false);
                        }
                        else if(response.status=="1")
                        {
                            count_down(element)
                            Swal.fire({
                                icon:'success',
                                text:response.message
                            })
                            $('#mobile-otp-div').removeClass('d-none')

                            $('#requestId').val(response.requestId)
                        }
                        else if(response.status=="2" || response.status=="3")
                        {
                            Swal.fire({
                                icon:'success',
                                text:response.message
                            });

                            $('#mobile-group .verification-changes .col-md-9').addClass('col-md-12').removeClass('col-md-9')
                            $('#mobile-group .verification-changes .col-md-3').addClass('d-none')
                            if(response.details.isMobileVerified=='1')
                            {
                                $('#mobile-group .input-group .fa').addClass('verified');
                            }
                            
                            $('#email-group').removeClass('d-none')

                            if(response.status=="3")
                            {                                
                                $('#email').val(response.details.email).prop('readonly', true);
                                $('#email-otp-div').removeClass('d-none')
                                count_down('#send_email_otp_btn')
                            }

                            $('#requestId').val(response.requestId)
                        }
                        else if(response.status=="4" || response.status=="9")
                        {
                            Swal.fire({
                                icon:'success',
                                text:response.message
                            });
                            
                            $('#mobile-group .verification-changes .col-md-9').addClass('col-md-12').removeClass('col-md-9')
                            $('#mobile-group .verification-changes .col-md-3').addClass('d-none')
                            $('#mobile_no').prop('readonly', true);

                            if(response.details.isMobileVerified=='1')
                            {
                                $('#mobile-group .input-group .fa').addClass('verified');
                            }

                            if(response.details.isEmailVerified=='1')
                            {
                                $('#email-group .verification-changes .col-md-9').addClass('col-md-12').removeClass('col-md-9')
                                $('#email-group .verification-changes .col-md-3').addClass('d-none')
                                
                                $('#email-group .input-group .fa').addClass('verified');
                            }
                            if(response.details.isPanVerified=='1')
                            {
                                $('#pan-group .verification-changes .col-md-9').addClass('col-md-12').removeClass('col-md-9')
                                $('#pan-group .verification-changes .col-md-3').addClass('d-none')
                               
                                $('#pan-group .input-group .fa').addClass('verified');
                            }

                            if(response.details.skip.email=='1' && response.details.isEmailVerified=='1')
                            {
                                $('#email').val(response.details.email).prop('readonly', true);
                            }
                            if(response.details.isPanVerified=='1' && response.details.skip.pan=='1'){
                                $('#pan').val(response.details.pan).prop('readonly', true);
                            }
                            if(response.status=="4")
                            {
                                if(response.details.skip.email=='1'){
                                    $('#email-group').removeClass('d-none')
                                }
                                $('#pan-group').removeClass('d-none')
                            }
                            if(response.status=="9")
                            {
                                if(response.details.skip.email=='1'){
                                    $('#email-group').removeClass('d-none')
                                }
                                if(response.details.skip.pan=='1'){
                                    $('#pan-group').removeClass('d-none')
                                }
                                $('#account-group').removeClass('d-none')
                            }
                            
                            $('#requestId').val(response.requestId)
                        }
                        
                    }
                })
            }
        });

    } else if(mobile_no.length==0) {
        Swal.fire({
            icon:'error',
            text: "Mobile Number is required.",
        })
    } else {
        Swal.fire({
            icon:'error',
            text: "Please enter correct mobile number",
        })
    }
}


function verifyMobileOtp(element)
{
    var id = $('#requestId').val()
    var otp = $('#mobile_otp_code').val()
    if(!id)
    {
        Swal.fire({
            icon:'error',
            text: "Request Id not found.",
        })
        return false;
    }
    if(otp.length==6)
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            url:'{{ route("verify-mobile-otp") }}',
            method:'POST',
            data:'id='+id+'&otp='+otp,
            success:function(response)
            {
                if(response.status=="1" || response.status=="4" || response.status=="9")
                {
                    Swal.fire({
                        icon:'success',
                        text:response.message
                    });

                    $('#mobile-group #mobile-otp-div').addClass('d-none');

                    $('#mobile-group .verification-changes .col-md-9').addClass('col-md-12').removeClass('col-md-9')
                    $('#mobile-group .verification-changes .col-md-3').addClass('d-none')
                    $('#mobile_no').prop('disabled', true);
                    $('#mobile-group .input-group .fa').addClass('verified');
                    
                    if(response.status=="1")
                    {
                        $('#email-group').removeClass('d-none')
                    }
                    if(response.status=="4")
                    {
                        $('#pan-group').removeClass('d-none')
                    }
                    if(response.status=="9")
                    {
                        $('#account-group').removeClass('d-none')
                    }
                    
                    $('#requestId').val(response.requestId)
                }
                else if(response.status=="2")
                {
                    Swal.fire({
                        icon:'error',
                        text:response.message
                    });

                    $('#mobile_otp_code').val('');
                    $('#verify_mobile_otp_btn').prop('disabled', true);

                    clearInterval(countDownInterval)
                    $('#send_mobile_otp_btn').html('Re-send').prop('disabled', false)
                }
                else
                {
                    Swal.fire({
                        icon:'error',
                        text:response.message
                    })
                }
            }
        });
    } 
    else if(otp.length==0) 
    {
        Swal.fire({
            icon:'error',
            text: "Otp code is required.",
        })
    }
    else
    {
        Swal.fire({
            icon:'error',
            text: "Please enter correct otp code",
        })
    }
}


function sendEmailOtp(element)
{
    var email = $('#email').val();
    var email_pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if(email.length==0) {
        Swal.fire({
            icon:'error',
            text: "Email address is required.",
        })
        return false;
    } else if(!email.match(email_pattern)) {
        Swal.fire({
            icon:'error',
            text: "Please enter correct email address",
        })
        return false;
    }

    var requestId = $('#requestId').val()

    Swal.fire({
        title: 'Are you sure?',
        html: "Email address once submited, can not be changed",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirm and Submit'
    }).then((result) => {
        if(result.isConfirmed)
        {
            $('#email').prop('disabled', true);
            $('#verify_email_otp_btn').prop('disabled', false);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url:'{{ route("send-email-otp") }}',
                method:'POST',
                data:'id='+requestId+'&email='+email,
                success:function(response)
                {
                    $('#email').prop('disabled', false);
                    if(response.status=="10" || response.status=="0")
                    {
                        Swal.fire({
                            icon:'error',
                            text:response.message
                        })
                    }
                    else if(response.status=="1")
                    {
                        count_down(element)

                        Swal.fire({
                            icon:'success',
                            text:response.message
                        })
                        $('#email-otp-div').removeClass('d-none')
                    }
                }
            })
        }
    });
}


function verifyEmailOtp(element)
{
    var id = $('#requestId').val()
    var otp = $('#email_otp_code').val()
    if(!id)
    {
        Swal.fire({
            icon:'error',
            text: "Request Id not found.",
        })
        return false;
    }
    if(otp.length==6)
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            url:'{{ route("verify-email-otp") }}',
            method:'POST',
            data:'id='+id+'&otp='+otp,
            success:function(response)
            {
                if(response.status=="1" || response.status=="4")
                {
                    Swal.fire({
                        icon:'success',
                        text:response.message
                    })
                    
                    $('#email-group .input-group .fa').addClass('verified')
                    
                    $('#email-group .verification-changes .col-md-9').addClass('col-md-12').removeClass('col-md-9')
                    $('#email-group .verification-changes .col-md-3').addClass('d-none')

                    $('#email-group #email-otp-div').addClass('d-none')
                    $('#email').prop('readonly', true)

                    if(response.status=="4"){
                        $('#pan-group').removeClass('d-none')
                    }else{
                        $('#account-group').removeClass('d-none');
                    }
                    $('#verify_email_otp_btn').prop('disabled', false);
                    $('#email_otp_code').val('');
                }
                else if(response.status=="2")
                {
                    Swal.fire({
                        icon:'error',
                        text:response.message
                    })
                    $('#verify_email_otp_btn').prop('disabled', false);
                    $('#email_otp_code').val('');
                }
                else
                {
                    Swal.fire({
                        icon:'error',
                        text:response.message
                    })
                }
            }
        });
    } else if(otp.length==0) {
        Swal.fire({
            icon:'error',
            text: "Otp code is required.",
        })
    } else {
        Swal.fire({
            icon:'error',
            text: "Please enter correct otp code",
        })
    }
}


function confirmPan(element)
{
    var id = $('#requestId').val()
    var pan = $('#pan').val()
    var pan_pattern =/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
    if(!id)
    {
        Swal.fire({
            icon:'error',
            text: "Request Id not found.",
        })
        return false;
    }
    if(!pan.match(pan_pattern))
    {
        Swal.fire({
            icon:'error',
            text: "Pan number is invalid.",
        })
        return false;
    }
    if(pan.length==10)
    {
        Swal.fire({
            title: 'Are you sure?',
            html: "Pan number once submited, can not be changed",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm and Submit'
        }).then((result) => {
            if(result.isConfirmed)
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    url:'{{ route("verify-pan") }}',
                    method:'POST',
                    data:'id='+id+'&pan='+pan,
                    success:function(response)
                    {
                        if(response.status=="1")
                        {
                            Swal.fire({
                                icon:'success',
                                text:response.message
                            })

                            $('#pan-group .verification-changes .col-md-9').addClass('col-md-12').removeClass('col-md-9')
                            $('#pan-group .verification-changes .col-md-3').addClass('d-none')

                            $('#pan').prop('readonly', true)
                            $('#pan-group .input-group .fa').addClass('verified')
                            
                            $('#account-group').removeClass('d-none')

                            
                            if(response.details.name){
                                Swal.fire({
                                    text: 'Verified Name : '+response.details.name
                                });
                            }
                        }
                        else if(response.status=="5")
                        {
                            Swal.fire({
                                icon:'info',
                                text:response.message
                            })
                            $('#pan-group .verification-changes .col-md-9').addClass('col-md-12').removeClass('col-md-9')
                            $('#pan-group .verification-changes .col-md-3').addClass('d-none')

                            $('#pan').prop('readonly', true)
                            
                            $('#pan-group .input-group .fa').addClass('verified')
                        }
                        else
                        {
                            Swal.fire({
                                icon:'error',
                                text:response.message
                            })
                        }
                    }
                });
            }
        });
    } else if(otp.length==0) {
        Swal.fire({
            icon:'error',
            text: "Otp code is required.",
        })
    } else {
        Swal.fire({
            icon:'error',
            text: "Please enter correct otp code",
        })
    }
}


function create_account(element)
{
    var id = $('#requestId').val()
    var password = $('#password').val()
    var confirm_password = $('#confirm-password').val()
    var latitude = $('#latitude').val()
    var longitude = $('#longitude').val()

    var pwd_pattern =/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*?[#@$&*]).{8,}$/;

    if(!password.match(pwd_pattern))
    {
        Swal.fire({
            icon:'error',
            text:'Please enter password according the rules'
        })
        return false;
    }
    else if(password.length<6)
    {
        Swal.fire({
            icon:'error',
            text:'Password minimum length is 6'
        })
        return false;
    }
    else if(password!=confirm_password)
    {
        Swal.fire({
            icon:'error',
            text:'Confirm password does not match to password'
        })
        return false;
    }
    $('#create_account_btn').html('Processing....');
    
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    $.ajax({
        url:'{{ route("create-account") }}',
        method:'POST',
        data:{
            'id':id,
            'password':password,
            'latitude':latitude,
            'longitude':longitude,
            'confirm_password':confirm_password,
        },
        dataType:'JSON',
        success:function(response)
        {
            $('#create_account_btn').html('Create Account');
            if(response.status=="1")
            {
                Swal.fire({
                    icon:'success',
                    text:response.message
                }).then(function() {
                    window.location = "{{ route('home') }}";
                });
            }else{
                Swal.fire({
                    icon:'error',
                    text:response.message
                })
            }
        }
    });
}
function showPosition(position)
{
    $('#send_otp_btn').prop('disabled',false);

    $("#latitude").val(position.coords.latitude.toFixed(4))
    $("#longitude").val(position.coords.longitude.toFixed(4))
}

$(document).ready(function() {

    if (navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } 
    else 
    {
        Swal.fire({
            icon:'error',
            text: "Geolocation is not supported by this browser.",
        })
    }

});
</script>
@endsection
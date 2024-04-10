<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap-5/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
    <script src="{{ asset('jquery/jquery-3.6.4.min.js')}}"></script>
    <script src="{{ asset('bootstrap-5/js/bootstrap.min.js')}}"></script>
</head>
<style>
    .forgetContent {
        border: 1px solid #ff002d;
        padding: 40px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }
</style>

<body>
    <x-alert />
    <div class="forgotPageBody">
        <div class="forget-page">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4">

                        <div class="forgetContent mt-5">
                            <div class="forget-heading">
                                <div class="forget-img">
                                    <img src="{{ asset('image/lock.png')}}" id="lock">
                                </div>
                                <h5 class=" py-2" style="color: #11404c;">Forgot Password</h5>
                            </div>
                            <div class="">

                                <form autocomplete="off" class="user-form" onSubmit="return validateforgotForm(event)" method="post" action="{{ url('update_password/'.$id) }}">
                                    @csrf
                                    <div class="mb-3 forget_passwordGroup">
                                        <label for="exampleInputPassword" class="form-label">Password</label><br>
                                        <input type="password" class="form-input" id="exampleforgetPassword" autocomplete="off" name="pwd">
                                        <i class="fa fa-eye-slash" id="passwordShow"></i>
                                        <span class="text-danger" id="passwordError" style="font-size: 14px;"></span>
                                    </div>
                                    <div class="mb-3 forgetConfirmpasswordGroup">
                                        <label for="exampleInputPassword" class="form-label">Confirm Password</label><br>
                                        <input type="password" class="form-input" id="inputConfirmPassword" autocomplete="off" name="cpwd">
                                        <i class="fa fa-eye-slash" id="confirmPasswordShow"></i>
                                        <span class="text-danger" id="conpasswordError" style="font-size: 14px;"></span>
                                    </div>
                                    <div class="otp">
                                        <label class="form_label">OTP</label>
                                        <input type="text" name="otp" id="inputOtp" class="form-input" onkeydown="return is_number(event, this)">
                                        <span class="text-danger" id="otpError" style="font-size: 14px;"></span>
                                    </div>
                                    <button type="submit" class="btn btn-primary my-5">Reset Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript">
        //forkeyup function
        function is_number(evt, el) {
            var key = evt.keyCode ? evt.keyCode : evt.which;

            var inputBoxValue = $(el).val().length;
            var array = [8, 37, 38, 39, 40, 13, 16, 9, 18, 17, 46];
            if (array.indexOf(key) > -1) {
                return true;
            }
            if(inputBoxValue==6){
                return false;
                }
            // r    v      ctrl
            if ((key == 82 || key == 86) && evt.ctrlKey) {
                return true;
            }

            if (key >= 48 && key <= 57) {
                return true;
            }
            if (key >= 96 && key <= 105) {
                return true;
            }
           
            return false;

        }






        function validateforgotForm(evt) {
            // evt.preventDefault();
            var password = $('#exampleforgetPassword').val()
            var password_pattern = /^[a-zA-Z0-9!@#\$%\^\&*_=+-]{8,12}$/g;
            var confirmpassword = $('#inputConfirmPassword').val();
            var otpvalue = $('#inputOtp').val();
        
            if (password == '') {
                $("#passwordError").html('password required')
                return false;
            } else if (password.length < 8) {
                $('#passwordError').html('password must be 8 Character')
                return false;
            } else if (!password.match(password_pattern)) {
                $("#passwordError").html('password is not correct');
                return false;
            }
            
            if (confirmpassword == '') {
                $("#conpasswordError").html('password required')
                return false;
            } else if (confirmpassword !== password) {
                $("#conpasswordError").html('Password Not Match');
                return false;
            }
            if(otpvalue=='')
            {
                $('#otpError').html('otp required');
                return false;
            }
            else if(otpvalue.length < 6)
            {
                $('#otpError').html('Invalid Otp');
                return false;
            }
            else if(otpvalue==6)
            {
                return true;
            }
            return true;
        }

        $(document).ready(function() {
            $('#passwordShow').click(function() {
                var value = $('#exampleforgetPassword').attr('type');
                if (value == 'password') {
                    $('#exampleforgetPassword').attr('type', 'text');
                    $(this).addClass("fa-eye");
                    $(this).removeClass("fa-eye-slash")
                } else {
                    $('#exampleforgetPassword').attr('type', 'password');
                    $(this).addClass("fa-eye-slash");
                    $(this).removeClass("fa-eye")
                }
            })

            $('#confirmPasswordShow').click(function() {
                var value = $('#inputConfirmPassword').attr('type');
                if (value == 'password') {
                    $('#inputConfirmPassword').attr('type', 'text');
                    $(this).addClass("fa-eye");
                    $(this).removeClass("fa-eye-slash")
                } else {
                    $('#inputConfirmPassword').attr('type', 'password');
                    $(this).addClass("fa-eye-slash");
                    $(this).removeClass("fa-eye")
                }
            })
        })
    </script>
</body>

</html>
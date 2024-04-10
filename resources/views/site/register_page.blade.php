@extends('layouts.site')
@section('content')

<style>
.input-group
{
    position: relative;
}

.fa.fa-check
{
    display: none;
    position: absolute;
    color: green;
    right: 12px;
    top: 50%;
    z-index: 5;
    transform: translateY(-50%);
}

.verified
{
    display: inline !important;
}
</style>
<div class="row justify-content-center mt-3">
    <div class="col-md-6">
        <form method="post" action="{{ route('signin')}}">
            @csrf
            <div class="card ">
                <div class="card-body">
                    <h4 class="text-center my-4">User Registration</h4>
                    <div id="email-group" class="">
                        <div class="row mb-3 align-items-end verification-changes">
                            <div class="col-md-12">
                                <label>Name:</label>
                                <div class="input-group">
                                    <input type="name" id="name" class="form-control rounded-0" name="name" placeholder="Enter Your Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="email-group" class="">
                        <div class="row mb-3 align-items-end verification-changes">
                            <div class="col-md-12">
                                <label>Email Address:</label>
                                <div class="input-group">
                                    <input type="email" id="email" class="form-control rounded-0" name="email" placeholder="Enter Your Email Here">
                                    <i class="fa fa-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="account-group" class="">
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
                        <div class="collapse form-inline mt-2" id="collapseExample">
                            <ul>
                                <li>A lowercase letter</li>
                                <li>A capital (uppercase) letter</li>
                                <li>A number</li>
                                <li>A special character #@$&*</li>
                                <li>Minimum 8 and 16 characters</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="create_account_btn" class="btn btn-block btn-xs btn-primary">Create Account</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

$('#register-form').submit(function(event)
{
    event.preventDefault();
    var email = $('#email').val()
    var name = $('#name').val()
    var password = $('#password').val()
    var con_pwd = $('#confirm-password').val()
    var validRegexEmail = '[^\s@]+@[^\s@]+\.[^\s@]+$';
    var password_pattern = /^[a-zA-Z0-9!@#\$%\^\&*_=+-]{8,12}$/g;
    if(password == '') {
        alert('Pasword Required');
        return false;
    }
    else if (password.length < 8) {
        alert('Password not valid');
        return false;
    }
        else if (!password.match(password_pattern)) {
            alert('Password is not Match');
            return false;
        }
        if(email == '') {
            alert('Email Required');
            return false;
        } 
        else if(!email.match(validRegexEmail)) {
            alert('Please Enter valid Email');
            return false;
        }
        if(name == '') {
            alert('Name Required');
            return false;
        } 
        else if(name < 3) 
        {
            alert('Please Enter Vaild Name');
            return false;
        } 
        if(con_pwd == '') 
        {
            alert('Pasword Required');
            return false;
        }
        else if(con_pwd.length < 8) 
        {
            alert('con_pwd not valid');
            return false;
        }
        else if(!con_pwd.match(password_pattern)) 
        {
            alert('con_pwd is not Match');
            return false;
        }
});

</script>


@endsection
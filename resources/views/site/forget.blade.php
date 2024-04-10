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
  /* .forgotPageBody
    {
        height: 100vh;
        background-image: url({{asset('image/forget-body.jpg')}}); 
        background-size: cover;
    } */
  .forgetContent {
    border: 1px solid #ff002d;
    padding: 40px;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
  }
</style>

<body>
  <div class="forgotPageBody">
    <div class="forget-page">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-5">

            <div class="forgetContent mt-5">
              <div class="forget-heading">
                <div class="forget-img">
                  <img src="{{ asset('image/lock.png')}}" id="lock">
                </div>
                <h5 class=" py-2" style="color: #11404c;">Forgot Password</h5>
              </div>
              <h6 class="text-center" style="color:#F5B0AF;">Enter your phone, or username and we'll send you a otp to get back into your account.</h6>
              <div class="">
                <form autocomplete="off" class="user-form" onSubmit="return validateforgotForm(event)" method="post" action="{{ url('forgot_check') }}">
                  @csrf
                  <div class="mb-3">
                    <label for="forgotUser" class="form-label">Username/Mobile No.</label>
                    <input type="text" class="form-input" id="exampleInputUser" aria-describedby="emailHelp" autocomplete="off" name="mobile_no">
                    <span class="text-danger" id="userError" style="font-size: 14px;"></span>
                  </div>
                  <button type="submit" class="btn btn-primary my-5">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>




  <script type="text/javascript">
    function number(evt, el) {
      console.log(evt);
      var key = evt.keyCode ? evt.keyCode : evt.which;

      var inputBoxValue = $(el).val();

      var array = [37, 38, 39, 40, 13, 16, 9, 18, 17, 46];
      if (array.indexOf(key) > -1) {
        return true;
      }
      if ((key == 82 || key == 86) && evt.ctrlKey) {
        return true;
      }

      if (inputBoxValue.length == 1) {
        var next = parseInt($(el).attr('numid'))
        if (key == 8) {
          $(el).val("")
          $('input[name="otp[' + (next - 1) + ']"]').focus()
        } else {
          $('input[name="otp[' + (next + 1) + ']"]').val(evt.key).focus()
        }
        return false;
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
      var userpattern = /^[a-zA-Z0-9]+$/;
       var user = $('#exampleInputUser').val()
      if (!user) {
        $('#userError').html('User Id Required');
        return false;
      } else if (!username.match(userpattern)) {
        $("#userError").html("username doesn't exist");
        return false;
      }
      return true;
    }

  </script>
</body>

</html>
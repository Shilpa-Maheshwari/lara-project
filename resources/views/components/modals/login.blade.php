<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="text-center mb-5">Login</h4>

                <form id="loginForm" action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Mobile number:</label>
                        <input type="text" onkeydown="return isNumber(event)" maxlength="10" name="mobile_no" class="form-control rounded-0">
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <div class="pwd-group">
                            <input type="password" name="password" class="form-control rounded-0">
                            <i class="fa fa-eye pwd-show-btn"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Login</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$('#loginForm').submit(function(evt){
    var url = $(this).attr('action')
    var method = $(this).attr('method')

    $.ajax({
        url:url,
        method:method,
        data:$(this).serialize(),
        dataType:"JSON",
        success:function(response){
            if(response.status=='1')
            {
                window.location.href="{{ route('dashboard' ) }}";
            }else{
                Swal.fire({
                    icon:'error',
                    text: response.message,
                }).then(()=>{
                    $('input[name="mobile_no"]').val('');
                    $('input[name="password"]').val('');
                })
            }
        }
    })

    console.log('submition')
    evt.preventDefault();
});
</script>
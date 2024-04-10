<script type="text/javascript">
    function isNumber(evt)
    {
        var key=evt.keyCode? evt.keyCode: evt.which;
        var keyArray=[8, 9, 13, 16, 17, 18, 32, 35, 36, 37, 38, 39, 40, 46];

        if(key>=48 && key<=57 || key>=96 && key<=105){
            return true;
        }
        if(keyArray.indexOf(key)>-1){
            return true;
        }
        if(evt.ctrlKey && (key==86 || key==67 || key==88 || key==65)){
            return true
        }
        evt.preventDefault();
    }
   

    function showError(error) 
    {
        $('#send_otp_btn').prop('disabled',true);

        switch (error.code) 
        {
            case error.PERMISSION_DENIED:
                Swal.fire({
                    icon:'error',
                    text: "Please enable location manully in your brower setting. After enabling, reload the page.",
                })
                break;
            case error.POSITION_UNAVAILABLE:
                Swal.fire({
                    icon:'error',
                    text: "Location information is unavailable.",
                })
                break;
            case error.TIMEOUT:
                Swal.fire({
                    icon:'error',
                    text: "The request to get user location timed out.",
                })
                break;
            case error.UNKNOWN_ERROR:
                Swal.fire({
                    icon:'error',
                    text: "An unknown error occurred.",
                })
                break;
        }
    }
</script>
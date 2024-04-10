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
	.input-group {
		position: relative;
	}

	#pwd-show {
		position: absolute;
		top: 60%;
		right: 28px;
	}
</style>

<body>
	<nav class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
		<div class="container">
			<div class="card">
				<div class="card-header">
					<h2>Login</h2>
				</div>
				<div class="card-body">
					<form method="post" action="{{ route('login')}}">
						@csrf
						<div class="form-group input-group">
							<label>Email Address:</label>
							<input type="email" id="email" class="form-control rounded-0" name="email" placeholder="Enter Your Email Here">
						</div>
						<div class="form-group input-group">
							<label for="password">Password</label>
							<input type="password" id="password" name="password" required>
							<i class="fa fa-eye" id="pwd-show"></i>
						</div>
						<button type="submit">Sign In</button>
					</form>
				</div>
			</div>
		</div>
	</nav>
	<style>
		body {
			background: linear-gradient(45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
			background-size: 400% 400%;
			animation: gradientAnimation 10s ease infinite;
		}

		@keyframes gradientAnimation {
			0% {
				background-position: 0% 50%;
			}

			50% {
				background-position: 100% 50%;
			}

			100% {
				background-position: 0% 50%;
			}
		}

		.container {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		.card {
			width: 300px;
			border: 1px solid #ddd;
			border-radius: 5px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			margin: auto;
			padding: 20px;
			background-color: #fff;
		}

		.card-body {
			padding: 20px;
		}

		.form-group {
			margin-bottom: 25px;
		}

		input[type="text"],
		input[type="password"] {
			width: 90%;
			padding: 10px;
			font-size: 16px;
			border-radius: 4px;
			border: 1px solid #ccc;
			margin-top: 8px;
		}

		label {
			display: block;
			font-weight: bold;
		}


		button:hover {
			background-color: #0056b3;
			transform: scale(1.05);
		}

		button[type="submit"] {
			width: 100%;
			padding: 10px;
			background-color: #3f51b5;
			color: white;
			border-radius: 4px;
			border: 0;
			cursor: pointer;
		}
	</style>

	<script type="text/javascript">
		$('#pwd-show').click(function() {
			var pvalue = $('#password').attr('type')
			if (pvalue == 'password') {
				$('#password').attr('type', 'text');
				$(this).removeClass('fa-eye-slash');
				$(this).addClass('fa-eye');
			} else {
				$('#password').attr('type', 'password');
				$(this).removeClass('fa-eye');
				$(this).addClass('fa-eye-slash');
			}
		})


		$("#loginPage").submit(function(event){
			event.preventDefault();
			var email = $('#email').val()
			var validRegexEmail = '[^\s@]+@[^\s@]+\.[^\s@]+$';

			if(email == '') 
			{
            	alert('Email Required');
            	return false;
        	} 
        	else if(!email.match(validRegexEmail)) 
			{
           	 	alert('Please Enter valid Email');
            	return false;
        	}
			return true;
		})
			

		
	</script>
</body>

</html>
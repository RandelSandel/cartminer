<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>
	<link href="{{ asset('/css/all.css') }}" rel="stylesheet">


</head>
<body>
	@include('partials.nav')
	
	<div class="container">
		@yield('content')
	</div>

	

	<!-- Scripts -->
	
	<!-- 	Local -->
	<script src="/public/js/vendor/vue-resource.min.js"></script>
	<!-- 	CDNS -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/vue/0.12.0-rc2/vue.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta id="token" name="token" value="{{ csrf_token() }}">
	<title>PartList.io</title>
	<link href="{{ asset('/css/all.css') }}" rel="stylesheet">
	<!-- added special link for glyphicons that weren't working -->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


</head>
<!-- overflow: hidden;  ... will stop the whole page from scrolling -->
<body style="">

	@if (Route::current()->uri() != 'product/{id}')
		@include('partials.nav')
	@else
		<!-- we do not show the menu bar becasue this is the product page -->
		@include('partials.nav')
	@endif


	<div class="container-fluid" style="
    margin-left: 0%;
    margin-right: 0%;
    padding: 0%;
	">
		@yield('content')
	</div>

	

	<!-- Scripts -->
	
	<!-- 	Local -->
	<script src="/js/vendor/vue.min.js"></script>
	<script src="/js/vendor/vue-resource.min.js"></script>
	<script src="/js/components/product.js"></script>
	<!-- 	CDNS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>


@extends('app')



@section('content')

<h3>
	Test Page 
</h3>

<br><br>

<div class="container-fluid" id="product">

	<input type="hidden" v-model="cart_id" value="{{ $cart_info->id }}">

	<div class="row">

	  	<div class="col-sm-8">
				<h4>{{ $cart_info->cart_name }} <small>by: {{ $uid }}</small></h4>
		</div>

		<div class="col-sm-2"><button style="float: right;" class="btn btn-primary" type="button">
				Saved <span class="badge">4</span>
			</button>
		</div>

		<div class="col-sm-2"><button style="float: right;" class="btn btn-primary" type="button">
				Mined <span class="badge">4</span>
			</button>
		</div>

	</div>

	<h5>Description: {{ $cart_info->cart_description }}</h5>

	<br>

	<h5>updated: {{ $cart_info->updated_at }}</h5>

	<br>

	<div class="row">

			<div class="col-sm-7">
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Copy</button>
					</span>
					<input type="text" class="form-control" placeholder="Link Url...">
				</div>
			</div>

			<div class="col-sm-2"></div>

			<div class="col-sm-1"> <a class="btn btn-social-icon btn-twitter">
    			<i class="fa fa-twitter"></i></a>
    		</div>

			<div class="col-sm-1"><a class="btn btn-social-icon btn-facebook">
    			<i class="fa fa-facebook"></i></a>
    		</div>

			<div class="col-sm-1"><a class="btn btn-social-icon btn-github">
    			<i class="fa fa-github"></i></a>
    		</div>

	</div>



	<div class="row">

	  	<div class="col-sm-6">

			<div class="list-group">
				<a v-repeat="product : products" href="#" class="list-group-item">
					<h5>@{{ product.product_name }}</h5>
					<h5>@{{ product.product_description }}</h5>
					</a>
			</div>

	  	</div>



	  	<div class="col-sm-6">
	  		
	  			
			<div class="panel panel-default">
				<div class="panel-body" style="height: 300px;">
					<div class="input-group">
	  					<!-- <span class="input-group-addon" id="basic-addon1">@</span> -->
	  					<input type="text" class="form-control" placeholder="product name..">
					</div>
				</div>
			</div>

	  	</div>

	</div>

</div>

<script src="/js/vendor/vue.min.js"></script>
<script src="/js/vendor/vue-resource.min.js"></script>

@endsection


@extends('app')



@section('content')
<div id="product" style="width: 100%;">
	<input type="hidden" v-model="cart_id" value="{{ $cart_info->id }}">

	<!-- left side -->
  	<div style="width: 40%; height: 800px; margin-top: -2%; float: left; border-right: 1.33px solid #ccc;">
  		<br><br>

  		<!-- sharing, editing, icons -->
  		<!-- <div style="width: 100%; height: auto; border: none;">
  			<div style="height: auto; width: 200px; float: right; border: none; margin-right: 60px;">
  				<i style="float: right; font-size: 1.5em; color: #5eb8ad;" class="fa fa-link"></i>
  				<i style="float: right; font-size: 1.5em; margin-right: 20px; color: #5eb8ad;" class="fa fa-twitter"></i>
  				<i style="float: right; font-size: 1.5em; margin-right: 20px; color: #5eb8ad;" class="fa fa-facebook"></i>
  			</div>
  		</div> -->

  		<!-- cart title and description -->

		<i class="fa" style="width: 100%; font-size: 1.5em; font-weight: 400; color: #555555; margin-left: 20px; margin-bottom: 5px; margin-top: 15px;">{{ $cart_info->cart_name }}</i>
		<a class="fa" style="width: 100%; font-size: .9em; font-weight: 400; color: #777777; margin: 0px 20px;">by: {{ $uid }}</a>
			
		<i class="fa" style="width: 100%; font-size: 1em; font-weight: 500; color: #777777; margin-left: 20px;">Description: {{ $cart_info->cart_description }}</i>

		<br><br><br>

		<!-- toolbar..."+"..."show"..."sort" -->

		<div class="row" style="border-bottom: 1px solid #ccc; width: 100%;">

			<div class="col-sm-2" style="padding-left: 30px;">
				<a v-on="click: createProduct = false">
					<div v-on="click: prepareToAddProduct">
		  				<span class="glyphicon glyphicon-plus" aria-hidden="true" 
		  					style="font-size: 1.5em; color: #5eb8ad" 
		  					data-toggle="tooltip" title="Add Product">
		  				</span>
		  			</div>
		  		</a>
		  	</div>

	  		<div class="col-sm-10">
	  		

		  		<div class="btn-group" style="float: right;">
					<button style="border: none;" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						sort <span class="caret"></span>
					</button>

					<ul class="dropdown-menu" style="width: auto;">

						<li><input v-model="search" class="form-control" style="
	    					width: 226.22222042083743px;
	    					margin-left: 10px;
	    					margin-right: 10px;"
	    					placeholder="search by name"
							>
						</li>

						<li role="separator" class="divider"></li>
						<li><a v-on="click: sortProductsBy('product_name')">alphabet</a></li>
						<li><a v-on="click: sortProductsBy('id')">id </a></li>

					</ul>
				</div>

				<div class="btn-group" style="float: right;">
					<button style="border: none;" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						show <span class="caret"></span>
					</button>

					<ul class="dropdown-menu" style="width: auto;">

						<li><a v-on="click: sortProductsBy('product_name')">received items</a></li>
						<li><a v-on="click: sortProductsBy('id')">inactive items</a></li>

					</ul>
				</div>
	  		</div>
	  	</div>

	  	<!-- product list -->

	  	<div v-repeat="products | filterBy search in 'product_name' | orderBy sortProductsKey reverseProduct"
			v-on="click: newProducts.id = id, mouseenter: currentProductIdFromHover = id, click: showAllLinks = true"
			class="productList actives"
			>
								
				<i id="productListName" class="fa" style="width: 100%; font-size: 1.0em; font-weight: 500;">
					@{{ product_name }}
					@{{ id }}
					<span style=" float: right; color: #ffffff;"   
						class="glyphicon glyphicon-trash"
						v-on="click: onDeleteProduct"
						>
					</span>

					<i style="float: left; margin-right: 10px; font-size: 1.3em; position: relative; bottom: 2px;" class="fa fa-circle-thin"></i>
				
				</i>
		</div>

			<!-- <pre>clicked id: @{{ newProducts.id }}</pre>
			<pre>clicked Product Name: @{{ newProducts.product_name }}</pre>
			<pre>Hovering: @{{ currentProductIdFromHover }}</pre>
			<pre>Product Length: @{{ productsLength }}</pre> -->
			<!-- <pre>showAllLinks: @{{ showAllLinks }}</pre>
 -->  	</div>





  	<!-- right side -->
  	<div style="width: 60%; float:right;">

  	<!-- right nav bar -->	
  	<!-- <div style="height: 50px; width: 100%; background-color: #99dfbd;">


  			<div style="width: 100px; height: 100%; background-color: #008e92; display: inline-block;"></div>
  			<div style="width: 100px; height: 100%; background-color: #008e92; display: inline-block;"></div>


  	</div> -->


  	<br><br>

  		<div style="padding-left: 30px;
    		padding-right: 30px;
			">

			<!-- Header Text with edit button -->
								
			<i class="fa" style="font-size: 1.30em; font-weight: 400; color: #5eb8ad; width: 100%; padding-bottom: 10px;" v-show="editProduct">
				@{{ newProducts.product_name }}
				<span  style="font-size: .75em; color: #5eb8ad"
					class="glyphicon glyphicon-pencil"
					v-on="click: editProduct = false"
					v-if="newProducts.id != ''"
					>
				</span>
			</i>

			
			<i v-show="editProduct" class="fa" style="color: #777777;">
				@{{ newProducts.product_description }}
			</i>
			

<br><br>

			<!-- create form -->
			<div v-show="! createProduct">
				<h4>Add new product info</h4>
			</div>

			<form method="POST" v-on="submit: onCreateProduct">
				<div class="form-group" style="
					padding-right: 30px;
					margin-right: 0px;"
					v-show="! createProduct"
					>
					<br>

					<input type="text" class="form-control" placeholder="Product name..." v-model="newProducts.product_name">
					
					<br>
					
					<textarea type="text" class="form-control" rows="3" placeholder="Product description..." v-model="newProducts.product_description">
												
					</textarea>

					
					<br>
					<div style="float: right">

						<button type="submit" class="btn btn-primary">Save</button>

						<button type="button" class="btn btn-danger" 
							v-on="click: createProduct = true"
							>
							Cancel
						</button>

					</div>
				</div>
			</form>

			<!-- edit form -->
			<div v-show="! editProduct">
				<h4>Edit product info</h4>
			</div>

			<form method="POST" v-on="submit: onEditProduct">
				<div class="form-group" style="
					padding-right: 30px;
					margin-right: 0px;
					margin-bottom: 35px;"
					v-show="! editProduct"
					>
					<br>
					
					<input type="text" class="form-control" v-model="newProducts.product_name">
					
					<br>
					
					<textarea type="text" class="form-control" rows="3" v-model="newProducts.product_description">
												
					</textarea>

					
					<br>
					<div style="float: right">

						<button type="submit" class="btn btn-primary">
							Save
						</button>

						<button type="button" class="btn btn-danger" 
							v-on="click: editProduct = true"
							>
							Cancel
						</button>

					</div>
				</div>
			</form>
			
		</div>

		<!-- toolbar -->
		<div v-show="showAllLinks" class="row" style="padding: 5px 0px; margin: 0px 0px; display: block;">
			
			<input type="hidden" v-model="searchLinks">
			<div class="col-sm-7"><input v-model="searchLinks" class="form-control" style="
				width: 226.22222042083743px;
				margin-left: 0px;
				margin-right: 10px;"
				placeholder="search by name"
				>
			</div>

			<div class="col-sm-3" style="margin-top: 15px;">
				<a v-on="click: sortLinksBy('merchant_name')">Merchant Name</a>
			</div>

			<div class="col-sm-2" style="margin-top: 15px;">
				<a v-on="click: filterLinksBy('all')">show all</a>
			</div>

		</div>

		<!-- all links -->
		
		<div v-repeat="links | filterBy searchLinks in filterByKey |orderBy sortLinksKey reverseLink" v-show="showAllLinks" class="linkList">
			<!-- <i style="float: left; margin-right: 10px; font-size: 1.3em; position: relative; bottom: 2px;" class="fa fa-circle-thin"></i> -->
			<i class="fa"> @{{ merchant_name }} </i>
			<i class="fa"> @{{ id }} </i>

			<div class="row">
				<div class="col-sm-8"><p>@{{ product_link }}</p></div>
				<div class="col-sm-4"><p>@{{ price | currency }}</p></div>
			</div>	

		</div>
  	</div>
</div>



<!-- scripts -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script>

	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})

</script>

<script src="/js/vendor/vue.min.js"></script>
<script src="/js/vendor/vue-resource.min.js"></script>

@endsection


  
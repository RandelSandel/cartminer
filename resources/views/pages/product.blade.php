@extends('app')



@section('content')

<div id="product">

	<input type="hidden" v-model="cart_id" value="{{ $cart_info->id }}">

	@include('partials.product_header')

<hr style="width: 100% overflow: visible; margin-left: -10%; margin-right: -10%;">
	
	<br>

	<!-- header module tool bar..."+".... -->

	<div class="row">

		<div class="col-sm-1" style="padding-left: 20px;">
			<a v-on="click: createProduct = false">
				<div v-on="click: prepareToAddProduct">
	  				<span class="glyphicon glyphicon-plus" aria-hidden="true" 
	  					style="font-size: 1.5em; color: #5eb8ad" 
	  					data-toggle="tooltip" title="Add Product">
	  				</span>
	  			</div>
	  		</a>
	  	</div>

	  	<div class="col-sm-4"></div>

	  	<div class="col-sm-7"></div>

	</div>

	<!-- left module with product info -->
	
	
	
	<div class="row">

	  	<div class="col-sm-5">
	
			<div v-repeat="product : products"
				v-on="click: newProducts.id = product.id, mouseenter: currentProductIdFromHover = product.id"
				class="productList actives"
				>	
					<i id="productListName" class="fa" style="width: 100%; font-size: 1.0em; font-weight: 500;">
						@{{ product.product_name }}
						<span style=" float: right; color: #ffffff;" 
							class="glyphicon glyphicon-trash"
							v-on="click: onDeleteProduct"
							>
						</span>
					</i>
			</div>

	  	</div>



	  	<div class="col-sm-7">
	  		
	  		<!-- right module -->
	
				<div style="padding-left: 30px;
    				padding-right: 30px;
					">

					<!-- Header Text with edit button -->
					
						
					<i class="fa" style="font-size: 1.5em; width: 100%; padding-bottom: 10px;" v-show="editProduct">
						@{{ newProducts.product_name }}
						<span  style="font-size: .75em; color: #5eb8ad"
							class="glyphicon glyphicon-pencil"
							v-on="click: editProduct = false"
							v-if="newProducts.id != ''"
							>
						</span>
					</i>

					<i v-show="editProduct" class="fa" >
						@{{ newProducts.product_description }}
					</i>

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
					
					<!-- <p v-text="pi">@{{ pi }}</p> -->
				</div>

				<!-- link module inside right module -->
				
				<div class="panel-body" style="
    				padding-left: 30px;
    				padding-right: 30px;"
    				v-show="createProduct"
    				>

					<div class="list-group">
						<div class="list-group-item" v-repeat="l : links">
							<div class="row">
								  <div class="col-sm-8"><p>@{{ l.product_link }}</p></div>
								  <div class="col-sm-4"><p>@{{ l.price }}</p></div>
							</div>	
						</div>
					</div>

				</div>	

	  	</div>

	</div>

	<!-- json information and debugging area -->
	<br>
	<div class="panel panel-default">
		<div class="panel-body">

				<!-- <h6 v-repeat="c : combo">@{{ c | json }}</h6> -->
				<p>Current Product to delete: <span v-text="currentProductIdFromHover"></span></p>
				<p>Current product Selected: <span v-text="newProducts.id"></span></p>
				<p v-text="newProducts.product_name"></p>
				<p v-text="newProducts.product_description"></p>
				<p>Product Length: <span v-text="productsLength"></span></p>
				<!-- <pre v-repeat="p : products">@{{ p | json }}</pre> -->

		</div>
	</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script>

	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})

</script>

<script src="/js/vendor/vue.min.js"></script>
<script src="/js/vendor/vue-resource.min.js"></script>

@endsection



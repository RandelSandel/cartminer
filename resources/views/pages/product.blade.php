@extends('app')



@section('content')
<div id="product" style="width: 100%;">

	<input type="hidden" v-model="cart_id" value="{{ $cart_info->id }}">

	<!-- Main header tool bar -->

	
	<div class="mainDIV">

	    <div class="leftDIV"></div>

	    <div class="middleDIV">

	    	<input type="hidden" v-model="searchLinks">
	    	<div v-show="showAllLinks" style="width: auto; height:50px; padding: 10px 5px 5px 5px">
				
				<input v-model="searchLinks"  style="
					width: 200px;
					margin-left: 5px;
					height: 30px;
					"
					placeholder="search by name"
					>
				
				<a style="color: white; position: relative; float: right; margin-right: 20px; margin-top: 5px;" v-on="click: sortLinksBy('merchant_name')">Sort</a>
				
				<a style="color: white; position: relative; float: right; margin-right: 15px; margin-top: 5px;" v-on="click: filterLinksBy('all')">Show</a>


			</div>

	    </div>

	    <div class="rightDIV">

	    	<!-- <input type="hidden" v-model="searchLinks"> -->
	    	<div v-show="showAllLinks" style="width: auto; height: 50px; padding: 10px 5px 5px 5px">
				
	    		<form method="POST" v-on="submit: fetchSearchAmazon">
					<input v-model="searchMerchantsInfo.searchAmazon"  style="
						width: 30%;
						margin-left: 5px;
						height: 30px;
						"
						placeholder="search by name"
						>
					<button type="submit" style="position: relative; left: -.5%; border: 0px 0px 0px 2px; border-style: solid; height: 30px;">Find</button>
				</form>

				<!-- <select name="select" style="height: 30px; display: inline;">
					<option value="value1" selected>Amazon</option> 
					<option value="value2">Mouser</option>
					<option value="value3">Sparkfun</option>
				</select>
				
				<a style="color: white; position: relative; float: right; margin-right: 20px; margin-top: 5px;" v-on="click: sortLinksBy('merchant_name')">Sort</a>
				
				<a style="color: white; position: relative; float: right; margin-right: 15px; margin-top: 5px;" v-on="click: filterLinksBy('all')">Show</a>
 -->
			</div>

	    </div>

	</div>




	
	<div class="mainDIVBody">
	    <div class="leftDIVBody">

	    	<!-- cart title and description -->

			<i class="fa" style="width: 100%; font-size: 1.5em; font-weight: 400; color: #555555; margin-left: 20px; margin-bottom: 5px; margin-top: 15px;">{{ $cart_info->cart_name }}</i>
			<a class="fa" style="width: 100%; font-size: .9em; font-weight: 400; color: #777777; margin: 0px 20px;">by: {{ $uid }}</a>
			<br>
			<i class="fa" style="width: 100%; font-size: .9em; font-weight: 400; color: #777777; margin-left: 20px;">Description: {{ $cart_info->cart_description }}</i>

			<br><br><br>

			<div style="border: none; width: 100%; height: 50px; padding-top: 20px; background-color: #555">


				<!-- + -->
				<a v-on="click: createProduct = false, click: prepareToAddProduct" style="margin-left: 15px;">
		  				<span class="glyphicon glyphicon-plus" aria-hidden="true" 
		  					style="font-size: 1.5em; color: #ffffff" 
		  					data-toggle="tooltip" title="Add Product">
		  				</span>
		  		</a>
			  	

		  		
		  		<!-- sort -->
		  		<span style="margin-bottom: 2px; margin-right: 10px; position: relative; float: right;">
					<button style="border: none; background: none; color: white;" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
				</span>


				<!-- show -->
				<div style="margin-bottom: 2px; margin-right: 5px; position: relative; float: right;">
					<button style="border: none; background: none; color: white;" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						show <span class="caret"></span>
					</button>

					<ul class="dropdown-menu" style="width: auto;">

						<li><a v-on="click: sortProductsBy('product_name')">received items</a></li>
						<li><a v-on="click: sortProductsBy('id')">inactive items</a></li>

					</ul>
				</div>

		  	</div>

		  		<!-- product list -->
		  	<div v-repeat="products | filterBy search in 'product_name' | orderBy sortProductsKey reverseProduct"
				v-on="click: newProducts.id = id, mouseenter: currentProductIdFromHover = id, click: showAllLinks = true"
				class="productList actives" 
				v-class="selectProductWithColor: newProducts.id == id"
				>

					<i id="productListName" class="fa" style="width: 100%; font-size: .9em; font-weight: 500;">
						@{{ product_name }}
						@{{ id }}
						<span id="trashCan" style=" float: right; color: #ffffff;"   
							class="glyphicon glyphicon-trash"
							v-on="click: onDeleteProduct"
							>
						</span>

						<span  style="font-size: 1em; color: #ffffff; margin-right: 10px; float: right;"
							class="glyphicon glyphicon-pencil"
							v-on="click: editProduct = false"
							>
						</span>

						<i style="float: left; margin-right: 10px; font-size: 1.3em; position: relative; bottom: 2px;" class="fa fa-circle-thin"></i>
					
					</i>

					<i id="productListName" class="fa" style="margin-left: 26px; margin-top: 5px; font-size: .9em;" v-if="newProducts.id == id">
						Note: @{{ product_description }}
					</i>
			</div>

				<!-- <pre>clicked id: @{{ newProducts.id }}</pre>
				<pre>clicked Product Name: @{{ newProducts.product_name }}</pre>
				<pre>Hovering: @{{ currentProductIdFromHover }}</pre>
				<pre>Product Length: @{{ productsLength }}</pre> -->
				<!-- <pre>showAllLinks: @{{ showAllLinks }}</pre>--> 
	    </div>

	    <div class="middleDIVBody">

	    	<!-- Header Text with edit button -->
									
		<!-- 	<i class="fa" style="font-size: 1.30em; font-weight: 400; color: #5eb8ad; width: 100%; padding-bottom: 10px;" v-show="editProduct">
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
			</i> -->

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
						padding-left: 30px;
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

	    	<div style="overflow-y: auto; height: 500px;">
				<div v-repeat="links | filterBy searchLinks in filterByKey |orderBy sortLinksKey reverseLink" v-show="showAllLinks" class="linkList">

					<i class="fa"> @{{ merchant_name }} </i>
					<i class="fa"> @{{ id }} </i>

					<div class="row">
						<div class="col-sm-8"><p>@{{ product_link }}</p></div>
						<div class="col-sm-4"><p>@{{ price | currency }}</p></div>
					</div>	
				</div>
			</div>
	    </div>



	    <div class="rightDIVBody">

	    	 <!-- <pre>searchAmazon: @{{ searchMerchantsInfo.searchAmazon }}</pre>  -->

	    	 <!-- search response -->

	    	 <div style="overflow-y: auto; height: 500px;">
	    	 	<div v-repeat="searchResponse" class="linkList">

	    	 		<!-- <img src="@{{ MediumImage.URL }}" alt="...">
	    	 		<i class="fa"> @{{ ItemAttributes.Title }} </i>
	    	 		<pre>@{{ MediumImage.URL }}</pre> 

	    	 		<div class="row">
						<div class="col-sm-8"><p>@{{ DetailPageURL }}</p></div>
						<div class="col-sm-4"><p>@{{ Offers.Offer.OfferListing.Price.FormattedPrice }}</p></div>
					</div> -->

					<div class="media">

						<div class="media-left">
							<a href="@{{ DetailPageURL }}">
								<img class="media-object" src="@{{ MediumImage.URL }}" alt="...">
							</a>
						</div>

						<div class="media-body">
							<i style="font-size: .9em;" class="fa media-heading">@{{ ItemAttributes.Title }}</i>
							@{{ Offers.Offer.OfferListing.Price.FormattedPrice }}
						</div>

					</div>

	    	 		
	    	 	</div>
	    	 </div>



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


  
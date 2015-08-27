@extends('app')



@section('content')

<div id="dashboard">

		
		<input type="hidden" v-model="user_id" value="{{ $uid }}">
		<p> @{{ user_id }}</p>

		<!-- control panel -->
		<div class="panel panel-default" style="width: 700px; margin: 20px auto 0px; border: none; -webkit-box-shadow: none">

			<div class="panel-body" style="padding-bottom: 5px;">
		    

				<!-- Horizontal Columns  -->
				<div class="row">
					<!-- user name -->
					<div class="col-xs-12 col-sm-6 col-md-8">
						<h3>{{ $name }}</h3>
					</div>
					<!-- navigation links -->
					<div class="col-xs-12 col-sm-6 col-md-8">
						<ul class="list-inline">
							<li>
								<a href="#" style="padding-right: 10px;" v-on="click: sortBy('name')">Created</a>
								<a href="#" style="padding-right: 10px;" v-on="click: sortBy('name')">Active</a>
								<a href="#" style="padding-right: 10px;" v-on="click: sortBy('name')">Following</a>
							</li>
						</ul>
					</div>

					<!-- Icon Links -->
					<div class="col-xs-6 col-md-4">
						<ul class="list-inline">
							<li style="float: right; padding-right: 0px;">
								<a href="#" style="padding-right: 20px;"><span class="glyphicon glyphicon-cog" aria-hidden="false" style="font-size: 1.2em;"></span></a>
								<a v-on="click: showForm.createCart = true" style="padding-right: 0px;"><span class="glyphicon glyphicon-plus" aria-hidden="false" style="font-size: 1.2em;"></span></a>
								
							</li>
						</ul>
					</div>

				</div>

				</br>
				</br>
				</br>

				<!-- Horizontal Columns  -->
				<div class="row">

					<!-- search form -->
					<div class="col-xs-12 col-sm-6 col-md-8" style="padding-left: 0px;">
						<input v-model="search" class="form-control" placeholder="Search Carts">
					</div>

					<!-- filter by button -->
					<div class="col-xs-6 col-md-4">
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true" style="float: right;">
							Filter
							<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
								<li role="presentation"><a role="menuitem" tabindex="-1" href="#" v-on="click: sortBy('name')">Alphabetical</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="#" v-on="click: sortBy('likes')">Most Likes</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="#" v-on="click: sortBy('name')">Status</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="#" v-on="click: sortBy('name')">Top Performers</a></li>
							</ul>
						</div>
					</div>

				</div>

			</div>

		</div>

		
	<br>
		
		<!-- <pre>@{{ currentlyHovering.cartId }}</pre> -->
		<!-- listed carts area -->
		<div style="border: 0px solid #777;" class="list-group">
			
			<ul style="padding-left: 0px; width: 700px; margin: auto; border: 0px solid #777;">

				<!-- create cart form -->
				<div v-show="showForm.createCart" style="padding: 10px 0px 30px 5%; margin-bottom: 20px; border: 3px solid #5eb8ad;">
					<div>
						<h4>Add new list</h4>
					</div>

					<form method="POST" v-on="submit: onCreateCart">
						<div class="form-group" style="
							padding-right: 30px;
							margin-right: 0px;"
							>
							<br>

							<input type="text" class="form-control" placeholder="List name..." v-model="newCart.cart_name">
							
							<br>
							
							<textarea type="text" class="form-control" rows="3" placeholder="List description..." v-model="newCart.cart_description">
														
							</textarea>

							
							<br>
							<div style="float: right">

								<button type="submit" class="btn btn-primary">Save</button>

								<button type="button" class="btn btn-danger" 
									v-on="click: showForm.createCart = false"
									>
									Cancel
								</button>

							</div>
						</div>
					</form>
				</div>

				<!-- cart list -->
				<i v-repeat="carts | filterBy search | orderBy sortKey reverse" 
					class="list-group-item" v-on="mouseover: currentlyHovering.cartId = id" 
					>
					
					<span style="float: right; color: blue;"   
						class="glyphicon glyphicon-trash"
						v-on="click: onDeleteCart"
						>
					</span>

					<a href="product/@{{ id }}"> cart name: @{{ cart_name }} </a>
					<p> cart description: @{{ cart_description }} </p>
					<p> id: @{{ id }} </p>

					

					<!-- <span  style="font-size: 1em; color: #ffffff; margin-right: 10px; float: right;"
						class="glyphicon glyphicon-pencil"
						v-on="click: showEditProductForm, 
						mouseenter: currentlyHovering.editButton = true, 
						mouseleave: currentlyHovering.editButton = false"
						>
					</span> -->
					
				</i>
			</ul>
			
		</div>


</div>

<script src="/js/vendor/vue.min.js"></script>
<script src="/js/vendor/vue-resource.min.js"></script>
<script src="js/components/dashboard.js"></script>



@endsection

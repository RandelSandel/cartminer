<div class="row, panel panel-default" 
		style="padding-left: 0px;
    	padding-right: 0px;
    	border: none;
    	box-shadow: none;"
    	>

		<div class="row">

	  		<div class="col-sm-6 col-md-8">
				<h3 class="fa" style="width: 100%; font-size: 1.9em; font-weight: 700;">{{ $cart_info->cart_name }} <small>by: {{ $uid }}</small></h3>
			</div>

			<div class="col-sm-2 col-md-2" style="margin-top: 15px; left: 60px;">
				<div class="btn-group">

					<button type="button" class="btn btn-danger">Share</button>

					<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>

					<ul class="dropdown-menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#">Separated link</a></li>
					</ul>
				
				</div>
			</div>

			<div class="col-sm-2 col-md-1">
					<button style="float: right; margin-top: 15px;" class="btn btn-primary" type="button">
					Saved <span class="badge">4</span>
					</button>
			</div>

			<div class="col-sm-2 col-md-1">
				<button style="float: right; margin-top: 15px;" class="btn btn-primary" type="button">
				Mined <span class="badge">4</span>
				</button>
			</div>

		</div>



		<h4 class="fa" style="width: 100%; font-size: 1.2em; font-weight: 500;">Description: {{ $cart_info->cart_description }}</h4>
		
		
		<!-- <h5>Last updated: {{ $cart_info->updated_at }}</h5> -->


	<!-- 	<div class="row">

				<div class="col-sm-7 col-md-7">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">Copy</button>
						</span>
						<input type="text" class="form-control" placeholder="Link Url...">
					</div>
				</div>

				<div class="col-sm-2 col-md-2"></div>

				<div class="col-sm-1 col-md-1"> <a class="btn btn-social-icon btn-twitter" style="float: right;">
	    			<i class="fa fa-twitter"></i></a>
	    		</div>

				<div class="col-sm-1 col-md-1"><a class="btn btn-social-icon btn-facebook" style="float: right;">
	    			<i class="fa fa-facebook"></i></a>
	    		</div>

				<div class="col-sm-1 col-md-1"><a class="btn btn-social-icon btn-github" style="float: right;">
	    			<i class="fa fa-github"></i></a>
	    		</div>

		</div> -->

</div>
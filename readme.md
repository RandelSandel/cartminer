Configurations:

changed file permission for Storage to 777 but left public as 755.

Changes made from 5.0 to 5.1

added files and directories to views:

	views > app.blade.php
		- configured scripts and css libraries. e.g. sass, vue, bootstrap
		- in this master view page we changed the app.css to all.css for a future gulp compiled file
		
	partials > nav.blade.php
		
	auth >
		password.blade.php
		reset.blade.php
		register.blade.php
		reset.blade.php
	
	emails directory > password.blade.php
	
	errors directory > 503.blade.php



added files and directories to resources > assets:

	assets > sass
	sass > partials
	partials > _colors.scss, _headers.scss
	sass > app.scss
	
	Deleted: less directory
	

added files and directories to public

	css > vendor > bootstrap.min.css 
		copy pasted script from cdn
		
	js > vendor > vue-resource.min.json
		copy pasted script from cdn
		
	
configure gulp file 

	in the gulpfile.js we edit the less to sass so we can compile with gulp
	
		elixir(function(mix) {
			mix.sass('app.scss');

			mix.styles([
			'vendor/bootstrap.min.css',
			'app.css'
			], null, 'public/css');
		});


	changed gulp version to 3.9.0 in package.json file
	
	
updated routes and controllers

	- added Authentication routes
	- added PagesController@home routes
	
	
added controllers

	Auth > PagesController.php
		-copy pasted file
		

left alone these directories, with different files than 5.0

	Middleware
	Providers

	
	

	
	
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value'); 


new Vue ({
	
	el: '#product',
	
	data: {

		cart_id: '',

		// this is an array of all the products that is seen on the DOM
		products: [],

		productsLength: '',

		// deleteTriggered: null,

		// combined links for all the products of one cart
		combo: [],

		newProducts: {

			id: '',
			cart_id: '',
			product_name: '',
			product_description: '',
			active: '0',
			primary_product_link_id: ''

		},

		// the current product id the mouse is hovering over
		currentProductIdFromHover: '',

		// an array of the links for only one specific product
		links: [],

		// true means we do NOT see the form and false means we do see the form
		editProduct: true,

		// true means we do NOT see the form and false means we do see the form
		createProduct: true,

		// false means we do not show the primary product
		showPrimaryLink: false,

		showAllLinks: false,

		sortProductsBy: 'filtPrimaryLink',

		sortProductsKey: '',

		reverseProduct: false,

		search: '',

		searchLinks: '',

		searchMerchantsInfo: {
			searchAmazon: '',
			otherParam: 'hello world'
		},

		searchResponse: [],
		

		filterByKey: '',

		sortLinksKey: '',

		reverseLink: false,

		// the primary key for the newly created product
		lastProductId: '',

		primaryProductLink: []

	},

	watch: {
		
		// UPDATETING THE PRODUCT COUNT/LENGTH IN THE VUE INSTANCE
		'products': function () {

			var len = this.products.length;
			this.productsLength = len;
		},



		// CREATING A NEW PRODUCT / SELECTING A PRODUCT
    	'newProducts.id': function (val, oldVal) {

    		console.log('new: %s, old: %s', val, oldVal);
      		
      		
      		// true means we do not see the form, however if we click delete we should still see the form
      		this.createProduct = true; 
      		this.editProduct = true;

      		// true means we do in fact show the container
      		// this.showAllLinks: true;

      		// if the right module was not used yet set its content to null. This way when 
      		// the page first loads nothing will be displayed
      		if (oldVal != null) {
      			this.links = [];

      		}
      		else {}

      		// we want to display the product name and description before the product links 
      		// todo this we match the current product.id i.e. "val" to the correct product 
      		// from the product array
      		var pLen = this.productsLength;

      		for (var x = 0; x < pLen; x++) {

      			// if val is == to this.products[x].id
      			// then set name and description to approprate data var
      			if (val == this.products[x].id) {

      				var productName = this.products[x].product_name;
      				var productDescription = this.products[x].product_description;
      				var primaryProductLinkId = this.products[x].primary_product_link_id;

      				// pn and pd are used to set the data to the DOM
      				this.newProducts.product_name = productName;
      				this.newProducts.product_description = productDescription;
      				this.newProducts.primary_product_link_id = primaryProductLinkId;
      				//console.log(this.newProducts.product_name);
      			}
      			else{}

      		}

      		// for each c in combo if val is == to product_id then push val to li
      		var len = this.combo.length;

      		//console.log(len);

      		for( var i = 0; i < len; i++) {	

      			var prod_id = this.combo[i].product_id;
      			//console.log(prod_id);
      			
      			// we identify the corresponding product link(s) with the product id
      			if (prod_id == val) {

      				// we push the matching product links to the link array
      				this.links.push(this.combo[i]);

      			}
      			else {}

      		}

      		// sets the primary link
      		// if the primary product links id is NOT equal to 0 then we set the first link 
      		// in the array as the primary link  
      		// if (this.newProducts.primary_product_link_id != 0)	{
      		// 	this.searchLinks = this.newProducts.primary_product_link_id;
      		// }

      		// else {

      		// 	// else we use the first link in the array as the primary or there is no
      		// 	// links so we dont do anything
      		// 	console.log(this.links[0].id);
      		// 		if (this.links[0].id = null){
      		// 			console.log('there are no links...its null');
      		// 			this.searchLinks = null;
      		// 		}
      		// 		else{
      		// 			this.searchLinks = this.links[0].id;
      		// 		}
      				
      		// }
      	}
    },


	ready: function() {
		
		this.fetchProducts();	
	},

	
	methods: {
		
		fetchProducts: function() {

			// set all the products to its assigned array and/or object
			this.$http.get('/api/products/' + this.cart_id, function(products) {

				// we set the products to the product object
				this.products = products;
				
				// we get the length of the product object
				var len = this.products.length;
				//console.log(len);

				for (var i = 0; i < len; i++) {

					// get the unique id for each product
					r = this.products[i].id;
					//console.log(this.products[i]);
					
					// use the product id "r" to get the links for each product
					this.$http.get('/api/product_links/' + r, function(product_links) {	

						var numberOfArrays = product_links[1].length; // number of links for a single product
						// console.log(numberOfArrays);
						for (var n = 0; n < numberOfArrays; n++){

							var o = product_links[1][n];
							//console.log(o);

							// for each products "id" we check to see where the product_links "product_id" matches
							for (var k = 0; k < len; k++){

								if (this.products[k].id == o.product_id){

									// console.log(o);
									// when the == we join the link to the product
									this.combo.push(o);
								}
								else {
									// we do nothing if there is no match
								}
							}
						}
					});	
				}
			});	
		},

		prepareToAddProduct: function () {

			// we set the form to blank
			this.newProducts.id = '';
			this.newProducts.product_name = '';
			this.newProducts.product_description = '';

		},

		onEditProduct: function (e) {
			e.preventDefault();

			// set editProduct to true so the form dissapears from the DOM
			this.editProduct = true;
			
			var val = this.newProducts.id;
			//console.log(val);
			var products = this.newProducts;
			// console.log(products);
			// update vue pn and pd if neccessary (this is not the DB)
			// make something true to verify submission
			this.$http.post('/api/editProduct/' + val, products, function(response) {

				var success = response.success;

				if (success) {
					console.log("the update was successfull");

					// where the newly edited id is equal to the product id update the product array
					for (var i = 0; i < this.productsLength; i++) {

						if (this.newProducts.id == this.products[i].id) {

							// delete the original entry
							this.products.splice(i, 1);
							
							// push the updated entry to the product array
							this.products.push(this.newProducts);

							this.newProducts = { id: '', cart_id: '', product_name: '', product_description: '', active: '0'};

						}
						else{}
					}

				}
				else {
					console.log("whoops something went wrong, your data might not have been saved");
				}

			}.bind(this));

		},

		onCreateProduct: function (e) {
			e.preventDefault();

			// set createProduct to true so the form dissapears from the DOM
			this.createProduct = true;

			// set product cart_id
			this.newProducts.cart_id = this.cart_id;

			// we use 0 as the default for all product with no set primary product id
			this.primary_product_link_id = 0;

			// add new product to object
			var products = this.newProducts;
			// var t;
			// presist new product to products table
			this.$http.post('/api/createProduct', products, function(response) {
				
				// we get the new pk id so we can update the vue instance or DOM
				this.lastProductId = response.last_insert_id;
				// console.log(this.lastProductId);

				// we set the new pk to the current id
				this.newProducts.id = this.lastProductId;

				// add new product info with new pk id to instance for vue to display
				this.products.push(this.newProducts);

				// we set the newProducts data back to nothing
				this.newProducts = { id: '', cart_id: '', product_name: '', product_description: '', active: '0', primary_product_link_id: ''};

			}.bind(this));
		},

		// deleting a product
      	onDeleteProduct: function () {

      		var val = this.currentProductIdFromHover;

      		// delete the product from products table in the DB
      		this.$http.get('/api/deleteproduct/' + val);

      		// delete and update the product in the vue instance
      		var len = this.products.length;
      		// console.log(len);

      		for (var i = 0; i < len; i++){
      			if (this.products[i].id == val){
      				this.products.splice(i, 1);
      				return;
      			}
      			else{}
      		}
      	},

      	sortProductsBy: function (sortProductsKey){
      		this.reverseProduct = (this.sortProductsKey == sortProductsKey) ? ! this.reverseProduct : false;
      		this.sortProductsKey = sortProductsKey;
      	},

      	sortLinksBy: function (sortLinksKey){
      		this.reverseLink = (this.sortLinksKey == sortLinksKey) ? ! this.reverseLink : false;
      		this.sortLinksKey = sortLinksKey;
      	},

      	filterLinksBy: function (type) {

      		if (type == 'all') {

      			this.searchLinks = '';	
      		
      		}
      	},

      	fetchSearchAmazon: function(e) {

      		e.preventDefault();

      		var searchInfo = this.searchMerchantsInfo;
      		//var products = this.newProducts;
      		//console.log(searchInfo);

      		this.$http.post('/api/searchamazon', searchInfo, function(response) {

      			console.log(response[0].ASIN);
      			console.log(response[0].DetailPageURL);
      			console.log(response[0].Offers.Offer.OfferListing.Price.FormattedPrice);
      			console.log(response[0].ItemAttributes.Title);

      			this.searchResponse = response;

      		}.bind(this));

      	}
	}
});







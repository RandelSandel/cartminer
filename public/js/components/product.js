Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value'); 


new Vue ({
	
	el: '#product',
	
	data: {

		cart_id: '',

		// this is an array of all the products that is seen on the DOM
		products: [],

		productsLength: '',

		// deleteTriggered: null,

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

		currentProductLinkIdFromHover: '',

		productIdAndLinks: [],

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

		linkToAdd: {
			custom_id: '',
			product_id: '',
			title: '',
			product_link: '',
			price:'',
			image_url:'',
			image_height:'',
			image_width:''
		},
		

		filterByKey: '',

		sortLinksKey: '',

		reverseLink: false,

		// the primary key for the newly created product
		lastProductId: ''

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


      		// if the right module was not used yet set its content to null. This way when the page first loads nothing will be displayed
      		if (oldVal != null) {
      			this.links = [];

      		}
      		else {}

      		var pLen = this.productsLength;

      		for (var x = 0; x < pLen; x++) {

      			// then set clicked name and description to approprate data variables
      			if (val == this.products[x].id) {

      				this.newProducts.product_name = this.products[x].product_name;
      				this.newProducts.product_description = this.products[x].product_description;
      				this.newProducts.primary_product_link_id = this.products[x].primary_product_link_id;

      			}
      			else{}

      		}

    		// we set the links array for the DOM
      		var length = this.productIdAndLinks.length;

      		for( var i = 0; i < length; i++) {

      			if (val == this.productIdAndLinks[i].product_id) {

      				this.links = this.productIdAndLinks[i].product_links;

      				break;
      			}
      			else{}
      		}
      	},

      	'linkToAdd.custom_id': function (val, oldVal) {
      		console.log('the link to add has changed');

      		// this.linkToAdd.custom_id = '';
      		// this.linkToAdd.title = '';

      	}
    },


	ready: function() {
		
		this.fetchProducts();	
	},

	
	methods: {
		
		fetchProducts: function() {
			this.$http.get('/api/fetchProducts/' + this.cart_id, function(response) {

				// console.log(response.products);	
				this.products = response.products;

				console.log(response.links[0].product_id);
				this.productIdAndLinks = response.links;


			}.bind(this));
		},

		prepareToAddProduct: function () {

			// we set the create form to blank
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

      			// console.log(response[0].ASIN);
      			// console.log(response[0].DetailPageURL);
      			// console.log(response[0].Offers.Offer.OfferListing.Price.FormattedPrice);
      			// console.log(response[0].ItemAttributes.Title);
      			// console.log(response[0].MediumImage.URL);
      			// console.log(response[0].MediumImage.Height);
      			// console.log(response[0].MediumImage.Width);

      			this.searchResponse = response;

      		}.bind(this));

      	},

      	onAddLink: function(e) {
      		e.preventDefault();

      		this.linkToAdd.product_id = this.newProducts.id;

      		var newLinkInfo = this.linkToAdd;

      		// update the DB then after a success message...
      		this.$http.post('/api/addNewLink', newLinkInfo, function(response) {
      			console.log(response.success);
      		});

      		var customFormattedPrice = (this.linkToAdd.price / 100).toFixed(2);
			this.linkToAdd.price = customFormattedPrice;

			var newLinkInfoVue = this.linkToAdd;

      		// update the DOM by updating both links[] and productIdAndLinks[]
      		this.links.push(newLinkInfoVue);
      		// we update productIdAndLinks by calling the function
      		this.fetchProducts();

      		this.linkToAdd = { custom_id: '', product_id: '', title: '', product_link: '', price:'' };
      	},

      	onDeleteLink: function() {

      		// get the link id that we want to delete
      		// delete the link from the DB with the deleteLink API
      		// if successfull update the vue instance

      		var val = this.currentProductLinkIdFromHover;

      		this.$http.get('/api/deleteLink/' + val);

      		var len = this.links.length;
      		// console.log(len);

      		for (var i = 0; i < len; i++){
      			if (this.links[i].id == val){
      				this.links.splice(i, 1);
      				return;
      			}
      			else{}
      		}

      	}
	}
});







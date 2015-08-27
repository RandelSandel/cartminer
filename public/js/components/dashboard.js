Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value'); 




new Vue({
	
	el: '#dashboard',

	data: {

		carts: [],

		sortKey:'',
		
		reverse: false,

		user_id: '',

		showForm: {
			createCart: false
		},

		newCart: {
			user_id: '',
			cart_name: '',
			cart_description: ''
		},

		currentlyHovering: {
			cartId: ''
		}


	},


	ready: function() {

		this.fetchCarts();
	},


	
	methods: {

		fetchCarts: function() {

			this.$http.get('api/carts/' + this.user_id, function(response) {		
				this.carts = response						
																			
			});
		},
		
		sortBy: function(sortKey) {
			
			// if the last sortKey is equal to the current sortkey then 
			// reverse is equal to true else its equal to false.
			// this will help us decide to reverse a filter action or not
			this.reverse = (this.sortKey == sortKey) ?  ! this.reverse : false;
			
			// this assigns the sorkKey string to the sortkey data/variable
			this.sortKey = sortKey;
			
			
		},


		onCreateCart: function(e) {
			e.preventDefault();
			console.log('we are trying to create a cart');
			
			// set createCart to false so the form dissapears from the DOM
			this.showForm.createCart = false;

			// set carts user_id (owner) on the server side by calling auth()
			this.newCart.user_id = this.user_id;
			// add new product to object
			var cart = this.newCart;
			// var t;
			// presist new product to products table
			this.$http.post('/api/createCart', cart, function(response) {
				
				// we set the new pk to the current id
				this.newCart.id = response.last_insert_id;

				// add new product info with new pk id to instance for vue to display
				this.carts.push(this.newCart);

				// we set the newCart data back to nothing
				this.newCart = { user_id: '', cart_name: '', cart_description: ''};

				// we call the fetchProduct function so we can add links immediately
				// this.fetchCarts();


			}.bind(this));

		},

		onDeleteCart: function() {

			var val = this.currentlyHovering.cartId;
      		// delete the product from products table in the DB
      		this.$http.get('/api/deleteCart/' + val);

      		// delete and update the carts in the vue instance
      		var len = this.carts.length;
      		// console.log(len);

      		for (var i = 0; i < len; i++){
      			if (this.carts[i].id == val){
      				this.carts.splice(i, 1);
      				return;
      			}
      			else{}
      		}

		}
	}

	
	
});
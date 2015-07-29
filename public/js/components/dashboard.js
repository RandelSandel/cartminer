Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value'); 




new Vue({
	
	el: '#dashboard',

	data: {


		sortKey:'',
		
		reverse: false,

		user_id: '',


	},


	ready: function() {

		this.fetchCarts();
	},


	
	methods: {
		
		sortBy: function(sortKey) {
			
			// if the last sortKey is equal to the current sortkey then 
			// reverse is equal to true else its equal to false.
			// this will help us decide to reverse a filter action or not
			this.reverse = (this.sortKey == sortKey) ?  ! this.reverse : false;
			
			// this assigns the sorkKey string to the sortkey data/variable
			this.sortKey = sortKey;
			
			
		},

		


		fetchCarts: function() {


			this.$http.get('api/carts/' + this.user_id, function(carts) {		// we use .get() to retrieve a value from the vue instance given an expression
				this.$set('carts', carts);							// we then set a data value on the key instance given a valid keypath
																			// in this case we set the value messages to a "messages" array
			});
		}
	}

	
	
});
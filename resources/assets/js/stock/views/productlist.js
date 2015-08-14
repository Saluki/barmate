
app.views = app.views || {};

app.views.ProductList = Backbone.View.extend({

	el: '#product-list',

	template: _.template( $('#template-product-list').html() ),

	events: {

		'click .product'         : 'displayProduct',
		'click #add-product-btn' : 'showForm'
	},

	initialize: function() {

		this.listenTo(app.categories, 'changed', this.render);
	},

	render: function() {

        var content;

		if( app.categories.currentID == -1 ) {
			content = '';
		}
		else {
			var products = app.products.where({ category:app.categories.currentID });
			content = this.template( {'products':products} );
		}

		app.productForm.hide();
		this.$el.html( content );

		return this;
	},

	displayProduct: function(e) {

		var productID = $(e.target).data('product');

		if( productID === undefined )
			return;

		app.products.currentID = productID;
		app.productDisplay.render();
	},

	showForm: function(e) {

		app.productForm.show();
	}

});
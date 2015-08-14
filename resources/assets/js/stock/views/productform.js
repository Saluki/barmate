
app.views = app.views || {};

app.views.ProductForm = Backbone.View.extend({
	
	el: '#product-form',

	events: {
		'click #save-product-btn' : 'saveProduct'
	},

	initialize: function() {

		this.hide();

		this.$inputName = $('#p-name');
		this.$inputDescription = $('#p-description');
		this.$inputPrice = $('#p-price');
		this.$inputQt = $('#p-quantity');

		this.listenTo(app.productDisplay, 'render', this.hide);
		this.listenTo(app.categories, 'change', this.hide);
	},

	render: function() {
		return this;
	},

	show: function() {

		app.productDisplay.clear();
		app.productForm.$el.show();
	},

	hide: function() {

		this.$el.hide();
	},

	saveProduct: function() {

		var pName = this.$inputName.val();
		var pDescription = this.$inputDescription.val();
		var pPrice = parseFloat( this.$inputPrice.val() );
		var pQt = parseInt( this.$inputQt.val() );

		if( app.categories.currentID === undefined || app.categories.currentID == -1 )
			return;

        var errorMessage;

		if( pName.length < 1 || pName.length > 50 )
			errorMessage = 'Product name must be between 1 and 50 characters';

		if( pDescription.length > 250 )
			errorMessage = 'Description may not be longer than 250 characters';

		if( isNaN(pPrice) || pPrice < 0 )
			errorMessage = 'Price must be a positive number';

		if( isNaN(pQt) || pQt < 0 )
			errorMessage = 'Quantity must be a positive integer';

		if( errorMessage !== undefined ) {
			alertify.error(errorMessage);
			return;
		}

		var p = new app.model.Product({

			category: app.categories.currentID,
			name: pName,
			description: pDescription,
			price: pPrice,
			quantity: pQt
		});

		var currentView = this;

		p.save(null, {

			success: function(model, response) {

				app.products.add( p );
				app.productList.render();
				currentView.clearForm();
			},
			error: function(model, response) {

				alertify.error(response.responseJSON.message);
			}

		});

	},

	clearForm: function() {

		this.$inputName.val('');
		this.$inputDescription.val('');
		this.$inputPrice.val('');
		this.$inputQt.val('');
	}

});
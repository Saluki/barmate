
app.views = app.views || {};

app.views.ProductDisplay = Backbone.View.extend({
	
	el: '#product-display',

	editMode        : false,
	templateDisplay : _.template( $('#template-product-display').html() ),
	templateEdit    : _.template( $('#template-product-edit').html() ),

	events: {

		'click #remove-product' : 'askRemove',
		'click #edit-product'   : 'editProduct',
		'click #cancel-edit'	: 'displayMode',
		'click #update-product' : 'updateProduct'
	},

	initialize: function() {

		this.listenTo(app.categories, 'changed', this.clear);
	},

	render: function() {

		var product = app.products.get( app.products.currentID );

		if( product === undefined )
			return;

        var content;

		if( this.editMode === false )
			content = this.templateDisplay( product.toJSON() );
		else
			content = this.templateEdit( product.toJSON() );

		this.editMode = false;

		this.trigger('render');
		this.$el.html( content );
		
		return this;
	},

	askRemove: function() {

		alertify.confirm('Please confirm that you want to delete this product.', this.removeProduct);
	},

	removeProduct: function() {

		var productModel= app.products.get( app.products.currentID );

		if( productModel === undefined )
			return;

		productModel.destroy({

			success:function(model, response){

				app.productDisplay.clear();
				app.productList.render();
			},
			error: function(model, response){

				console.log(response);
			}

		});
	},

	updateProduct: function() {

		var productModel= app.products.get( app.products.currentID );

		if( productModel === undefined )
			return;

		var newName        = $('#product-update-name').val();
		var newDescription = $('#product-update-description').val();
		var newPrice       = parseFloat( $('#product-update-price').val() );
		var newQt          = parseInt( $('#product-update-qt').val() );

        var errorMessage;

		if( newName.length < 1 || newName.length > 50 )
			errorMessage = 'Product name must be between 1 and 50 characters';

		if( newDescription.length > 250 )
			errorMessage = 'Description may not be longer than 250 characters';

		if( isNaN(newPrice) || newPrice < 0 )
			errorMessage = 'Price must be a positive number';

		if( isNaN(newQt) || newQt < 0 )
			errorMessage = 'Quantity must be a positive integer';

		if( errorMessage !== undefined ) {
			alertify.error(errorMessage);
			return;
		}

		productModel.set({'name':newName,'description':newDescription,'price':newPrice,'quantity':newQt});

		var currentView = this;
		productModel.save(null, {

			success: function(model, response){

				currentView.displayMode();
				app.productList.render();

				alertify.success('Product <i>'+ model.get('name') +'</i> updated');
			},
			error: function(model,response){

				alertify.error( response.responseJSON.message );
			}
		});
	},

	editProduct: function() {

		this.editMode = true;
		this.render();
	},

	displayMode: function() {

		this.editMode = false;
		this.render();
	},

	clear: function() {

		this.$el.html('');
	}

});
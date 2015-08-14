
app.model = app.model || {};

app.model.Category = Backbone.Model.extend({

	urlRoot: '/app/stock/category',
	
	initialize: function(){},

	defaults: {

		title: '',
		description: '',
		active: true
	}

});

app.model = app.model || {};

app.model.Product = Backbone.Model.extend({

	urlRoot: '/app/stock/product',

	initialize: function(){},

	defaults: {

		category: 0,
		name: '',
		description: '',
		price: 0,
		quantity: 0
	}
});

app.collection = app.collection || {};

app.collection.Categories = Backbone.Collection.extend({
	
	model: app.model.Category,

	url: '/app/stock/category',

	currentID: -1,

	resetCurrentID: function() {

        this.currentID = -1;
		this.trigger('changed');
	},

	changeCurrentID: function(id) {

		var formatttedID = parseInt(id);

		if( formatttedID < 0 )
			return;

		this.currentID = formatttedID;
		this.trigger('changed');
	}
});

app.categories = new app.collection.Categories();


app.collection = app.collection || {};

app.collection.Products = Backbone.Collection.extend({
	
	model: app.model.Product,

	url: '/app/stock/product',

	currentID: -1

});

app.products   = new app.collection.Products();

app.views = app.views || {};

app.views.CategoryForm = Backbone.View.extend({
	
	el: '#new-category-form',

	initialize: function() {

		this.$inputTitle       = $('#c-title');
		this.$inputDescription = $('#c-description');
		this.$saveButton       = $('#btn-save-category');
	},

	events: {

		'click #btn-save-category': 'saveCategory'
	},

	render: function() {

		return this;
	},

	saveCategory: function() {

		var title       = this.$inputTitle.val();
		var description = this.$inputDescription.val();

        var errorMessage;

		if( title.length < 1 )
			errorMessage = 'Title may not be empty';

		if( title.length > 50 )
			errorMessage = 'Title may not be longer than 50 characters';

		if( errorMessage !== undefined ) {
			alertify.error(errorMessage);
			return; 
		}

		var currentView = this;

		var category = new app.model.Category({ title:title, description:description });
		category.save(null, {

			success: function(model, response) {

				app.categories.add( category );
				currentView.clearForm();

				alertify.success('Category <i>'+ model.get('title') +'</i> created');
			},
			error: function(model, response) {

				alertify.error('Problem on the server');
			}
		});
	},

	clearForm: function() {

		this.$inputTitle.val('');
		this.$inputDescription.val('');
	}

});

app.views = app.views || {};

app.views.CategoryItem = Backbone.View.extend({

	className: 'category-item',
	
	editMode        : false,
	templateDefault : _.template( $('#template-category').html() ),
	templateEdit    : _.template( $('#template-category-edit').html() ),

	initialize: function(){

		this.listenTo(app.categories, 'changed', this.setInactive);
	},

	events: {

		'click .title'  : 'changeCurrentCategory',
		'click .remove' : 'deleteCategory',
		'click .edit'	: 'editCategory',
		'click .update'	: 'updateCategory',
		'click .cancel' : 'cancelEdit'
	},

	render: function(){

		this.$el.html();

        var content;

		if( this.editMode === false )
			content = this.templateDefault( this.model.toJSON() );
		else
			content = this.templateEdit( this.model.toJSON() );
			
		this.$el.html(content);
		return this;
	},

	changeCurrentCategory: function(event){

		app.categories.changeCurrentID( this.model.get('id') );
		this.$el.addClass('active');
	},

	deleteCategory: function(event){

		currentView = this;
		this.model.destroy({

			success: function(model, response) {

				currentView.remove();
				app.categories.resetCurrentID();

				alertify.success('Category <i>'+ model.get('title') +'</i> deleted');
			},
			error: function(model, response) {

				alertify.error(response.responseJSON.error);
			}
		});
	},

	editCategory: function(event){

		this.editMode = true;
		this.render();
	},

	updateCategory: function(event){

		var newTitle       = $('#input-title').val();
		var newDescription = $('#input-description').val();

        var errorMessage;

		if( newTitle.length < 1 )
			errorMessage = 'Title may not be empty';

		if( newTitle.length > 50 )
			errorMessage = 'Title may not be longer than 50 characters';
			
		if( errorMessage !== undefined ) {
			alertify.error(errorMessage);
			return; 
		}

		var currentView = this;

		this.model.set({ title:newTitle, description:newDescription });
		this.model.save(null, {

			success: function(model, response){
				currentView.editMode = false;
				currentView.render();
			},
			error: function(model, response){
				alertify.error(response.responseJSON.error);
			}
		});

	},

	cancelEdit: function(event){

		this.editMode = false;
		this.render();
	},

	setInactive: function(){

		this.$el.removeClass('active');
		this.cancelEdit();
	}

});

app.views = app.views || {};
    
app.views.CategoryList = Backbone.View.extend({

    el: '#category-list',
    
    events: {},
    
    initialize: function(){
                        
        this.listenTo(app.categories, 'reset', this.render);
        this.listenTo(app.categories, 'add', this.render);
    },
    
    render: function(){
        
        this.$el.html('');
        app.categories.each(this.addToView, this);

        app.productList.render();

        return this;
    },
    
    addToView: function(category){

        var categoryView = new app.views.CategoryItem({ model:category });
        this.$el.append( categoryView.render().el );
    }

});

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

		alertify.confirm('Confirm that you want to delete the product', this.removeProduct);
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

var app = app || {};

$(document).ready(function(){

	// Alertify settings
	alertify.set('notifier','position', 'top-right');
	alertify.defaults.glossary.title = 'Barmate';

	// Creating views who are already linked to existing DOM elements
	app.categoryList   = new app.views.CategoryList();
	app.categoryForm   = new app.views.CategoryForm();
	app.productList    = new app.views.ProductList();
	app.productDisplay = new app.views.ProductDisplay();
	app.productForm    = new app.views.ProductForm();

	// Seeding products/categories collections with data from the server
	app.categories.reset( categoryData );
	app.products.fetch( {reset:true} );
	
});
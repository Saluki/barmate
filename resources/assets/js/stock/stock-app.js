
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
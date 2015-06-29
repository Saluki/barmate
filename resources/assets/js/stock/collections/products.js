
app.collection = app.collection || {};

app.collection.Products = Backbone.Collection.extend({
	
	model: app.model.Product,

	url: '/app/stock/product',

	currentID: -1

});

app.products   = new app.collection.Products();
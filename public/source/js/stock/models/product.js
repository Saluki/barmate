
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
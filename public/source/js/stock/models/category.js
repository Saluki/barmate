
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
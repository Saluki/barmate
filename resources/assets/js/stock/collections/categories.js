
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

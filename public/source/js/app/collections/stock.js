
var app = app || {};

(function(){
	
	'use strict';
	
	app.Stock = Backbone.Collection.extend({

		model: app.Item
		
	});
    
    app.currentStock = new app.Stock();
	
})();

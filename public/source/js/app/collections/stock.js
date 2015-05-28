
var app = app || {};

(function(){
	
	'use strict';
	
	app.Stock = Backbone.Collection.extend({
        
        url: 'stock.php',
		
		model: app.Item
		
	});
    
    app.currentStock = new app.Stock();
	
})();


var app = app || {};

(function(){
	
	'use strict';
	
	app.Item = Backbone.Model.extend({
		
		defaults: {
            
			'name'     : '',
            'group'    : '',
            'price'    : 0,
            'quantity' : 1
        }
				
	});
	
})();


var app = app || {};

(function(){
    
    'use strict';
    
    app.TicketResume = Backbone.Model.extend({
    
        defaults: {
        
            'items'     : '',
            'price'     : 0,
            'cash'      : 0,
            'timestamp' : 0,
            'free'      : false
        }
        
    });
    
    
})();
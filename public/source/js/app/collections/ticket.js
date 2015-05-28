
var app = app || {};

(function(){
    
    'use strict';

    app.Ticket = Backbone.Collection.extend({
            
        model: app.Item,
        
        getPrice: function() {
            
            var sum = 0;
            this.forEach(function(item){ 
                sum += item.get('quantity') * item.get('price'); 
            });   
            
            return Math.round(sum*100)/100;
        },
        
        clear: function() {
            
            this.reset();
        }
        
    });
    
    app.ticket = new app.Ticket();

})();
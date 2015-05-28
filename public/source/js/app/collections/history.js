
var app = app || {};

(function(){
    
    'use strict';
    
    app.History = Backbone.Collection.extend({
    
        model: app.TicketResume
        
    });
    
})();
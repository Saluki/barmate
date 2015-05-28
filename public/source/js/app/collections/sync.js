
var app = app || {};

(function(){

    app.Sync = Backbone.Collection.extend({
        
        url: 'app/register',
  
        model: app.TicketResume,
        
        save: function() {
            
            if( this.isEmpty() )
                return;
            
            this.sync("create", this, {
            	
            	success: function(object, response) {
            		app.sync.reset();
            		console.log('Sale saved');
            	},
            	
            	error: function(object, response) {
            		console.error('Sale could not be saved');
            	}
            	
            });
        }
        
    });
    
    app.sync = new app.Sync();
    
})();
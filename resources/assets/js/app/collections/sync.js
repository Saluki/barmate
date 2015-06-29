
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
            	},
            	
            	error: function(object, response) {
            		alertify.alert('Could not save sale', 'Sales could not be saved to the server.');
            	}
            	
            });
        }
        
    });
    
    app.sync = new app.Sync();
    
})();

var app = app || {};

(function(){

    app.Sync = Backbone.Collection.extend({
        
        url: 'app/register',
  
        model: app.TicketResume,
        
        save: function() {
            
            if( this.isEmpty() )
                return;
            
            this.sync("create", this, {
            	
            	success: function(object, response, jqxhr) {

            		app.sync.reset();
                    app.sync.trigger('sync');
            	},
            	
            	error: function(jqxhr, textStatus, errorThrown) {

                    var errorMessage = 'Check your network settings or report the problem to the administrator.';

            		alertify.alert('Could not save sale to the server', errorMessage);
                    app.sync.trigger('error');
            	}
            	
            });
        }
        
    });
    
    app.sync = new app.Sync();
    
})();
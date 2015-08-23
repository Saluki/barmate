
var app = app || {};

(function(){

    app.Sync = Backbone.Collection.extend({
        
        url: 'app/register',
  
        model: app.TicketResume,

        inSync: false,
        
        save: function() {
            
            if( this.isEmpty() || this.inSync )
                return;

            this.inSync = true;

            this.sync("create", this, {
            	
            	success: function(object, response, jqxhr) {

            		app.sync.reset();
                    app.sync.trigger('sync');

                    app.sync.inSync = false;
            	},
            	
            	error: function(jqxhr, textStatus, errorThrown) {

                    var errorMessage = 'We could not save the sales to the Barmate server. Please check your network settings or report the problem to an administrator.';

            		alertify.alert('Oups, something went wrong...', errorMessage);
                    app.sync.trigger('error');

                    app.sync.inSync = false;
            	}
            	
            });
        }
        
    });
    
    app.sync = new app.Sync();
    
})();
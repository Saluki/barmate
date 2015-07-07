
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

                    var errorMessage = 'Check your network settings or report the problem to the administrator.';

            		alertify.alert('Could not save sale to the server', errorMessage);
                    app.sync.trigger('error');

                    app.sync.inSync = false;
            	}
            	
            });
        }
        
    });
    
    app.sync = new app.Sync();
    
})();
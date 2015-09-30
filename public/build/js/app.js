
var app = app || {};

(function(){
    
    'use strict';
    
    app.Group = Backbone.Model.extend({
    
        defaults: {
            
            'name':''   
        }
        
    });
    
})();

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

var app = app || {};

(function(){
	
	'use strict';
	
	app.Stock = Backbone.Collection.extend({

		model: app.Item
		
	});
    
    app.currentStock = new app.Stock();
	
})();


var app = app || {};

(function(){
    
    'use strict';
    
    app.History = Backbone.Collection.extend({
    
        model: app.TicketResume
        
    });
    
})();

var app = app || {};

(function(){
    
    'use strict';
    
    app.Groups = Backbone.Collection.extend({
    
        model: app.Group,
        
        initialize: function() {
            
            this.listenTo(app.currentStock, 'reset', this.seed);
        },
  
        seed: function() {
            
            app.currentStock.each(this.addGroup, this);
            
            this.trigger('done');
        },
        
        addGroup: function(item) {
            
            var groupName = item.get('group');
            
            if( this.findWhere({name: groupName}) !== undefined )
                return;
            
            this.add(new app.Group({name: groupName}));
        }
        
    });
    
    app.groups = new app.Groups();
    
})();

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

var app = app || {};

(function($){
        
    'use strict';
    
    app.GroupView = Backbone.View.extend({
    
        el: $('#groups-container'),
        
        events: { 'click .group-item':'changeCurrentGroup' },
        
        currentGroup: '',
        
        initialize: function(){
            
            this.$groups = $('#groups');
            
            this.listenTo(app.groups, 'done', this.render);
        },
        
        render: function(){
            
            app.groups.each(this.addToView, this);
            
            return this;
        },
        
        addToView: function(group){
            
            this.$groups.append('<div class="group-item" data-name="'+group.get('name')+'">'+group.get('name')+'</div>');
        },

        changeCurrentGroup: function(e){
            
            this.$groups.children().css('color', 'rgba(32, 57, 81, 1)');
            $(e.target).css('color', '#0095DD');
            
            var newGroup = $(e.target).data('name');
            
            if( this.currentGroup === newGroup )
                return;
            
            this.currentGroup = newGroup;
            
            app.stockView.render();
        }
    
    });
        
})(jQuery);

var app = app || {};

(function($){
    
    'use strict';
    
    app.PaymentView = Backbone.View.extend({
        
        el: $('#payment-container'),
        
        sum: '',
        
        events: {
            
            'click #send-payment'   : 'pay',
            'click #cancel-payment' : 'close',
            'click .btn-payment'   : 'updateSum'
        },
        
        initialize: function() {
            
            this.$sum = $('#payment-sum');
            this.$rest = $('#payment-rest');
        },
        
        render: function() {
            
            this.$sum.html( this.sum+'€' );
            
            this.$rest.html( this.updateRest()+'€' );
        },
        
        open: function() {
                        
            $('#payment-container').show();
            
            this.sum = '0';
            this.render();
            
            app.ticketView.freeze = true;
        },
        
        close: function() {
            
            $('#payment-container').hide();
                        
            app.ticketView.freeze = false;
        },
        
        updateSum: function(e){
            
            var action = $(e.target).data('action');
            
            if(action == 'R') {
                
                this.cutLast();
                
                if( this.sum.charAt(this.sum.length-1) == '.' )
                    this.cutLast();
                
                if( this.sum.length === 0 )
                    this.sum = '0';
            }
            else if(action == '.') {
               
                if( this.sum.indexOf('.') == -1 ) {
                    this.sum += '.';
                }
            }
            else {
                
                if( this.sum.indexOf('.') != -1 ) {
                    
                    var sumSplit = this.sum.split('.');
                                        
                    if( sumSplit[0].length > 4 || sumSplit[1].length >= 2 )
                        return;
                } 
                else {
                    
                    if( this.sum.length >= 4 )
                        return;
                }
                
                if( this.sum == '0' )
                    this.sum = '';
                
                this.sum += action;
            }
            
            this.render();
        },
        
        updateRest: function(){
            
            var sum = parseFloat(this.sum);
            var rest = sum - app.ticket.getPrice();
            
            return Math.round(rest*100)/100;
        },
        
        cutLast: function(){
            
            this.sum = this.sum.substr(0, this.sum.length-1);
        },
        
        pay: function() {
                        
            var resume = new app.TicketResume({
            
                items     : app.ticket.toJSON(),
                price     : app.ticket.getPrice(),
                cash      : this.sum,
                timestamp : Math.floor(Date.now() / 1000),
                free      : false
            });
            
            app.sync.add(resume);
            app.sync.save();
            
            this.close();
            app.ticketView.clear();
        }
        
    });
        
})(jQuery);

var app = app || {};

(function($){
	
	'use strict';
	
	app.StockView = Backbone.View.extend({
		
		el: '#stock',

        template: _.template( $('#template-stock').html() ),

		events: { 'click .stock-item':'toTicket' },
		
		initialize: function() {

            this.listenTo(app.groups, 'done', this.render);         
        },
		
		render: function() {
            
            this.$el.html('');


            var products = app.currentStock.where({
                'group': app.groupView.currentGroup
            });
            var content = this.template({
               'products': products
            });

            this.$el.html(content);

            return this;
        },
        
        toTicket: function(e) {
            
            var itemID = $(e.target).data('id');
                        
            app.ticketView.add( itemID );
        }
		
	});
    	
})(jQuery);


var app = app || {};

(function($){

    'use strict';
    
    app.TicketView = Backbone.View.extend({
    
        el: $('#ticket-container'),
        
        freeze: false,
        
        events: { 
            
            'click #clear-ticket' : 'clear', 
            'click #pay-ticket'   : 'pay',
            'click #free-ticket'  : 'confirmFree',
            'click .remove-item'  : 'removeItem'     },
        
        initialize: function(){
            
            this.$price = $('#ticket-price');
            this.$list = $('#ticket-body');
            
            this.listenTo(app.ticket, 'all', this.render);
        },
        
        render: function(){
            
            this.$list.html('');
            
            app.ticket.each(this.displayOne, this);
            
            this.$price.html( app.ticket.getPrice()+'€' );
        },
        
        displayOne: function(item){
            
            var html = '<div class="ticket-item">';
            html += '<div class="qt">'+item.get('quantity')+'</div><div class="title">'+item.get('name')+'</div>';
            html += '<div class="close remove-item" data-id="'+item.id+'">&times;</div></div>';
            
            this.$list.append(html);
        },
        
        add: function(itemID) {
            
            if( this.freeze )
                return;
                        
            var itemInTicket = app.ticket.get(itemID);
            
            if( itemInTicket === undefined ) {
                
                var itemToAdd = app.currentStock.get(itemID);
                
                app.ticket.add( itemToAdd.clone() );
                return;
            }
            
            itemInTicket.set({'quantity': itemInTicket.get('quantity')+1});
        },
        
        removeItem: function(e) {
            
            if( this.freeze )
                return;
            
            var productID = $(e.target).data('id');
            
            var productModel = app.ticket.get(productID);
            
            var quantityInTicket = productModel.get('quantity');
            
            if( quantityInTicket > 1 ) {
                productModel.set({quantity: quantityInTicket-1});
            } else {
                app.ticket.remove(productModel);
            }
        },
        
        pay: function() {
            
            if( this.freeze )
                return;
          
            if( app.ticket.length === 0 )
                return;
            
            app.paymentView.open();
        },

        confirmFree: function() {

            if( app.ticketView.freeze )
                return;

            if( app.ticket.length === 0 )
                return;

            alertify.confirm('Do you really want to register a free sale?', this.sendFree);
        },
        
        sendFree: function() {
                        
            var resume = new app.TicketResume({
            
                items     : app.ticket.toJSON(),
                price     : app.ticket.getPrice(),
                cash      : 0,
                timestamp : Math.floor(Date.now() / 1000),
                free      : true
            });
            
            app.sync.add(resume);
            app.sync.save();
                        
            app.ticketView.clear();
        },
        
        clear: function() {
            
            if( this.freeze )
                return;
            
            app.ticket.clear();   
        }
    
    });
    
})(jQuery);

var app = app || {};

(function($){

    'use strict';

    app.SyncView = Backbone.View.extend({

        el: '#sync-status',


        template: _.template( $('#template-sync-box').html() ),

        events: {
            'click #sync-btn' : 'manualSync'
        },

        initialize: function(){

            this.listenTo(app.sync, 'sync', this.render);
            this.listenTo(app.sync, 'error', this.render);

            this.hide();
        },

        render: function() {

            $('#sync-icon').removeClass('fa-spin');

            if( app.sync.length <= 0 )
            {
                this.hide();
                return;
            }

            var templateData = {
                syncNumber: app.sync.length
            };

            var content = this.template(templateData);
            this.$el.html(content);

            this.show();

            return this;
        },

        manualSync: function() {

            app.sync.save();
            $('#sync-icon').addClass('fa-spin');
        },

        hide: function() {

            this.$el.css('display','none');
        },

        show: function() {

            this.$el.css('display', 'block');
        }

    });

})(jQuery);

var app = app || {};

var ENTER_KEY = 13;
var ESC_KEY = 27;

$(function () {

	'use strict';

    // Alertify settings
    alertify.set('notifier','position', 'top-right');
    alertify.defaults.glossary.title = 'Barmate';
	
    // Used for development
    app.startTime = new Date();
    	
    // All Backbone views
    app.groupView = new app.GroupView();
	app.stockView = new app.StockView();
    app.ticketView = new app.TicketView();
    app.paymentView = new app.PaymentView();
    app.syncBox = new app.SyncView();
                
    // Load server data in the stock
    app.currentStock.reset(serverData);

    // Register event handlers
    $(window).bind('beforeunload', function(){

        if( app.sync.length>0 ) {
            return 'Are you sure you want to leave?';
        }
    });
  
});

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
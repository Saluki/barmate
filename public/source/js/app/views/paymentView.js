
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
                
                if( this.sum.length == 0 )
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
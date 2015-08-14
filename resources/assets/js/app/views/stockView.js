
var app = app || {};

(function($){
	
	'use strict';
	
	app.StockView = Backbone.View.extend({
		
		el: $('#stock'),

		events: { 'click .stock-item':'toTicket' },
		
		initialize: function() {
        
            this.$list = $('#stock');
            
            this.listenTo(app.groups, 'done', this.render);         
        },
		
		render: function() {
            
            this.$list.html('');
            
            app.currentStock.each(this.addOne, this);
            
            return this;
        },
        
        addOne: function(item) {

            if (item.get('id') === null || item.get('name') === null || item.get('price') === null) {
                return;
            }
            
            if( item.get('group') === app.groupView.currentGroup ) {

                this.$list.append('<button class="stock-item" data-id=' + item.id + ' >' + item.get('name') + '</button>');
            }
        },
        
        toTicket: function(e) {
            
            var itemID = $(e.target).data('id');
                        
            app.ticketView.add( itemID );
        }
		
	});
    	
})(jQuery);


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

            var products = app.currentStock.filter(function(product){
                return product.id != null && product.get('group') == app.groupView.currentGroup;
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

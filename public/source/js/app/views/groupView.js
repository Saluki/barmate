
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
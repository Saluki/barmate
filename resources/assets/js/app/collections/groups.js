
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
            
            if( this.findWhere({name: groupName}) != undefined )
                return;
            
            this.add(new app.Group({name: groupName}));
        }
        
    });
    
    app.groups = new app.Groups();
    
})();
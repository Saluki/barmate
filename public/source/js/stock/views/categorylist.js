
app.views = app.views || {};
    
app.views.CategoryList = Backbone.View.extend({

    el: '#category-list',
    
    events: {},
    
    initialize: function(){
                        
        this.listenTo(app.categories, 'reset', this.render);
        this.listenTo(app.categories, 'add', this.render);
    },
    
    render: function(){
        
        this.$el.html('');
        app.categories.each(this.addToView, this);
        return this;
    },
    
    addToView: function(category){

        var categoryView = new app.views.CategoryItem({ model:category });
        this.$el.append( categoryView.render().el );
    }

});
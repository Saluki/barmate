
var app = app || {};

(function($){

    'use strict';

    app.SyncView = Backbone.View.extend({

        el: '#sync-status',

        template: _.template( $('#template-sync-box').html() ),

        events: {},

        initialize: function(){

            this.listenTo(app.sync, 'sync', this.render);
            this.listenTo(app.sync, 'error', this.render);

            this.hide();
        },

        render: function() {

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

        hide: function() {

            this.$el.css('display','none');
        },

        show: function() {

            this.$el.css('display', 'block');
        }

    });

})(jQuery);
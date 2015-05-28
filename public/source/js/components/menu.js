
var app = app || {};

(function($){
    
    app.menuComponent = {
                        
        initialize: function(){

            $('#open-menu').click(this.show);
            $('#close-menu').click(this.hide);
        },

        show: function(){

            $('#menu-container').fadeIn(100);

            $('#menu').animate({
                left:"0px"

            }, 300);
        },

        hide: function(){

            $('#menu').animate({
                left:"-300px"

            }, 300, function(){
                $('#menu-container').fadeOut(100);
            });

        }
    }
    
})(jQuery);

$(function(){
    
   // Load the main menu
    app.menuComponent.initialize();
 
});
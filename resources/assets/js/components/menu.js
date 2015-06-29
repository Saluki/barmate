
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

    app.HOME_KEY = 36;
    app.KEY_LEFT = 37;
    app.KEY_RIGHT = 39;
    
   // Load the main menu
    app.menuComponent.initialize();

    // Perhaps better to replace with Hammer.js touch events?
    $(document).keypress(function(event){

        if( event.keyCode == app.KEY_LEFT ) {
            app.menuComponent.hide();
        }
        else if( event.keyCode == app.KEY_RIGHT ) {
            app.menuComponent.show();
        }
        else if( event.keyCode == app.HOME_KEY ) {
            window.location.href = "/";
        }

    });
 
});
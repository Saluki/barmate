
var app = app || {};

var ENTER_KEY = 13;
var ESC_KEY = 27;

$(function () {

	'use strict';

    // Alertify settings
    alertify.set('notifier','position', 'top-right');
    alertify.defaults.glossary.title = 'Barmate';
	
    // Used for development
    app.startTime = new Date();
    	
    // All Backbone views
    app.groupView = new app.GroupView();
	app.stockView = new app.StockView();
    app.ticketView = new app.TicketView();
    app.paymentView = new app.PaymentView();
                
    // Load server data in the stock
    app.currentStock.reset(serverData);
  
});
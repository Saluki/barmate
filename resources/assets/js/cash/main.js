
var app = app || {};

$(function(){

    // Initialize Bootstrap tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // When clicking on older history button
    $('#older-snapshots-btn').click(function(){

        alertify.alert().setting({
            'title': 'Snapshot History',
            'label': 'Cancel',
            'message': $('#snapshot-list').html()
        }).show();

    });

});
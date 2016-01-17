
app.views = app.views || {};

app.views.CategoryForm = Backbone.View.extend({
	
	el: '#new-category-form',

	initialize: function() {

		this.$inputTitle       = $('#c-title');
		this.$inputDescription = $('#c-description');
		this.$saveButton       = $('#btn-save-category');
	},

	events: {

		'click #btn-save-category': 'saveCategory'
	},

	render: function() {

		return this;
	},

	saveCategory: function() {

		var title       = this.$inputTitle.val();
		var description = this.$inputDescription.val();

        var errorMessage;

		if( title.length < 1 )
			errorMessage = 'Title may not be empty';

		if( title.length > 50 )
			errorMessage = 'Title may not be longer than 50 characters';

		if( errorMessage !== undefined ) {
			alertify.error(errorMessage);
			return; 
		}

		var currentView = this;

		var category = new app.model.Category({ title:title, description:description });
		category.save(null, {

			success: function(model, response) {

				app.categories.add( category );
				currentView.clearForm();

				alertify.success('Category <i>'+ model.get('title') +'</i> created');
			},
			error: function(model, response) {

                if( response.responseJSON.error ) {
                    alertify.error(response.responseJSON.error);
                }
                else {
                    alertify.error('Problem on the server');
                }
			}
		});
	},

	clearForm: function() {

		this.$inputTitle.val('');
		this.$inputDescription.val('');
	}

});
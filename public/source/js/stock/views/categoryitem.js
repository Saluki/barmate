
app.views = app.views || {};

app.views.CategoryItem = Backbone.View.extend({

	className: 'category-item',
	
	editMode        : false,
	templateDefault : _.template( $('#template-category').html() ),
	templateEdit    : _.template( $('#template-category-edit').html() ),

	initialize: function(){

		this.listenTo(app.categories, 'changed', this.setInactive);
	},

	events: {

		'click .title'  : 'changeCurrentCategory',
		'click .remove' : 'deleteCategory',
		'click .edit'	: 'editCategory',
		'click .update'	: 'updateCategory',
		'click .cancel' : 'cancelEdit'
	},

	render: function(){

		this.$el.html();

		if( this.editMode == false )
			var content = this.templateDefault( this.model.toJSON() );
		else
			var content = this.templateEdit( this.model.toJSON() );
			
		this.$el.html(content);
		return this;
	},

	changeCurrentCategory: function(event){

		app.categories.changeCurrentID( this.model.get('id') );
		this.$el.addClass('active');
	},

	deleteCategory: function(event){

		currentView = this;
		this.model.destroy({

			success: function(model, response) {

				currentView.remove();
				app.categories.resetCurrentID();

				alertify.success('Category <i>'+ model.get('title') +'</i> deleted');
			},
			error: function(model, response) {

				alertify.error(response.responseJSON.error);
			}
		});
	},

	editCategory: function(event){

		this.editMode = true;
		this.render();
	},

	updateCategory: function(event){

		var newTitle       = $('#input-title').val();
		var newDescription = $('#input-description').val();

		if( newTitle.length < 1 )
			var errorMessage = 'Title may not be empty';

		if( newTitle.length > 50 )
			var errorMessage = 'Title may not be longer than 50 characters';
			
		if( errorMessage != undefined ) {
			alertify.error(errorMessage);
			return; 
		}

		var currentView = this;

		this.model.set({ title:newTitle, description:newDescription });
		this.model.save(null, {

			success: function(model, response){
				currentView.editMode = false;
				currentView.render();
			},
			error: function(model, response){
				alertify.error(response.responseJSON.error);
			}
		});

	},

	cancelEdit: function(event){

		this.editMode = false;
		this.render();
	},

	setInactive: function(){

		this.$el.removeClass('active');
		this.cancelEdit();
	}

});
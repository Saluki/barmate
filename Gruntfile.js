/* 
 * Default Barmate GruntFile
 * -------------------------
 */
module.exports = function(grunt) {
	
	// CONFIGURE TASKS

	grunt.initConfig({

		jsSource:  'public/source/js',
		jsBuild:   'public/build/js',
		cssSource: 'public/source/css',
		cssBuild:  'public/build/css',
		
        concat: {	

		    app: {
		    	src: ['<%= jsSource %>/app/models/group.js',
						'<%= jsSource %>/app/models/item.js',
                        '<%= jsSource %>/app/models/ticketResume.js',
                        '<%= jsSource %>/app/collections/stock.js',
                        '<%= jsSource %>/app/collections/history.js',
                        '<%= jsSource %>/app/collections/groups.js',
                        '<%= jsSource %>/app/collections/sync.js',
                        '<%= jsSource %>/app/collections/ticket.js',
                        '<%= jsSource %>/app/views/groupView.js',
                        '<%= jsSource %>/app/views/paymentView.js',
                        '<%= jsSource %>/app/views/stockView.js',
                        '<%= jsSource %>/app/views/ticketView.js',
                        '<%= jsSource %>/app/components/menu.js',
                        '<%= jsSource %>/app/barmate.js'],
		    	dest: '<%= jsBuild %>/app.js'
		    },

		    stock: {
		    	src: ['<%= jsSource %>/stock/models/*.js', 
		    			'<%= jsSource %>/stock/collections/*.js', 
		    			'<%= jsSource %>/stock/views/*.js', 
		    			'<%= jsSource %>/stock/*.js'],
		    	dest: '<%= jsBuild %>/stock.js'
		    }
		},
        
		uglify: {

		    components: {

		    	src: ['<%= jsSource %>/components/menu.js'],
		    	dest: '<%= jsBuild %>/menu.min.js'
		    },

		    app: {

		    	src: ['<%= jsSource %>/app/barmate.js'],
		    	dest: '<%= jsBuild %>/app.min.js'
		    },

		    stock: {
		    	src: ['<%= jsBuild %>/stock.js'],
		    	dest: '<%= jsBuild %>/stock.min.js'
		    }
		},

		less: {
            
		    base: {
											    
				src: ['<%= cssSource %>/variables.less',
					  '<%= cssSource %>/components.less',
                      '<%= cssSource %>/header.less',
                      '<%= cssSource %>/left-menu.less' ],
				dest: '<%= cssBuild %>/common.css'
			},

			app: {	    
				src: [ '<%= cssSource %>/app.less', '<%= cssSource %>/payment.less' ],
				dest: '<%= cssBuild %>/app.css'
		    },

		    stock: {
		    	src: ['<%= cssSource %>/stock.less'],
		    	dest: '<%= cssBuild %>/stock.css'
		    },

		    cash: {
		    	src: ['<%= cssSource %>/cash.less'],
		    	dest: '<%= cssBuild %>/cash.css'
		    },
		    
		    users:{
		    	src: ['<%= cssSource %>/users.less'],
		    	dest: '<%= cssBuild %>/users.css'
		    }

		},
	
		cssmin: {
		    
		    default: {
			
				files: {
				    
				    'build/css/barmate.min.css': ['build/css/barmate.css']
				}
		    }
		}

	});

    grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

	//grunt.registerTask('all', ['concat','uglify','less','cssmin']);
	//grunt.registerTask('default', ['less']);
};

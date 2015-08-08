
module.exports = function(grunt) {

	grunt.initConfig({

		jsSource:  'resources/assets/js',
		jsBuild:   'public/build/js',

		cssSource: 'resources/assets/less',
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
                        '<%= jsSource %>/app/views/syncView.js',
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
		    },

            cash: {
                src: ['<%= jsSource %>/cash/*.js'],
                dest: '<%= jsBuild %>/cash.js'
            },

            stats: {
                src: ['<%= jsSource %>/stats/*.js'],
                dest: '<%= jsBuild %>/stats.js'
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
		    },

            cash: {
                src: ['<%= jsBuild %>/cash.js'],
                dest: '<%= jsBuild %>/cash.min.js'
            },

            stats: {
                src: ['<%= jsBuild %>/stats.js'],
                dest: '<%= jsBuild %>/stats.min.js'
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
		    },

            maintenance:{
                src: ['<%= cssSource %>/maintenance.less'],
                dest: '<%= cssBuild %>/maintenance.css'
            }

		},
	
		cssmin: {
		    
		    default: {

                src: ['<%= cssBuild %>/barmate.css'],
                dest: '<%= cssBuild %>/barmate.min.css'
		    }
		}

	});

    grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.registerTask('build', ['concat', 'uglify', 'less', 'cssmin']);
};

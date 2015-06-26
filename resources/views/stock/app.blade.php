@extends('layouts.app')

@section('title')

    Stock Management - Barmate POS

@stop

@section('custom-css')

    <link rel="stylesheet" href="{{ asset('build/css/stock.css') }}" />

    <link rel="stylesheet" href="{{ asset('bower_components/alertify-js/build/css/alertify.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('source/css/alertify-theme.css') }}" />

@stop

@section('content')

    <div class="row paper">

    	<div class="paper-header">
    		<h2>
    			<i class="fa fa-cube"></i>&nbsp;&nbsp;
    			Stock Management
    		</h2>
    	</div>

    	<div class="paper-body">

            <div class="col-md-12">
                <h2>Manage stock</h2>
            </div>
    		
    		<div class="col-md-4">
                
                <div id="category-list"></div>

                <div id="new-category-form">

                    <input type="text" id="c-title" placeholder="Category title">
                    <!--<input type="text" id="c-description" placeholder="Description">-->
                    <button class="btn btn-success" id="btn-save-category">Add</button>

                </div>

            </div>

            <div class="col-md-4">

                <div id="product-list"></div>

            </div>

            <div class="col-md-4" id="product-panel">

                <div id="product-display"></div>

                <div id="product-form">

                    <div class="panel panel-default">
                        <div class="panel-body">

                            <label>Name</label>
                            <input type="text" class="form-control" id="p-name">

                            <label>Description</label>
                            <input type="text" class="form-control" id="p-description">

                            <label>Price</label>
                            <input type="text" class="form-control" id="p-price">

                            <label>Quantity</label>
                            <input type="text" class="form-control" id="p-quantity">

                            <br>

                            <button class="btn btn-success pull-right" id="save-product-btn">
                                <span class="fa fa-check"></span>&nbsp;Add Product
                            </button>

                        </div>
                    </div>

                </div>

            </div>

            <div class="col-md-12">&nbsp;</div>

    	</div>

    </div>

@stop

@section('custom-js')
    
    <!-- TEMPLATES -->
    <script type="text/template" id="template-category">

        <div class="category-item">
            <span class="title">
                
                <b><%= title %></b><br>

                <i style="color:grey">
                <% if(description == undefined || description == '') { %>

                   No description

                <% } else if(description.length>25) { %>

                     <%= description.substring(0,25) %>...

                <% } else { %>

                    <%= description %>

                <% } %>
                </i>

            </span>
            <i class="fa fa-trash remove pull-right text-danger" style="padding:5px;margin-top:-10px;cursor:pointer;"></i>
            <i class="fa fa-pencil edit pull-right" style="padding:5px;margin-top:-10px;cursor:pointer;"></i>
        </div>

    </script>

    
    <script type="text/template" id="template-category-edit">

        <div class="category-item">
            <input type="text" id="input-title" value="<%= title %>" class="form-control" placeholder="Title">
            <input type="text" id="input-description" value="<%= description %>" class="form-control" placeholder="Description">
            <button class="btn btn-default cancel">
                <span class="fa fa-times"></span>&nbsp;Cancel
            </button>
            <button class="btn btn-success pull-right update">
                <span class="fa fa-check"></span>&nbsp;Update
            </button>
        </div>

    </script>

    <script type="text/template" id="template-product-list">

        <button class="btn btn-success btn-block" id="add-product-btn">
            <span class="fa fa-plus"></span>&nbsp;&nbsp;Add product
        </button>
        <br>

        <% _.each(products, function(product){ %>

            <div class="product" data-product="<%= product.id %>">
                <%= product.get('name') %>
            </div>

        <% }) %>

    </script>

    <script type="text/template" id="template-product-display">

        <div class="panel panel-default">
            <div class="panel-body">

                <h3 style="margin-top: 5px;"><%= name %></h3>

                <% if( description == undefined || description == '' ){ %>
                    <i style="color:grey;">No description</i>
                <% } else { %>
                    <i><%= description %></i>
                <% } %>

                <br><br>
                <b><%= quantity %></b> items currently in stock
                <br><br>
                <b><%= price %>€</b> per product

                <br><br>
                <button class="btn btn-default" id="edit-product">
                    <span class="fa fa-pencil"></span>&nbsp;Edit
                </button>
                <button class="btn btn-danger pull-right" id="remove-product">
                    <span class="fa fa-trash"></span>&nbsp;Remove
                </button>

            </div>
        </div>

    </script>

    <script type="text/template" id="template-product-edit">

        <div class="panel panel-default">
            <div class="panel-body">

                <label>Name</label>
                <input type="text" id="product-update-name" value="<%= name %>" class="form-control">

                <label>Description</label>
                <input type="text" id="product-update-description" value="<%= description %>" class="form-control">

                <label>Price</label>
                <input type="text" id="product-update-price" value="<%= price %>" class="form-control">

                <label>Quantity</label>
                <input type="text" id="product-update-qt" value="<%= quantity %>" class="form-control">

                <br>

                <button class="btn btn-default" id="cancel-edit">
                    <span class="fa fa-times"></span>&nbsp;Cancel
                </button>
                <button class="btn btn-success pull-right" id="update-product">
                    <span class="fa fa-check"></span>&nbsp;Update
                </button>

            </div>
        </div>

    </script>

    <!-- DEPENDENCIES -->
    <script type="text/javascript" src="{{ asset('bower_components/alertify-js/build/alertify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/underscore/underscore-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/backbone/backbone.js') }}"></script>

    <!-- MODELS, COLLECTIONS AND VIEWS -->
    <script type="text/javascript" src="{{ asset('source/js/stock/models/category.js') }}"></script>
    <script type="text/javascript" src="{{ asset('source/js/stock/models/product.js') }}"></script>

    <script type="text/javascript" src="{{ asset('source/js/stock/collections/categories.js') }}"></script>
    <script type="text/javascript" src="{{ asset('source/js/stock/collections/products.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('source/js/stock/views/categorylist.js') }}"></script>
    <script type="text/javascript" src="{{ asset('source/js/stock/views/categoryitem.js') }}"></script>
    <script type="text/javascript" src="{{ asset('source/js/stock/views/categoryform.js') }}"></script>
    <script type="text/javascript" src="{{ asset('source/js/stock/views/productlist.js') }}"></script>
    <script type="text/javascript" src="{{ asset('source/js/stock/views/productdisplay.js') }}"></script>
    <script type="text/javascript" src="{{ asset('source/js/stock/views/productform.js') }}"></script>


    <script type="text/javascript">

        var categoryData = {!! json_encode($categories) !!};

    </script>

    <!-- STOCK APP -->
    <script type="text/javascript" src="{{ asset('source/js/stock/stock-app.js') }}"></script>

    <!-- STOCK BUILD -->
    <!--<script type="text/javascript" src="{{ asset('build/js/stock.js') }}"></script>-->

@stop
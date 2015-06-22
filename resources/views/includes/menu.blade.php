<!-- MENU CONTAINER -->
    
<div id="menu-container">

    <div id="menu">

        <div id="header">

            <div id="title">
                Menu
            </div>

            <div id="close-menu">&times;</div>

        </div>

        <div id="user-display"></div>

        <a href="{{ url('app') }}" class="entry">
            <div class="icon"><i class="fa fa-desktop"></i></div>
            <div class="text">Bar App</div>
        </a>

        @if ( Session::get('role') == 'ADMN' || Session::get('role') == 'MNGR' )

            <a href="{{ url('app/stock') }}" class="entry">
                <div class="icon"><i class="fa fa-cube"></i></div>
                <div class="text">Stock</div>
            </a>
            <a href="{{ url('app/cash') }}" class="entry">
                <div class="icon"><i class="fa fa-bank"></i></div>
                <div class="text">Cash</div>
            </a>
            <a href="{{ url('app/stats') }}" class="entry">
                <div class="icon"><i class="fa fa-bar-chart-o"></i></div>
                <div class="text">Statistics</div>
            </a>

        @endif

        @if ( Session::get('role') == 'ADMN' )

            <a href="{{ url('app/users') }}" class="entry">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="text">Users</div>
            </a>
            <a href="{{ url('app/settings') }}" class="entry">
                <div class="icon"><i class="fa fa-wrench"></i></div>
                <div class="text">Settings</div>
            </a>

        @endif

    </div>

</div>
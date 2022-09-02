<!-- Left Sidebar Menu -->
<div class="fixed-sidebar-left">
    <ul class="nav navbar-nav side-nav nicescroll-bar">
        <li class="navigation-header">
            <span>Main</span>
            <i class="zmdi zmdi-more"></i>
        </li>
        <li>
            <a href="{{route('home-page')}}" @if(request()->routeIs('home-page'))class="active"@endif>
                <div class="pull-left">
                    <i class="fa fa-home mr-20"></i>
                    <span class="right-nav-text">home page</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <li>
            <a href="{{route('profile', 0)}}" @if(request()->routeIs('profile', 'profileOnlyParser'))class="active"@endif>
                <div class="pull-left">
                    <i class="fa fa-user mr-20"></i>
                    <span class="right-nav-text">profile</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <li><hr class="light-grey-hr mb-10"/></li>
    </ul>
</div>
<!-- /Left Sidebar Menu -->

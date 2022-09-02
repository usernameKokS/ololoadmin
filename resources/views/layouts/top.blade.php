<!-- Top Menu Items -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="mobile-only-brand pull-left">
        <div class="nav-header pull-left">
            <div class="logo-wrap">
                <a href="/">
                    <img class="brand-img" src="{{asset('assets/logo.png')}}" width="20" alt="brand"/>
                    <span class="brand-text">AlmejaRosa</span>
                </a>
            </div>
        </div>
        <a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);">
            <i class="zmdi zmdi-search"></i>
        </a>
        <a id="toggle_mobile_nav" class="mobile-only-view" href="/filter">
            <i class="fa fa-filter"></i>
        </a>
        <form id="search_form" role="search" class="top-nav-search collapse pull-left" method="post" action="{{route('search')}}">
            @csrf
            <div class="input-group">
                <input type="text" name="telephone" class="form-control" placeholder="Búsqueda por teléfono">
                <span class="input-group-btn">
                    <button type="button" class="btn  btn-default" data-target="#search_form" data-toggle="collapse" aria-label="Close" aria-expanded="true">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </span>
            </div>
        </form>

        <a href="{{route('filter-page')}}" style="margin-left: 20px;margin-top: 20px !important;display: inline-block;font-size: 16px;color: #999999;" class="hidden-xs">
            Filtro
        </a>

        <a href="{{route('to-verify-page')}}" style="margin-left: 20px;margin-top: 20px !important;display: inline-block;font-size: 16px;color: #999999;" class="hidden-xs">
            Модерация 
            <span class="label pull-right label-danger">
                {{\App\Tariff::whereNotNull('to_verify_at')->count()}}
            </span>
        </a>
    </div>
</nav>
<!-- /Top Menu Items -->

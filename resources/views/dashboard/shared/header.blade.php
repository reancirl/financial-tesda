
      
    <div class="c-wrapper">
      <header class="c-header c-header-light c-header-fixed c-header-with-subheader">        
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button><a class="c-header-brand d-sm-none" href="#"><img class="c-header-brand" src="{{ url('/assets/brand/coreui-base.svg') }}" width="97" height="46" alt="CoreUI Logo"></a>               

        @hasanyrole('admin|finance_officer|supply_officer') 
          <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button>
        @endhasanyrole
        <?php
            use App\MenuBuilder\FreelyPositionedMenus;
            if(isset($appMenus['top menu'])){
                FreelyPositionedMenus::render( $appMenus['top menu'] , 'c-header-', 'd-md-down-none');
            }
        ?>  
        <ul class="c-header-nav ml-auto mr-4"> 
          @if(auth()->user()->hasRole('user'))
          <li class="c-header-nav-item d-md-down-none mr-3">
            <a class="c-header-nav-link" href="{{ route('cart.edit',auth()->user()->id) }}">
              <i class="cil-cart" style="font-size:1.3rem"></i>
              <span class="badge badge-primary" id="cart-number">
                {{ \App\Models\Cart::withCount('items')->active(auth()->user()->id)->first()->items_count ?? 0 }}
              </span>
            </a>
          </li>
          @endif
          <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              {{ auth()->user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
              <div class="dropdown-header bg-light py-2"><strong>System</strong></div><a class="dropdown-item" href="{{ route('request.index') }}">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ url('/icons/sprites/free.svg#cil-bell') }}"></use>
                </svg> Request</a>
              <a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ url('/icons/sprites/free.svg#cil-user') }}"></use>
                </svg> Profile</a>
              <div class="dropdown-divider"></div>
                <form action="{{ url('/logout') }}" method="POST"> @csrf 
                  <button type="submit" class="btn-block dropdown-item">
                    <svg class="c-icon mr-2">
                      <use xlink:href="{{ url('/icons/sprites/free.svg#cil-account-logout') }}"></use>
                    </svg>Logout
                  </button>
                </form>
            </div>
          </li>
        </ul>
    </header>
<div class="c-sidebar-brand" style="background-color:#FFFFFF;border: 3px solid #224d9e">
    <div class="c-sidebar-brand-full">
        <img src="{{ url('/assets/img/tesda-dark.ico') }}" width="50" height="46" alt="Tesda Logo">
        <span style="font-size:1.3rem;font-weight:900;color:#224d9e;" class="ml-2">TESDA</span>
    </div>
    <img class="c-sidebar-brand-minimized" src="{{ url('/assets/img/tesda-light.png') }}" width="50" height="46"
        alt="Tesda Logo">
</div>
<ul class="c-sidebar-nav">

    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('dashboard.index') }}">
            <i class="cil-speedometer c-sidebar-nav-icon"></i>
            Dashboard
        </a>
    </li>

    @if (!auth()->user()->hasRole('supply_officer'))
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('supply.index') }}">
                <i class="cil-list c-sidebar-nav-icon"></i>
                Supply
            </a>
        </li>

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('qualification.index') }}">
                <i class="cil-book c-sidebar-nav-icon"></i>
                Qualification
            </a>
        </li>
    @endif

    @if (!auth()->user()->hasRole('finance_officer'))
        {{-- <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('suppliers.index') }}">
                <i class="cil-bookmark c-sidebar-nav-icon"></i>
                Suppliers
            </a>
        </li> --}}

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('request.index') }}">
                <i class="cil-paper-plane c-sidebar-nav-icon"></i>
                Request
            </a>
        </li>
    @endif

    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('purchase-request.index') }}">
            <i class="cil-money c-sidebar-nav-icon"></i>
            Purchase Request
        </a>
    </li>

    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('purchase-request.award_index') }}">
            <i class="cil-info c-sidebar-nav-icon"></i>
            Award
        </a>
    </li>

    {{-- <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('bidding.index') }}">
            <i class="cil-fax c-sidebar-nav-icon"></i>
            Bidding
        </a>
    </li> --}}

    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('purchase-order.index') }}">
            <i class="cil-cart c-sidebar-nav-icon"></i>
            Purchase Order
        </a>
    </li>

    @if (!auth()->user()->hasRole('supply_officer'))
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('dashboard.pmr') }}">
                <i class="cil-check c-sidebar-nav-icon"></i>
                PMR
            </a>
        </li>
    @endif

    @hasanyrole('admin')
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/dashboard?shop=true') }}">
            <i class="cil-gift c-sidebar-nav-icon"></i>
            Shop
        </a>
    </li>
    @endrole

    @if (!auth()->user()->hasRole('supply_officer'))
        {{-- <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('reports.index') }}">
                <i class="cil-paperclip c-sidebar-nav-icon"></i>
                Reports
            </a>
        </li> --}}
    @endif

    <li class="c-sidebar-nav-title">@lang('System')</li>

    @role('admin')
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('users.index') }}">
            <i class="cil-user c-sidebar-nav-icon"></i>
            Users
        </a>
    </li>
    @endrole

    <li class="c-sidebar-nav-item">
        <form action="{{ url('/logout') }}" method="POST"> @csrf
            <span class="c-sidebar-nav-link logout-link" style="cursor:pointer">
                <i class="cil-account-logout c-sidebar-nav-icon"></i>
                Logout
            </span>
        </form>
    </li>



</ul>
<button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
    data-class="c-sidebar-minimized"></button>
</div>

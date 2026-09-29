<?php 
if(auth()->user())
{
$roleid = auth()->user()->role_id;
}else{

$roleid = Auth::guard('web_employees')->user()->role_id;
}
?>
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu"></span></li>
                 <li class="nav-item">
                    <a class="nav-link menu-link @if (request()->routeIs('home')) {{ 'active' }} @endif"
                        href="{{ route('home') }}">
                        <i class="mdi mdi-speedometer"></i>
                        <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                @if($roleid == '1' && $roleid != '2')
                    <li class="nav-item">
                        <a href="{{ route('admin.blog.index') }}" class="nav-link {{ request()->is('admin/blog*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-blog"></i>
                            <span>Blog</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.visamaster.index') }}" class="nav-link {{ request()->is('admin/visamaster*') ? 'active' : '' }}">
                            <i class="fas fa-stethoscope"></i>
                            <span>Visa Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.countrymaster.index') }}" class="nav-link {{ request()->is('admin/countrymaster*') ? 'active' : '' }}">
                            <i class="fas fa-globe"></i>
                            <span>Country Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('faqs.index') }}">
                        <i class="fas fa-question-circle"></i> <span>FAQs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.testimonials.index') }}">
                        <i class="fas fa-comments"></i>
                        <span>Testimonials</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="brand">
        <a href="/"><img src="{{asset('assets/img/logo-dark.png')}}" alt="Klorofil Logo" class="img-responsive logo"></a>
    </div>
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
        </div>
        <div id="navbar-menu">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                        <i class="lnr lnr-alarm"></i>
                        <span class="badge bg-danger">5</span>
                    </a>
                    <ul class="dropdown-menu notifications">
                        <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
                        <li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
                        <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
                        <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
                        <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
                        <li><a href="#" class="more">See all notifications</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('assets/img/apple-icon.png')}}" class="img-circle" alt="Avatar"> <span>{{ Auth::guard('admin')->user()->username}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                    <ul class="dropdown-menu"> 
                        <li>
                            <a href="{{ url('admin/changepassword') }}"><i class="lnr lnr-cog"></i> <span>Change Password</span></a>
                        </li>                        
                        <!-- Logout Button -->
                        <li>
                            <a class="dropdown-item" href="{{ url('/admin/logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="lnr lnr-exit"></i> <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ url('/admin/logout') }}" method="GET" style="display: block;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
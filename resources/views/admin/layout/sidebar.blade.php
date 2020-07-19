<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li><a href="{{ url('/admin/home') }}" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
                <li>
                    <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPages" class="collapse ">
                        <ul class="nav">
                            <li><a href="{{route('about.index')}}" class="">About</a></li>
                            <li><a href="{{route('brand.index')}}" class="">Brand</a></li>
                            <li><a href="{{route('category.index')}}" class="">Category</a></li>
                            <li><a href="{{route('comment.index')}}" class="">Comment</a></li>
                            <li><a href="{{route('order.index')}}" class="">Order</a></li>
                            <li><a href="{{route('orderdetail.index')}}" class="">Order Detail</a></li>
                            <li><a href="{{route('product.index')}}" class="">Product</a></li>
                            <li><a href="{{route('productdetail.index')}}" class="">Product Detail</a></li>
                            <li><a href="{{route('user.index')}}" class="">User</a></li>
                            <li><a href="{{route('role.index')}}" class="">Role</a></li>
                            <li><a href="{{route('store.index')}}" class="">Store</a></li>
                            <li><a href="{{route('slide.index')}}" class="">Slide</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="charts.html" class=""><i class="lnr lnr-chart-bars"></i> <span>Charts</span></a></li> 
                <li><a href="notifications.html" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li> 
            </ul>
        </nav>
    </div>
</div>
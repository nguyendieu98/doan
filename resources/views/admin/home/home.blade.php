<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Home</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/chartist/css/chartist-custom.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/img/favicon.png')}}">
</head>
<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <!-- HEADER -->
        @include('admin.layout.header')
        <!-- END HEADER -->
        <!-- LEFT SIDEBAR -->
        @include('admin.layout.sidebar')
        <!-- END LEFT SIDEBAR -->
        <!-- MAIN -->
        <div class="main">
            <!-- MAIN CONTENT -->
            <div class="main-content">
                <div class="container-fluid">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Generality</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="metric">
                                        <a href="{{route('product.index')}}">
                                        <span class="icon"><i class="fa fa-product-hunt"></i></i></span>
                                        <p>
                                            <span class="number">{{$product}}</span>
                                            <span class="title">Product</span>
                                        </p>
                                    </a>    
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <a href="{{ url('/admin/product_sale')}}">
                                        <span class="icon"><i class="fa fa-universal-access"></i></span>
                                        <p>
                                            <span class="number">{{$productsale}}</span>
                                            <span class="title">Sales</span>
                                        </p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <a href="{{route('category.index')}}">
                                        <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                                        <p>
                                            <span class="number">{{$category}}</span>
                                            <span class="title">Category</span>
                                        </p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <a href="{{route('brand.index')}}">
                                        <span class="icon"><i class="fa fa-barcode"></i></span>
                                        <p>
                                            <span class="number">{{$brand}}</span>
                                            <span class="title">Brand</span>
                                        </p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <a href="{{route('order.index')}}">
                                        <span class="icon"><i class="fa fa-bar-chart"></i></span>
                                        <p>
                                            <span class="number">{{$order}}</span>
                                            <span class="title">Order</span>
                                        </p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <a href="{{route('user.index')}}">
                                        <span class="icon"><i class="fa fa-user"></i></span>
                                        <p>
                                            <span class="number">{{$user}}</span>
                                            <span class="title">User</span>
                                        </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END OVERVIEW -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- RECENT PURCHASES -->
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Recent Purchases</h3>
                                    <div class="right">
                                        <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                                        <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                                    </div>
                                </div>
                                <div class="panel-body no-padding " style="overflow: scroll;height: 200px;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order No.</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Date &amp; Time</th>
                                                <th>Status</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @foreach($order_take as $key => $ot)
                                            <tr>
                                                <td><a style="padding-left: 20px" href="#">{{++$key}}</a></td>
                                                <td>{{$ot->user->first_name}} {{$ot->user->last_name}} </td>
                                                <td>{{ number_format($ot->total_amount)}}đ</td>
                                                <td>{{$ot->created_at}}</td>
                                                <td><span class="label label-success">{{$ot->status}}</span></td>
                                                <td><a href="{{route('order.edit',$ot->id)}}" class="ml-1 btn" style="width:40px; padding: 5px;background: #f0f0f0;"><i class="fa fa-edit "></i></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-md-6"><span class="panel-note"></span></div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- END RECENT PURCHASES -->
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN -->
    @include('admin.layout.footer')
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
<script src="{{asset('assets/vendor/chartist/js/chartist.min.js')}}"></script>
<script src="{{asset('assets/scripts/klorofil-common.js')}}"></script>
</body>
</html>

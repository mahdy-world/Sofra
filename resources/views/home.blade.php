@extends('layouts.app')
@inject('client', 'App\Models\Client')
@inject('city', 'App\Models\city')
@inject('restaurant', 'App\Models\Restaurant')
@inject('block', 'App\Models\Block')
@inject('category', 'App\Models\Category')
@inject('order', 'App\Models\Order')
@inject('offer', 'App\Models\Offer')
@inject('contact', 'App\Models\Contact')
@inject('user', 'App\User')
@section('content')
    <div class="container">
        <div class="card-header"><b>الصفحه الرئيسيه</b></div>
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card">

                    <br>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"><b>العملاء</b></span>
                                    <span class="info-box-number">{{($client->count())}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-gray"><i class="ion ion-ios-home"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"><b>المدن</b></span>
                                    <span class="info-box-number">{{($city->count())}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-cutlery"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"><b>المطاعم</b></span>
                                    <span class="info-box-number">{{($restaurant->count())}}</span>
                                </div>

                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="ion ion-ios-filing"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"><b>التصنيفات</b></span>
                                    <span class="info-box-number">{{($category->count())}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-building-o"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"><b>الاحياء</b></span>
                                    <span class="info-box-number">{{($block->count())}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-list-ol"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"><b>العروض</b></span>
                                    <span class="info-box-number">{{($offer->count())}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="ion ion-ios-chatboxes"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text"><b>الرسائل</b></span>
                                        <span class="info-box-number">{{($contact->count())}}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text"><b>الطلبات المكتمله</b></span>
                                        <span class="info-box-number">
                                           {{$order->where('status', 'delivered')->count()}}
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="ion ion-ios-people"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text"><b>المستخدمين</b></span>
                                        <span class="info-box-number">
                                           {{$user->count()}}
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

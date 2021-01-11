@extends('layouts.app')
@inject('restaurant', 'App\models\Restaurant')
@section('page_title')
    الطلبات
@endsection
@section('small_title')
    قائمه الطلبات
@endsection
@section('content')




    <!-- Main content -->
    <section class="content">
    @include('flash::message')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div class="row">
                    {!! Form::open([
                        'method' => 'GET'
                    ]) !!}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            {!! Form::text('order_id',request()->input('order_id'),[
                                'class' => 'form-control',
                                'placeholder' => 'رقم الطلب'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            {!! Form::select('restaurant_id',$restaurant->get()->pluck('name','id')->toArray(),request()->input('restaurant_id'),[
                                'class' => 'form-control',
                                'placeholder' => 'كل المطاعم'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            {!! Form::select('status',
                                [
                                    'pending' => 'قيد التنفيذ',
                                    'accepted' => 'تم تأكيد الطلب',
                                    'rejected' => 'مرفوض',
                                ],\Request::input('status'),[
                                    'class' => 'form-control',
                                    'placeholder' => 'كل حالات الطلبات'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for=""></label>
                            {!! Form::text('from',request()->input('from'),[
                                'class' => 'form-control datepicker',
                                'placeholder' => 'من'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for=""></label>
                            {!! Form::text('to',\Request::input('to'),[
                                'class' => 'form-control datepicker',
                                'placeholder' => 'إلى'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-flat btn-block btn-primary">بحث</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            <div class="box-body">
                @if(count([$records]))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الطلب</th>
                                <th>المطعم</th>
                                <th>الاجمالي</th>
                                <th>ملاحظات</th>
                                <th>الحاله</th>
                                <th>وقت الطلب</th>
                                <th> عرض الطلب</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                       @foreach($record->items as $item)
                                            <a href="{{url(route('orders.show', $record->id))}}">#{{$item->pivot->order_id}}</a>
                                        @endforeach
                                    </td>
                                    <td>{{$record->restaurant->name}}</td>
                                    <td>{{$record->total}}</td>
                                    <td>
                                        @foreach($record->items as $item)
                                            {{$item->pivot->note}}
                                        @endforeach
                                    </td>
                                    <td>
                                       @if($record->status == 'rejected' )
                                           <i class="btn btn-danger btn-block">تم رفض الطلب</i>
                                       @endif
                                        @if($record->status == 'pending')
                                                <i class="btn btn-warning btn-block">قيد التنفيذ</i>
                                        @endif
                                        @if($record->status == 'accepted')
                                               <i class="btn btn-success btn-block">تم تأكيد الطلب</i>
                                        @endif
                                    </td>
                                    <td>{{$record->created_at}}</td>
                                    <td>
                                        <a href="{{url(route('orders.show', $record->id))}}" class="btn btn-info btn-block">عرض الطلب</a>
                                    </td>
                                    <td class="text-center">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        No Data
                    </div>
                @endif
            </div>
        </div>
        <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->

@endsection



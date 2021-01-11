@extends('layouts.app')
@inject('restaurant','App\Models\Restaurant')
@inject('payment','App\Models\Payment')
@section('page_title')
    تعديل العمليات المالية
@endsection
@section('content')



    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">تعديل العمليات المالية</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => ['PaymentController@update',$model->id],
                    'method' => 'put'
                ]) !!}
                <div class="form-group">
                    <label for="name">المطعم</label>
                    {!! Form::select('restaurant_id',$restaurant->pluck('name','id'),null,[
                    'class'=>'form-control']) !!}
                    <label for="name"></label>
                    {!! Form::text('amount',null,[
                        'class' =>'form-control','placeholder'=>'المبلغ'
                    ]) !!}
                    <label for="name"></label>
                    {!! Form::text('note',null,[
                        'class' =>'form-control','placeholder'=>'بيان العمليه'
                    ]) !!}
                </div>
                @include('handler.errors')
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">موافق</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection

@extends('layouts.app')
@inject('model','App\Models\Restaurant')
@section('page_title')
    العمليات المالية
@endsection
@section('content')

    <section class="content">
        @include('flash::message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">اضافه عمليه ماليه</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => 'PaymentController@store'
                ]) !!}
                @include('pays.form')
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection

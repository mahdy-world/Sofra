@extends('layouts.app')
@inject('payment','App\Models\PaymentMethod')
@section('page_title')
    تعديل طريقه الدفع
@endsection
@section('content')



    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">تعديل طريقه الدفع</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => ['PaymentMethodController@update',$model->id],
                    'method' => 'put'
                ]) !!}
                <div class="form-group">
                    @include('payments.form')
                </div>
                @include('handler.errors')
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection

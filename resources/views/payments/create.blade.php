@extends('layouts.app')
@inject('model','App\Models\PaymentMethod')
@section('page_title')
    انشاء طريقه الدفع
@endsection
@section('content')

    <section class="content">
        @include('flash::message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">انشاء طريقه الدفع</h3>
            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => 'PaymentMethodController@store'
                ]) !!}
                @include('payments.form')
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection

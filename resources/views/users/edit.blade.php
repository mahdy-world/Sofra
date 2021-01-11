@extends('layouts.app')

@section('page_title')
    تعديل مستخدم
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">تعديل مستخدم</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => ['UserController@update',$model->id],
                    'method' => 'put'
                ]) !!}
            @include('user.form')
            </div>
        </div>
        <!-- /.box -->
        @include('flash::message')
    </section>
    <!-- /.content -->

@endsection

@extends('layouts.app')

@section('page_title')
   اضافه مستخدم
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">اضافه مستخدم</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => 'UserController@store'
                ]) !!}
                @include('user.form')
            </div>
        </div>
        <!-- /.box -->
        @include('flash::message')
    </section>
    <!-- /.content -->

@endsection

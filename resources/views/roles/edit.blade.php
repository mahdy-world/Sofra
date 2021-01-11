@extends('layouts.app')
@section('page_title')
    تعديل رتبه
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
    @include('flash::message')
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">تعديل رتبه</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => ['RoleController@update',$model->id],
                    'method' => 'put'
                ]) !!}
            @include('roles.form')
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection

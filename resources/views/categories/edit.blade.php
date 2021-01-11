@extends('layouts.app')
@inject('category','App\Models\Category')
@section('page_title')
    تعديل تصنيف
@endsection
@section('content')



    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">تعديل تصنيف</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => ['CategoryController@update',$model->id],
                    'method' => 'put'
                ]) !!}
                <div class="form-group">
                    @include('categories.form')
                </div>
                @include('handler.errors')
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection

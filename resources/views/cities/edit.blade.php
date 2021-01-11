@extends('layouts.app')
@inject('city','App\Models\City')
@section('page_title')
    تعديل المدينه
@endsection
@section('content')



    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">تعديل المدينه</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => ['CityController@update',$model->id],
                    'method' => 'put'
                ]) !!}
                <div class="form-group">
                    @include('cities.form')
                </div>
                @include('handler.errors')
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection

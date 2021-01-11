@extends('layouts.app')
@inject('model','App\Models\City')
@section('page_title')
    انشاء مدينه
@endsection
@section('content')

    <section class="content">
        @include('flash::message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">انشاء تصنيف</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => 'CategoryController@store'
                ]) !!}
                @include('categories.form')
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection

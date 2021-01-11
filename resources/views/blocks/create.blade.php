@extends('layouts.app')
@inject('model','App\Models\City')
@section('page_title')
    انشاء الحي
@endsection
@section('content')

    <section class="content">
        @include('flash::message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">انشاء الحي</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => 'BlockController@store'
                ]) !!}
                @include('blocks.form')
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection

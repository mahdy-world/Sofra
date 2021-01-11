@extends('layouts.app')
@inject('city','App\Models\City')
@inject('block','App\Models\Block')
@section('page_title')
    تعديل الحي
@endsection
@section('content')



    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">تعديل الحي</h3>

            </div>
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => ['BlockController@update',$model->id],
                    'method' => 'put'
                ]) !!}
                <div class="form-group">
                    <label for="name">الاحياء</label>
                    {!! Form::text('name',null,[
                        'class' =>'form-control'
                    ]) !!}
                    <label for="name">المحافظه</label>
                    {!! Form::select('city_id',$city->pluck('name','id'),null,[
                    'class'=>'form-control','placeholder'=>'اختار محافظتك']) !!}
                </div>
                @include('handler.errors')
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">موافق</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection

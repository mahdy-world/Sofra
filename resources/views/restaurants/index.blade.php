@extends('layouts.app')
@inject('city', 'App\models\City')
@php
    $cities = $city->pluck('name', 'id')->toArray();
@endphp

@section('page_title')
    المطاعم
@endsection
@section('small_title')
    قائمه من المطاعم
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
    @include('flash::message')
    <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <div class="restaurant-filter">
                    {!! Form::open([
                    'method' => 'get'
                    ]) !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::text('name',request()->input('name'),[
                                'placeholder' => 'اسم المطعم',
                                'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::select('city_id',$cities,request()->input('city_id'),[
                                'class' => 'select2 form-control',
                                'placeholder' => 'المدينة'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            {{-- 'soon' => 'قريبا', --}}
                            <div class="form-group">
                                {!! Form::select('is_active',[1 => 'مفتوح', 0 => 'مغلق'],request()->input('is_active'),[
                                'class' => 'select2 form-control',
                                'placeholder' => 'حالة المطعم'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit"><i
                                        class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box-body">
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المطعم </th>
                                <th> المدينه</th>
                                <th> العمولات المستحقه </th>
                                <th> حاله المطعم </th>
                                <th> تفعيل / ايقاف </th>
                                <th class="text-center">خذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                             <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$record->name}}</td>
                                 <td>
                                     {{$record->block->name}}
                                     {{$record->block->city->name}}
                                 </td>
                                 <td class="text-center">
                                     {{$record->total_commission - $record->total_payments}}
                                 </td>
                                 @if($record->is_active == 1)
                                     <td class="text-center">
                                         مفتوح
                                     </td>
                                     <td class="text-center">
                                         <a href="active/{{$record->id}}">
                                             <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> نشط</button>
                                         </a>
                                     </td>
                                 @else
                                     <td class="text-center">
                                         مغلق
                                     </td>
                                     <td class="text-center">
                                         <a href="disactive/{{$record->id}}">
                                             <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-edit"></i>غير نشط</button>
                                         </a>
                                     </td>
                                 @endif
                                <td class="text-center">
                                    {!! Form::open([
                                        'action' => ['RestaurantController@destroy',$record->id],
                                        'method' => 'delete'
                                    ]) !!}
                                    <button type="submit" class="delete_link btn btn-danger btn-xs">
                                        <i class="fa fa-trash-o">

                                        </i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        No Data
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection



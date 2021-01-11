@extends('layouts.app')
@section('page_title')
    العمليات الماليه
@endsection
@section('small_title')
    عرض العمليات
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
    @include('flash::message')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <a href="{{url(route('pays.create'))}}" class="btn btn-primary">
                    <i class="fa fa-plus "></i>  اضافه عمليه ماليه</a>
                @if(count([$records]))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المطعم </th>
                                <th> المبلغ</th>
                                <th> بيان العمليه </th>
                                <th class="text-center">تعديل</th>
                                <th class="text-center">خذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$record->restaurant->name}}</td>
                                    <td>{{$record->amount}}</td>
                                    <td>{{$record->note}}</td>
                                    <td class="text-center">
                                        <a href="{{url(route('pays.edit', $record->id))}}" class=" btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open([
                                            'action' => ['PaymentController@destroy',$record->id],
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

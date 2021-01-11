@extends('layouts.app')
@section('page_title')
    الاحياء
@endsection
@section('small_title')
    قائمه من الاحياء
@endsection
@section('content')


    <!-- Main content -->
    <section class="content">
    @include('flash::message')
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">قائمه من الاحياء</h3>

            </div>
            <div class="box-body">
                <a href="{{url(route('blocks.create'))}}" class="btn btn-primary">
                    <i class="fa fa-plus "></i>  اضافه حي جديد</a>
                @if(count([$records]))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>المدن</th>
                                <th>الاحياء</th>
                                <th class="text-center">تعديل</th>
                                <th class="text-center">خذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$record->city->name}}</td>
                                    <td>{{$record->name}}</td>
                                    <td class="text-center">
                                        <a href="{{url(route('blocks.edit', $record->id))}}" class=" btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open([
                                            'action' => ['BlockController@destroy',$record->id],
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
        <!-- /.box -->
    </section>
    <!-- /.content -->

@endsection


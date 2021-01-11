@extends('layouts.app')
@section('page_title')
    التصنيفات
@endsection
@section('small_title')
    قائمه من التصنيفات
@endsection
@section('content')


    <!-- Main content -->
    <section class="content">
    @include('flash::message')
    <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">قائمه من التصنيفات</h3>

            </div>
            <div class="box-body">
                <a href="{{url(route('categories.create'))}}" class="btn btn-primary">
                    <i class="fa fa-plus "></i>  اضافه مدن التصنيفات</a>
                @if(count([$records]))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>التصنيفات</th>
                                <th class="text-center">تعديل</th>
                                <th class="text-center">خذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$record->name}}</td>
                                    <td class="text-center">
                                        <a href="{{url(route('categories.edit', $record->id))}}" class=" btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open([
                                            'action' => ['CategoryController@destroy',$record->id],
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


@extends('layouts.app')

@section('page_title')
    العملاء
@endsection
@section('small_title')
    قائمه العملاء
@endsection
@section('content')




    <!-- Main content -->
    <section class="content">
    @include('flash::message')
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">قائمه العملاء</h3>

            </div>
            <div class="box-body">
                @if(count([$records]))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم العميل</th>
                                <th>رقم الهاتف</th>
                                <th>البريد الالكتروني</th>
                                <th>المدينه</th>
                                <th class="text-center">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$record->name}}</td>
                                    <td>{{$record->phone}}</td>
                                    <td>{{$record->email}}</td>
                                    <td>
                                        {{$record->block->name}}
                                        {{$record->block->city->name}}
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open([
                                            'action' => ['ClientController@destroy',$record->id],
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

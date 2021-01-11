@extends('layouts.app')

@section('page_title')
    العروض
@endsection
@section('small_title')
    قائمه العروض
@endsection
@section('content')




    <!-- Main content -->
    <section class="content">
    @include('flash::message')
    <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">قائمه العروض</h3>

            </div>
            <div class="box-body">
                @if(count([$records]))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم العرض</th>
                                <th>المطعم</th>
                                <th>الصوره</th>
                                <th>بدايه العرض</th>
                                <th>نهايه العرض</th>
                                <th>متاح/غيرمتاح</th>
                                <th class="text-center">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$record->name}}</td>
                                    <td>{{$record->restaurant->name}}</td>
                                    <td>
                                        <a href="{{($record->image)}}" data-lightbox="1" data-title="">
                                            <img src="{{($record->image)}}" alt="" style="height: 60px;">
                                        </a>
                                    </td>
                                    <td>{{$record->from}}</td>
                                    <td>{{$record->to}}</td>
                                        <td class="text-center"><i class="fa fa-2x fa-close text-red"></i></td>
                                    <td class="text-center">
                                        {!! Form::open([
                                            'action' => ['OfferController@destroy',$record->id],
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



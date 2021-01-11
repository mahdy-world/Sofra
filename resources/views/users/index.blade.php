@extends('layouts.app')
@section('page_title')
    المستخدمين
@endsection
@section('small_title')
    قائمه المستخدمين
@endsection
@section('content')




    <!-- Main content -->
    <section class="content">
    @include('flash::message')
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">قائمه المستخدمين</h3>

            </div>
            <div class="box-body">
                <a href="{{url(route('users.create'))}}" class="btn btn-primary">
                    <i class="fa fa-plus "></i>مستخدم جديد</a>
                @if(count($users))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الالكتروني</th>
                                    <th>الرتبه</th>
                                    <th class="text-center">تعديل</th>
                                    <th class="text-center">حذف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <div class="btn btn-bitbucket">{{$role->display_name}}</div>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url(route('users.edit', $user->id))}}" class=" btn btn-success btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {!! Form::open([
                                                'action' => ['UserController@destroy',$user->id],
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

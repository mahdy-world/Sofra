@extends('layouts.app')
@section('content')
    <section class="content">



        <div class="box box-primary">
            <div class="box-body">

                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i>
                                @foreach($records->items as $item)
                                 # {{$item->pivot->order_id}}
                                <small class="pull-left"><i class="fa fa-calendar-o"></i>  {{$records->created_at}}
                                </small>
                                @endforeach
                            </h2>
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            طلب من
                            <address>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  {{$records->client->name}}                        <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>   الهاتف : {{$records->client->phone}}                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  البريد الإلكترونى : {{$records->client->email}}                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  العنوان :{{$records->client->block->city->name}}
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <i class="fa fa-angle-left" aria-hidden="true"></i><strong>   المطعم :{{$records->restaurant->name}} </strong><br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  <strong> العنوان : {{$records->restaurant->block->name}}</strong>                   <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i> <strong> الهاتف : {{$records->restaurant->restaurant_phone}}</strong>
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <i class="fa fa-angle-left" aria-hidden="true"></i><b>
                                رقم الفاتورة
                                @foreach($records->items as $item)
                                    # {{$item->pivot->order_id}}
                            </b><br>
                            <i class="fa fa-angle-left" aria-hidden="true"></i><b>تفاصيل طلب: {{$records->note}}  </b><br>

                            <i class="fa fa-angle-left" aria-hidden="true"></i><b>  حالةالطلب:
                                <i>{{$records->status}}</i>
                            </b><br>
                            <i class="fa fa-angle-left" aria-hidden="true"></i><b>  الإجمالى:{{$records->total}}
                            </b>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>إسم المنتج</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>ملاحظة</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    @foreach($records->items as $i)
                                    <td>{{$i->name}}</td>
                                    @endforeach
                                    <td>{{$item->pivot->qty}}</td>
                                    <td>{{$records->price}}</td>
                                    <td>{{$item->pivot->note}}</td>

                                </tr>
                                <tr>
                                    <td>--</td>
                                    <td>تكلفة التوصيل</td>
                                    <td>-</td>
                                    <td>{{$records->delivery_cost}}</td>
                                    <td></td>
                                </tr>
                                <tr class="bg-success">
                                    <td>--</td>
                                    <td>الإجمالي</td>
                                    <td>-</td>
                                    <td>
                                        {{$records->total}}  جنيه
                                    </td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                            @endforeach
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <a href="" class="btn btn-default" id="print-all">
                                <i class="fa fa-print"></i> طباعة </a>

                            <script>
                                //                                $('#myModal').on('shown.bs.modal', function () {
                                //                                    $('#myInput').focus()
                                //                                })
                            </script>
                        </div>
                    </div>
                </section><!-- /.content -->
                <div class="clearfix"></div>

            </div>
        </div>


    </section>

@endsection




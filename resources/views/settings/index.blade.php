@extends('layouts.app')

@section('page_title')
    الاعدادات
@endsection
@section('small_title')
    اعدادات الموقع
@endsection
@section('content')
<section class="content">

    <!-- general form elements -->
    <div class="box box-primary">
        <!-- form start -->
        <form method="POST" action="" accept-charset="UTF-8" id="myForm" role="form" enctype="multipart/form-data">
            @csrf

            <div class="box-body">

                <!-- display errors of validation -->

                <h3>اعدادات التطبيق</h3>

                <h4>بيانات التواصل الاجتماعي</h4>
                <label>فيس بوك</label>
                <input class="form-control" placeholder="فيس بوك" name="facebook" type="text" value="{{$records->facebook_url}}">
                <br>
                <label>تويتر</label>
                <input class="form-control" placeholder="تويتر" name="twitter" type="text" value="{{$records->twitter_url}}">
                <br>
                <label>انستجرام</label>
                <input class="form-control" placeholder="انستجرام" name="instagram" type="text" value="{{$records->instgram_url}}">
                <hr>
                <label>عمولة التطبيق</label>
                <input class="form-control" placeholder="عمولة التطبيق" name="commission" type="number" value="{{$records->commission}}">
                <br>
                <label>عن التطبيق</label>
                <textarea class="form-control" placeholder="عن التطبيق" name="about_app" cols="50" rows="10">{{$records->about_us}}</textarea>
                <br>
                <label>الشروط والأحكام</label>
                <textarea class="form-control" placeholder="الشروط والأحكام" name="terms" cols="50" rows="10">{{$records->terms}}</textarea>
                <hr>
                <h4>بيانات صفحة العمولة</h4>
                <label>نص العمولة</label>
                <textarea class="form-control" placeholder="نص العمولة" name="commissions_text" cols="50" rows="10">{{$records->text}}</textarea>
                <br>
                <label>الحسابات البنكية</label>
                <textarea class="form-control" placeholder="الحسابات البنكية" name="bank_accounts" cols="50" rows="10">{{$records->contact}}</textarea>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </form>
    </div><!-- /.box -->

</section>
@endsection

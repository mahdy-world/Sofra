@inject('role','App\Models\Role')
<?php
$roles =$role->pluck('display_name','id')->toArray();
?>
     <div class="form-group">
        <label for="name">الاسم</label>
        {!! Form::text('name',null,[
            'class' =>'form-control'
        ]) !!}
    </div>

    <div class="form-group">
        <label for="Email">البريد الالكتروني</label>
        {!! Form::text('email',null,[
            'class' =>'form-control'
        ]) !!}
    </div>
    <div class="form-group">
        <label for="password">كلمه السر</label>
        {!! Form::password('password',[
            'class' =>'form-control'
        ]) !!}
    </div>
    <div class="form-group">
        <label for="password_confirmation">تأكيد كلمه السر</label>
        {!! Form::password('password_confirmation',[
            'class' =>'form-control'
        ]) !!}
    </div>
    <div class="form-group">
        <label for="roles_list">الرتبه</label>
        {!! Form::select('roles_list[]',$roles,null,[
            'class' =>'form-control',
            'multiple' =>'multiple',
        ]) !!}
    </div>
    @include('handler.errors')
    <div class="form-group">
        <button class="btn btn-primary" type="submit">موافق</button>
    </div>
    {!! Form::close() !!}
</div>

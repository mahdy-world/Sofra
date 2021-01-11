
<div>
    <div class="form-group">
        <label for="name">الاسم</label>
        {!! Form::text('name',null,[
            'class' =>'form-control'
        ]) !!}
    </div>

    <div class="form-group">
        <label for="display_name">الوصف</label>
        {!! Form::textarea('display_name',null,[
            'class' =>'form-control'
        ]) !!}
    </div>

    <div class="form-group">
        <label for="name">الصلاحيات</label><br>
        <label for='selectAll'> اختيار الكل</label>
        <input id="selectAll" type="checkbox">
        <div class="row">
                <div class="col-sm-3">
                    <div class="row">
{{--                        @foreach($permissions as $permission)--}}
{{--                            <div class="col-sm-3">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" name="permission[]" value="{{$permission->id}}">--}}
{{--                                        <label>{{$permission->name}}</label>--}}
{{--                                    </label>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
                       <div class='form-group'>
                        @foreach ($permissions as $permission)
                            {{ Form::checkbox('permissions[]',  $permission->id ) }}
                            {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>
                        @endforeach
                    </div>
                    </div>
                </div>
        </div>
    </div>
    @include('handler.errors')
    <div class="form-group">
        <button class="btn btn-primary" type="submit">موافق</button>
    </div>
    {!! Form::close() !!}
</div>



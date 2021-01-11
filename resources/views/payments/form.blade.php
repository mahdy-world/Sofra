<div>
    <div class="form-group">
        <label for="name">طرق الدفع</label>
        {!! Form::text('name',null,[
            'class' =>'form-control'
        ]) !!}
    </div>
    @include('handler.errors')
    <div class="form-group">
        <button class="btn btn-primary" type="submit">موافق</button>
    </div>
    {!! Form::close() !!}
</div>

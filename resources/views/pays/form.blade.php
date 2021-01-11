<div>
    <div class="form-group">
        <label for="name">المطعم</label>
        {!! Form::select('restaurant_id',$model->pluck('name','id'),null,[
        'class'=>'form-control']) !!}
        <label for="name"></label>
        {!! Form::text('amount',null,[
            'class' =>'form-control','placeholder'=>'المبلغ'
        ]) !!}
        <label for="name"></label>
        {!! Form::text('note',null,[
            'class' =>'form-control','placeholder'=>'بيان العمليه'
        ]) !!}
    </div>
    @include('handler.errors')
    <div class="form-group">
        <button class="btn btn-primary" type="submit">موافق</button>
    </div>
    {!! Form::close() !!}
</div>

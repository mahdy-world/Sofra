
            <div class="box-body">
                {!! Form::model($model,[
                    'action' => ['RoleController@update',$model->id],
                    'method' => 'put'
                ]) !!}
                @include('role.form')
            </div>
            @include('flash::message')

@include('partials.errors', [ 'message' => trans('app.errors.input') ])

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<h3>@lang('user::profile.section.general')</h3>
<div class="form-group">
    {!! Form::label('name', trans('user::profile.field.name'), [ 'class' => 'col-sm-2 control-label' ]) !!}
    <div class="col-sm-10">
        {!! Form::text('name', null, [ 'class' => 'form-control' ]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('email', trans('user::profile.field.email'), [ 'class' => 'col-sm-2 control-label' ]) !!}
    <div class="col-sm-10">
        {!! Form::email('email', null, [ 'class' => 'form-control' ]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('locale', trans('user::profile.field.locale'), [ 'class' => 'col-sm-2 control-label' ]) !!}
    <div class="col-sm-10">
        {!! Form::select('locale', $locales, null, [ 'class' => 'form-control' ]) !!}
    </div>
</div>
<hr>
<h3>@lang('user::profile.section.password')</h3>
<div class="form-group">
    {!! Form::label('password', trans('user::profile.field.password'), [ 'class' => 'col-sm-2 control-label' ]) !!}
    <div class="col-sm-10">
        {!! Form::password('password', [ 'class' => 'form-control' ]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('password_confirmation', trans('user::profile.field.password_confirmation'), [ 'class' => 'col-sm-2 control-label' ]) !!}
    <div class="col-sm-10">
        {!! Form::password('password_confirmation', [ 'class' => 'form-control' ]) !!}
    </div>
</div>
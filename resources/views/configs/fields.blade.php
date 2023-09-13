<!-- Json Fields Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('json_fields', 'Json Fields:') !!}
    {!! Form::textarea('json_fields', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('configs.index') }}" class="btn btn-secondary">Cancel</a>
</div>

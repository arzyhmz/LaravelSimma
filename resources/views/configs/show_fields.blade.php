<!-- Json Fields Field -->
<div class="form-group">
    {!! Form::label('json_fields', 'Json Fields:') !!}
    <p>{{ $config->json_fields }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $config->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $config->updated_at }}</p>
</div>


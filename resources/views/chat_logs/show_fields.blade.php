<!-- Key Field -->
<div class="form-group">
    {!! Form::label('key', 'Key:') !!}
    <p>{{ $chatLogs->key }}</p>
</div>

<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $chatLogs->date }}</p>
</div>

<!-- Total Field -->
<div class="form-group">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $chatLogs->total }}</p>
</div>

<!-- List Id Field -->
<div class="form-group">
    {!! Form::label('list_id', 'List Id:') !!}
    <p>{{ $chatLogs->list_id }}</p>
</div>

<!-- Failed List Id Field -->
<div class="form-group">
    {!! Form::label('failed_list_id', 'Failed List Id:') !!}
    <p>{{ $chatLogs->failed_list_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $chatLogs->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $chatLogs->updated_at }}</p>
</div>


<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $logs->date }}</p>
</div>

<!-- Total Field -->
<div class="form-group">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $logs->total }}</p>
</div>

<!-- List Id Field -->
<div class="form-group">
    {!! Form::label('list_id', 'Success IDs:') !!}
    <p>{{ $logs->list_id }}</p>
</div>

<div class="form-group">
    {!! Form::label('list_id', 'Failed IDs:') !!}
    <p>{{ $logs->failed_list_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $logs->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $logs->updated_at }}</p>
</div>


<!-- Partner Id Field -->
<div class="form-group">
    {!! Form::label('partner_id', 'Partner Id:') !!}
    <p>{{ $wabHistory->partner_id }}</p>
</div>

<!-- Room Id Field -->
<div class="form-group">
    {!! Form::label('room_id', 'Room Id:') !!}
    <p>{{ $wabHistory->room_id }}</p>
</div>

<!-- Chat Field -->
<div class="form-group">
    {!! Form::label('chat', 'Chat:') !!}
    {!! $wabHistory->chat !!}
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $wabHistory->status }}</p>
</div>

<div class="form-group">
    {!! Form::label('status', 'Error Message:') !!}
    <p>{{ $wabHistory->message }}</p>
</div>

<!-- Update Date Field -->
<div class="form-group">
    {!! Form::label('update_date', 'Update Date:') !!}
    <p>{{ $wabHistory->update_date }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $wabHistory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $wabHistory->updated_at }}</p>
</div>


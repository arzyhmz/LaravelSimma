<!-- Partner Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('partner_id', 'Partner Id:') !!}
    {!! Form::text('partner_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Room Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('room_id', 'Room Id:') !!}
    {!! Form::text('room_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Chat Field -->
<div class="form-group col-sm-6">
    {!! Form::label('chat', 'Chat:') !!}
    {!! Form::text('chat', null, ['class' => 'form-control']) !!}
</div>

<!-- Update Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('update_date', 'Update Date:') !!}
    {!! Form::text('update_date', null, ['class' => 'form-control','id'=>'update_date']) !!}
</div>

@push('scripts')
   <script type="text/javascript">
           $('#update_date').datetimepicker({
               format: 'YYYY-MM-DD HH:mm:ss',
               useCurrent: true,
               icons: {
                   up: "icon-arrow-up-circle icons font-2xl",
                   down: "icon-arrow-down-circle icons font-2xl"
               },
               sideBySide: true
           })
       </script>
@endpush


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('wabHistories.index') }}" class="btn btn-secondary">Cancel</a>
</div>

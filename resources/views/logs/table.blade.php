<div class="table-responsive-sm">
    <table class="table table-striped" id="logs-table">
        <thead>
            <tr>
                <th>Date</th>
        <th>Total</th>
        <th>List Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($logs as $logs)
            <tr>
                <td>{{ $logs->date }}</td>
            <td>{{ $logs->total }}</td>
            <td>{{ $logs->list_id }}</td>
                <td>
                    {!! Form::open(['route' => ['logs.destroy', $logs->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('logs.show', [$logs->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('logs.edit', [$logs->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="table-responsive-sm">
    <table class="table table-striped" id="chatLogs-table">
        <thead>
            <tr>
                <th>Key</th>
        <th>Date</th>
        <th>Total</th>
        <th>List Id</th>
        <th>Failed List Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($chatLogs as $chatLogs)
            <tr>
                <td>{{ $chatLogs->key }}</td>
            <td>{{ $chatLogs->date }}</td>
            <td>{{ $chatLogs->total }}</td>
            <td>{{ $chatLogs->list_id }}</td>
            <td>{{ $chatLogs->failed_list_id }}</td>
                <td>
                    {!! Form::open(['route' => ['chatLogs.destroy', $chatLogs->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('chatLogs.show', [$chatLogs->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('chatLogs.edit', [$chatLogs->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
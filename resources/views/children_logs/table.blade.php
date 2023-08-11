<div class="table-responsive-sm">
    <table class="table table-striped" id="childrenLogs-table">
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
        @foreach($childrenLogs as $childrenLogs)
            <tr>
                <td>{{ $childrenLogs->key }}</td>
            <td>{{ $childrenLogs->date }}</td>
            <td>{{ $childrenLogs->total }}</td>
            <td>{{ $childrenLogs->list_id }}</td>
            <td>{{ $childrenLogs->failed_list_id }}</td>
                <td>
                    {!! Form::open(['route' => ['childrenLogs.destroy', $childrenLogs->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('childrenLogs.show', [$childrenLogs->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('childrenLogs.edit', [$childrenLogs->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
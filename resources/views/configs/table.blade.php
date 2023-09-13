<div class="table-responsive-sm">
    <table class="table table-striped" id="configs-table">
        <thead>
            <tr>
                <th>Json Fields</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($configs as $config)
            <tr>
                <td>{{ $config->json_fields }}</td>
                <td>
                    {!! Form::open(['route' => ['configs.destroy', $config->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('configs.show', [$config->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('configs.edit', [$config->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
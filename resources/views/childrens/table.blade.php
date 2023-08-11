<div class="table-responsive-sm">
    <table class="table table-striped" id="childrens-table">
        <thead>
            <tr>
                <th>Partner Id</th>
        <th>Pledge Id</th>
        <th>Paid Thru</th>
        <th>Name</th>
        <th>Idn</th>
        <th>Status</th>
        <th>Message</th>
        <th>Udpate Date</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($childrens as $children)
            <tr>
                <td>{{ $children->partner_id }}</td>
            <td>{{ $children->pledge_id }}</td>
            <td>{{ $children->paid_thru }}</td>
            <td>{{ $children->name }}</td>
            <td>{{ $children->idn }}</td>
            <td>{{ $children->status }}</td>
            <td>{{ $children->message }}</td>
            <td>{{ $children->udpate_date }}</td>
                <td>
                    {!! Form::open(['route' => ['childrens.destroy', $children->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('childrens.show', [$children->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('childrens.edit', [$children->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
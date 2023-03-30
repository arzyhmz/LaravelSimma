<div class="table-responsive-sm">
    <table class="table table-striped" id="contacts-table">
        <thead>
            <tr>
                <th>Name</th>
                <!-- <th>Contact Email</th> -->
                <th>Phone Number</th>
                <!-- <th>Status</th> -->
                <th>Date Of Birth</th>
                <th>Motivation Code</th>
                <th>Join Date</th>
                <th>Need To Post</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <!-- <td>{{ $contact->contact_email }}</td> -->
                <td>{{ $contact->phone_number }}</td>
                <!-- <td>{{ $contact->status }}</td> -->
                <td>{{ $contact->date_of_birth }}</td>
                <td>{{ $contact->motivation_code }}</td>
                <td>{{ $contact->join_date }}</td>
                <td>{{ $contact->need_tp_post }}</td>
                <td>
                    {!! Form::open(['route' => ['contacts.destroy', $contact->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('contacts.show', [$contact->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <!-- <a href="{{ route('contacts.edit', [$contact->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a> -->
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
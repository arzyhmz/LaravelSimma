<div class="table-responsive-sm">
    <table class="table table-striped" id="contacts-table">
        <thead>
            <tr>
                <!-- <th>Table ID</th> -->
                <!-- <th>Partner ID</th> -->
                <!-- <th>Qontact ID</th> -->
                <th>Full Name</th>
                <!-- <th>Status</th> -->
                <!-- <th>Contact Email</th> -->
                <th>Phone Number</th>
                <th>Added </th>
                <th>Updated </th>
                <!-- <th>Added Date</th> -->
                <!-- <th>Updated Date</th> -->
                <th>Posted To Qontact</th>
                <th>Qontact ID</th>
                <th>Partner ID</th>
                <th>status</th>
                <th>Last Sync Chat</th>
                <th >Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contacts as $contact)
            <tr>
                <!-- <td>{{ $contact->table_id }}</td> -->
                <!-- <td>{{ $contact->partner_id }}</td> -->
                <td>{{ $contact->name }}  {{ $contact->last_name }}</td>
                <!-- <td>{{ $contact->qontact_id }}</td> -->
                <!-- <td>{{ $contact->status }}</td>  -->
                <!-- <td>{{ $contact->contact_email }}</td> -->
                <td>{{ $contact->phone_number }}</td>
                <td>{{ $contact->date_added }}</td>
                <td>{{ $contact->update_at }}</td>
                <!-- <td>{{ $contact->date_added }}</td> -->
                <!-- <td> </td> -->
                <td>{{ $contact->posted_to_qontact_date }}</td>
                <td>{{ $contact->qontact_id }}</td>
                <td>{{ $contact->partner_id }}</td>
                <td>{{ $contact->status }}</td>
                <td>{{ $contact->last_update_chat }}</td>
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
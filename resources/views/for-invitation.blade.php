<table class="table table-hover table-responsive">
    <thead>
        <tr>
            <th>Vendor</th>
            <th>Mode</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>URL</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($invitations as $invitation)
                <tr>
                    <td>{{ $invitation->vendor_sec_reg_name }}</td>
                    <td>{{ $invitation->mode }}</td>
                    <td>{{ $invitation->firstname }}</td>
                    <td>{{ $invitation->lastname }}</td>
                    <td>{{ Request::root() }}/{{ $invitation->token }}/{{ $invitation->invitation_code }}</td>
                </tr>
            @endforeach
        </tbody>
</table>
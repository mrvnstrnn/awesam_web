<table border="1" cellspacing="0" cellpadding="0" class="table table-hover table-responsive">
    <thead>
        <tr>
            <th>Vendor</th>
            <th>Acronym</th>
            <th>Email</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>URL</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($invitations as $invitation)
                <tr>
                    <td>{{ $invitation->vendor_sec_reg_name }}</td>
                    <td>{{ $invitation->vendor_acronym }}</td>
                    <td>{{ $invitation->vendor_admin_email }}</td>
                    <td>{{ $invitation->vendor_firstname }}</td>
                    <td>{{ $invitation->vendor_lastname }}</td>
                    <td>{{ route('login') }}</td>
                </tr>
            @endforeach
        </tbody>
</table>
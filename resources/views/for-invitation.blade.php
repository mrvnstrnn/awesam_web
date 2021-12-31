<table border="1" cellspacing="0" cellpadding="0" class="table table-hover table-responsive">
    <thead>
        <tr>
            <th>Vendor</th>
            {{-- <th>Mode</th> --}}
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Programs</th>
            <th>Invited</th>
            <th>Invited Date</th>
            <th>URL</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($invitations as $invitation)
                <tr>
                    <td>{{ $invitation->vendor_sec_reg_name }}</td>
                    {{-- <td>{{ $invitation->mode }}</td> --}}
                    <td>{{ $invitation->firstname }}</td>
                    <td>{{ $invitation->lastname }}</td>
                    <td>{{ $invitation->email }}</td>
                    <td>{{ $invitation->sent_email }}</td>
                    <td>
                        @php
                            $users = \App\Models\User::select('id')->where('email', $invitation->email)->first();
                        @endphp

                        @if (is_null($users))
                            Not yet registered.
                        @else
                            @php
                                $user_programs = \App\Models\UserProgram::join('program', 'program.program_id', 'user_programs.program_id')
                                                                ->select('program.program')
                                                                ->where('user_id', $users->id)
                                                                ->get()
                                                                ->pluck('program');
                            @endphp
                            {{ $user_programs }}
                        @endif
                    </td>
                    <td>{{ $invitation->sent_email }}</td>
                    <td>{{ date('M d, Y', strtotime($invitation->created_at)) }}</td>
                    <td>{{ Request::root() }}/invitation-link/{{ $invitation->token }}/{{ $invitation->invitation_code }}</td>
                </tr>
            @endforeach
        </tbody>
</table>
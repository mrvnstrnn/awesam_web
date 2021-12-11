<html>
    <head>
        <title>Lease Package Checklist</title>
        <link href="./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
                @page {
                    margin: 0px; 
                }

                #content {
                    margin: 50px;
                }

                body {
                    font-family: Arial, Helvetica, sans-serif;
                    /* background-image: url('globe-logo.png');
                    background-size: 100px 50px;
                    opacity: .15; */
                },

                h1 {
                    font-size: 26px;
                    padding-top: 30px;
                    margin-bottom: 0px;
                }

                tr th, tr, td, p {
                    font-size: 12px;
                }

        </style>
    </head>
    <body id="content">
        <h3 class="text-center">Lease Package Checklist of {{ $sam_id }}</h3>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Submitted By</th>
                                <th>File</th>
                                <th>Date Submitted</th>
                                <th>Date Approved</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $datas_file = \DB::table('sub_activity_value')
                                            ->select('users.name', 'sub_activity_value.*', 'sub_activity.sub_activity_name', 'sub_activity.sub_activity_id', 'sub_activity.requires_validation', 'sub_activity.activity_id')
                                            ->join('sub_activity', 'sub_activity_value.sub_activity_id', 'sub_activity.sub_activity_id')
                                            ->join('users', 'users.id', 'sub_activity_value.user_id')
                                            ->where('sub_activity_value.sam_id', $sam_id)
                                            ->where('sub_activity_value.type', 'doc_upload')
                                            ->where('sub_activity_value.status', 'approved')
                                            ->orderBy('sub_activity_value.sub_activity_id')
                                            ->get();     
                            @endphp
                            @foreach ($datas_file as $data_file)
                                @php
                                    $file_name = json_decode($data_file->value);
                                @endphp
                                <tr>
                                    <td>_________</td>
                                    <td>
                                        {{ $data_file->name }}
                                        {{-- <input type="checkbox" name="checkbox{{$data_file->id}}" id="checkbox{{$data_file->id}}"> --}}
                                    </td>
                                    <td>{{ $file_name->file }}</td>
                                    <td>{{ date('M d, Y', strtotime($data_file->date_created) ) }}</td>
                                    <td>{{ isset($data_file->date_update) ? date('M d, Y', strtotime($data_file->date_update) ) : "No Data" }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>

</html>
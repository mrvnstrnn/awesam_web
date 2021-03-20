@extends('layouts.main')

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                <span>COLOC</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            Unassigned Tasks
                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Details</th>
                                        <th class="text-center">Activities</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center text-muted">#345</td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <div class="widget-content-left">
                                                            <img width="40" class="rounded-circle"
                                                                src="/images/avatars/4.jpg" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">John Doe</div>
                                                        <div class="widget-subheading opacity-7">Quezon City</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="badge badge-success">LEAVE</div>
                                        </td>
                                        <td class="text-center" style="width: 150px;">
                                            Mar 22 to 24
                                        </td>
                                        <td class="text-center" style="width: 150px;">
                                            10
                                        </td>
                                        <td class="text-center">
                                            <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm">Details</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center text-muted">#347</td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <div class="widget-content-left">
                                                            <img width="40" class="rounded-circle"
                                                                src="/images/avatars/3.jpg" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">Ruben Tillman</div>
                                                        <div class="widget-subheading opacity-7">Caloocan North</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="badge badge-success">LEAVE</div>
                                        </td>
                                        <td class="text-center" style="width: 150px;">
                                            Apr 16 to 21
                                        </td>
                                        <td class="text-center" style="width: 150px;">
                                            15
                                        </td>
                                        <td class="text-center">
                                            <button type="button" id="PopoverCustomT-2" class="btn btn-primary btn-sm">Details</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center text-muted">#321</td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <div class="widget-content-left">
                                                            <img width="40" class="rounded-circle"
                                                                src="/images/avatars/2.jpg" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">Elliot Huber</div>
                                                        <div class="widget-subheading opacity-7">
                                                            Caloocan South
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="badge badge-danger">Absent</div>
                                        </td>
                                        <td class="text-center" style="width: 150px;">
                                            Mar 20
                                        </td>
                                        <td class="text-center" style="width: 150px;">
                                            3
                                        </td>
                                        <td class="text-center">
                                            <button type="button" id="PopoverCustomT-3" class="btn btn-primary btn-sm">Details</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center text-muted">#55</td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <div class="widget-content-left">
                                                            <img width="40" class="rounded-circle"
                                                                src="/images/avatars/1.jpg" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">Vinnie Wagstaff</div>
                                                        <div class="widget-subheading opacity-7">Malabon</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="badge badge-success">LEAVE</div>
                                        </td>
                                        <td class="text-center" style="width: 150px;">
                                            Apr 1 to 5
                                        </td>
                                        <td class="text-center" style="width: 150px;">
                                            15
                                        </td>
                                        <td class="text-center">
                                            <button type="button" id="PopoverCustomT-4" class="btn btn-primary btn-sm">Details</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('menu')

    @include('profiles.vendor.menu')

@endsection

@section('title')
    {{ $title }}
@endsection

@section('title-subheading')
    {{ $title_subheading }}
@endsection

@section('title-icon')

    <i class=" {{ "pe-7s-" . $title_icon . " icon-gradient bg-mean-fruit" }}"></i>

    {{-- icon from controller issue need to find a new way --}}
    {{-- to get variable info from UserController --}}
    {{-- {{ $title_icon }} --}}

@endsection

<div class="modal fade" id="view_pr_memo_site_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title">
                                        {{ $value }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="pr_memo_table">
                                    <thead>
                                        <tr>
                                            <th>Search Ring</th>
                                            <th>Region</th>
                                            <th>Province</th>
                                            <th>Lgu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sites as $site)
                                            <tr>
                                                <td scope="row">{{ $site->site_name }}</td>
                                                <td>{{ $site->region_name }}</td>
                                                <td>{{ $site->province_name }}</td>
                                                <td>{{ $site->lgu_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#pr_memo_table').DataTable();
    });
</script>



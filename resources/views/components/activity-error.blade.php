<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
</style>



{{-- <div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header p-0">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content text-left">
                                    <div>
                                        <h5 class="menu-header-title">
                                            {{ $site[0]->site_name }}
                                            @if(!is_null($site[0]->site_category) && $site[0]->site_category != "none")
                                                <span class="mr-3 badge badge-secondary"><small class="site_category">{{ $site[0]->site_category }}</small></span>
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body"> --}}
                            <div class="row p-0">
                                <div class="text-center col-12">
                                    <img src="/images/construction.gif" width="90%"/>
                                    <H1 class="">Action Component Not Yet Configured</H1>
                                    @if(isset($activity_source))
                                        <h5>activity_source: {{$activity_source}}</h5>
                                        <div class="text-danger">Missing or incorrect component defintion in stage_activities_profiles tables or the source link doesnt have the correct activity_source attribute</div>
                                    @else
                                        <h5>activity_source is not yet configured in the clicked element</H5>
                                        <div class="text-danger">Please check if the datatable or link contains the attribute data-activity_source</div>
                                    @endisset
                                    <button class="btn btn-lg mt-5 mb-5 btn-shadow btn-primary mark_as_complete" type="button">Move To Next Activity</button>
                                    <div class="border-top text-left pt-3">
                                    {{-- <H5>Debugging</H5>
                                    @php
                                        dd($site);
                                    @endphp --}}
                                    </div>
                                </div>
                            </div>
                        {{-- </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<script>
    $(".mark_as_complete").on("click", function() {

        $(".mark_as_complete").attr("disabled", "disabled");
        $(".mark_as_complete").text("Processing...");

        var sam_id = ["{{ $site[0]->sam_id }}"];
        var activity_name = "mark_as_complete";
        var site_category = ["{{ $site[0]->site_category }}"];
        var activity_id = ["{{ $site[0]->activity_id }}"];
        var program_id = "{{ $site[0]->program_id }}";

        $.ajax({
            url: "/accept-reject-endorsement",
            method: "POST",
            data: {
                sam_id : sam_id,
                activity_name : activity_name,
                site_category : site_category,
                activity_id : activity_id,
                program_id : program_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error){
                    $("table[data-program_id="+"{{ $site[0]->program_id }}"+"]").DataTable().ajax.reload(function(){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".mark_as_complete").removeAttr("disabled");
                        $(".mark_as_complete").text("Move To Next Activity");

                        $("#viewInfoModal").modal("hide");

                    });
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )

                    $(".mark_as_complete").removeAttr("disabled");
                    $(".mark_as_complete").text("Move To Next Activity");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".mark_as_complete").removeAttr("disabled");
                $(".mark_as_complete").text("Move To Next Activity");
            }
        });

    });
</script>
<div class="row">
    <div class="col-12">
        @php
            $po = App\Models\PrMemoSite::join('pr_memo_table_renewal', 'pr_memo_table_renewal.generated_pr_memo', 'pr_memo_site.pr_memo_id')
                                ->where('pr_memo_site.sam_id', $site[0]->sam_id)
                                ->first();
            
            $vendor = App\Models\Vendor::select('vendor_sec_reg_name', 'vendor_acronym')
                                            ->where('vendor_id', $po->vendor)
                                            ->first();
        @endphp
        <form class="vendor_awarding_form">
            <input type="hidden" name="file_url_id" id="file_url_id" class="form-control" readonly>
            <div class="form-row">
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="po_number">PO Number</label>
                        <input type="text" name="po_number" id="po_number" value="{{ $po->po_number }}" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="po_date">PO Date</label>
                        <input type="text" name="po_date" id="po_date" value="{{ $po->po_date }}" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="vendor">Vendor</label>
                        <input type="hidden" name="vendor" id="vendor" value="{{ $po->vendor }}" class="form-control" readonly>
                        <input type="text" name="vendor_name" id="vendor_name" value="{{ $vendor->vendor_sec_reg_name }} ({{ $vendor->vendor_acronym }})" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="folder_url">Folder Url</label>
                        <input type="text" name="folder_url" id="folder_url" class="form-control">
                        <small class="folder_url-error text-danger"></small>
                    </div>
                </div>
            </div>
            <div class="form-row pull-right">
                <div class="form-group">
                    {{-- <button type="button" class="btn btn-lg btn-shadow btn-success">Check previous site documents</button> --}}
                    <button type="button" class="btn btn-lg btn-shadow btn-primary award_to_vendor">Award to Vendor</button>
                </div>
            </div>

            <div class="iframe_viewer mt-5">
                <iframe src="{{ asset('new-file-default.html') }}" style="width:100%; border:0;"></iframe>
            </div>
        </form>
    </div>
</div>

<div class="form_html"></div>


<script>
    $(document).ready(function(){
        
        $("button.award_to_vendor").on("click", function() {
            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var sam_id = ["{{ $site[0]->sam_id }}"];
            var activity_name = "award_to_vendor";
            var site_category = ["{{ $site[0]->site_category }}"];
            var activity_id = ["{{ $site[0]->activity_id }}"];
            var program_id = "{{ $site[0]->program_id }}";

            var po_number = $("#po_number").val();
            var vendor = $("#vendor").val();
            var vendor_name = $("#vendor_name").val();
            var folder_url = $("#folder_url").val();
            var file_url_id = $("#file_url_id").val();
            var data_complete = "true";

            $(".vendor_awarding_form small").text("");

            $.ajax({
                url: "/accept-reject-endorsement",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    activity_name : activity_name,
                    site_category : site_category,
                    activity_id : activity_id,
                    program_id : program_id,
                    po_number : po_number,
                    vendor : vendor,
                    vendor_name : vendor_name,
                    data_complete : data_complete,
                    folder_url : folder_url,
                    file_url_id : file_url_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error){
                        $("table[data-program_id=8]").DataTable().ajax.reload(function () {
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )

                            $(".award_to_vendor").removeAttr("disabled");
                            $(".award_to_vendor").text("Award to Vendor");

                            $("#viewInfoModal").modal("hide");
                        });
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $(".vendor_awarding_form ." + index + "-error").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }

                        $(".award_to_vendor").removeAttr("disabled");
                        $(".award_to_vendor").text("Award to Vendor");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".award_to_vendor").removeAttr("disabled");
                    $(".award_to_vendor").text("Award to Vendor");
                }
            });
        });

        $(".vendor_awarding_form").on("change", "#folder_url", function () {
            var url = $(this).val();

            var result = url.replace(/(^\w+:|^)\/\//, '');

            // var array = result.split("/")

            var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
                '(\\#[-a-z\\d_]*)?$','i'); // fragment locator

            if (pattern.test(url)) {
                if ( result.length > 10 ) {

                    var split_url = url.split('folders/')[1];
                    if ( (split_url.split("?resourcekey").length > 1) ) {
                        var file_url = split_url.split('?resourcekey')[0];
                    } else {
                        var file_url = split_url;
                    }

                    $("#file_url_id").val(file_url);

                    $(".iframe_viewer").html(
                        '<iframe src="https://drive.google.com/embeddedfolderview?id='+ file_url +'#list" style="width:100%; height:600px; border:0;"></iframe>'
                    );
                } else if ( result.length < 1 ) { 
                    $(".iframe_viewer").html(
                        '<iframe src="{{ asset("new-file-default.html") }}" style="width:100%; border:0;"></iframe>'
                    );
                } else {
                    $(".iframe_viewer").html(
                        '<iframe src="{{ asset("new-file-error.html") }}" style="width:100%; border:0;"></iframe>'
                    );
                }
            } else {
                $(".iframe_viewer").html(
                    '<iframe src="{{ asset("new-file-url-error.html") }}" style="width:100%; border:0;"></iframe>'
                );
            }
        });
    });
</script>
$(document).ready(() => {


    refresh_counters();

    $('a:contains("New CLP")').append(
        '&nbsp;&nbsp;<span class="badge badge-pill badge-success" style="font-size: 10px; padding: 2px;">6</span>'
    );

    $('a:contains("PR Memo")').append(
        '&nbsp;&nbsp;<span class="badge badge-pill badge-success" style="font-size: 10px; padding: 2px;">6</span>'
    );


});    


function refresh_counters() {

    $.ajax({
        url: "/newsites/get-pr-po-counter",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp){

            console.log(JSON.parse(resp.message[1].DISTRIBUTION));
            var OPEN = JSON.parse(resp.message[1].DISTRIBUTION)[0].DISTRIBUTION_VALUE;
            var FOR_RAM_APPROVAL = JSON.parse(resp.message[1].DISTRIBUTION)[1].DISTRIBUTION_VALUE;
            var FOR_NAM_APPROVAL = JSON.parse(resp.message[1].DISTRIBUTION)[2].DISTRIBUTION_VALUE;
            var FOR_ARRIBA_PR_ISSUANCE = JSON.parse(resp.message[1].DISTRIBUTION)[3].DISTRIBUTION_VALUE;
            var AWAITING_PO = JSON.parse(resp.message[1].DISTRIBUTION)[4].DISTRIBUTION_VALUE;
            var COMPLETED = 'X';
            var TOTAL_SITES = 'X';

            $('.pr_memo_creation_count').text(OPEN);
            $('.ram_head_approval_count').text(FOR_RAM_APPROVAL);
            $('.nam_approval_count').text(FOR_NAM_APPROVAL);
            $('.arriba_pr_no_issuance_number').text(FOR_ARRIBA_PR_ISSUANCE);
            $('.vendor_awarding_count').text(AWAITING_PO);
            $('.completed_count').text(COMPLETED);
            $('.total_sites').text(TOTAL_SITES);
            

        },
        complete: function(){
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });

    
}
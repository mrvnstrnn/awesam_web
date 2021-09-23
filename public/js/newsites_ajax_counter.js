$(document).ready(() => {


    refresh_counters();



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


            $( ".sidebar_counter" ).remove();


            $('a:contains("PR / PO")').append(

            '<span class="sidebar_counter badge badge-dot badge-dot-md badge-danger">PR / PO</span>'

            );    

            
            if(OPEN > 0){
                $('a:contains("New CLP")').append(
                    '<span class="sidebar_counter badge badge-pill badge-danger" style="font-size: 9px; padding: 2px !important;">' + OPEN + '</span>'
                );    
            }
        
            if(FOR_RAM_APPROVAL > 0 || FOR_NAM_APPROVAL > 0){
                $('a:contains("PR Memo")').append(
                    '<span class="sidebar_counter badge badge-pill badge-danger" style="font-size: 9px; padding: 2px !important;">' + (+FOR_RAM_APPROVAL + +FOR_NAM_APPROVAL)  + '</span>'
                );
            }
        
            if(FOR_ARRIBA_PR_ISSUANCE > 0){
                $('a:contains("PR Issuance")').append(
                    '<span class="sidebar_counter badge badge-pill badge-danger" style="font-size: 9px; padding: 2px !important;">' + FOR_ARRIBA_PR_ISSUANCE + '</span>'
                );
            }

            if(AWAITING_PO > 0){
                $('a:contains("Vendor Awarding")').append(
                    '<span class="sidebar_counter badge badge-pill badge-danger" style="font-size: 9px; padding: 2px !important;">' + AWAITING_PO + '</span>'
                );
            }


        },
        complete: function(){
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });

    
}
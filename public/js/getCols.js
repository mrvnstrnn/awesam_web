function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
}

function datediff(first, second) {
    // Take the difference between the dates and divide by milliseconds per day.
    // Round to nearest whole number to deal with DST.
    return Math.round((second-first)/(1000*60*60*24));
}


function getCols(active_program, active_table, active_profile){

    var cols = [];


    $.ajax({
        url: "/datatables-columns/"+active_program+"/"+active_table+"/"+active_profile,
        method: 'GET',
        async: false,

        success: function (resp) {
            if(resp.length > 0){

                
                
                if(active_table=='new_endorsements_globe'){
                    
                    cols.push(
                        {
                            data: null,
                            name: "<input type='checkbox' data-checkbox='"+resp[0].program_id+"' id='checkAll"+resp[0].program_id+"' class='checkAll form-control' value='program"+resp[0].program_id+"' style='margin-left:-8px;width:20px;' />",
                            width: '20px',
                            orderable: false,
                            render: function(data){
                                return "<input type='checkbox' name='program"+data.program_id+"' id='checkbox_"+data.sam_id+"' value='"+data.sam_id+"' class='form-control checkbox-new-endorsement' data-site_vendor_id='"+data.vendor_id+"' data-site_category='"+data.site_category+"' data-activity_id='"+data.activity_id+"' style='width:20px;' />";
                            }                            
                        }
                    );

                }

                else if(active_table=='unassigned_site'){
                    
                    cols.push(
                        {
                            data: null,
                            name: "Agent",
                            width: '20px',
                            orderable: false,
                            render: function(data){

                                photo = "<div class='avatar-icon-wrapper avatar-icon-sm avatar-icon-add'>" +
                                         "<div class='avatar-icon' style='padding-top:3px; font-weight: bold;'>" +
                                        "<i>+</i>";


                                return photo;
                            },
                            className: function(){
                            }
                        }
                    );

                }

                var classVar = "";
                resp.forEach(function(field){

                    if(field['field_alignment'] != ''){
                        if(field['field_alignment'] == 'right'){
                            classVar =  'text-right';
                        }
                        else if(field['field_alignment'] == 'center'){
                            classVar =  'text-center';
                        }
                    } else {
                        classVar =  'text-left';
                    }

                    
                    switch(field['source_field']){

                        // case "issue_status":

                        //     cols.push(
                        //         {
                        //             data : field['source_field'],
                        //             name: field['field_name'],
                        //             searchable: true,
                        //             regex: true,
                        //             render : function(data){
                        //                 return data;
                        //             }
                        //         }
                        //     );
                        //     break;

                        // case "issue_details":

                        //     cols.push(
                        //         {
                        //             data : field['source_field'],
                        //             name: field['field_name'],
                        //             searchable: true,
                        //             regex: true,
                        //             render : function(data){
                        //                 return data;
                                    
                        //             }
                        //         }
                        //     );
                        //     break;

                        case "site_fields":

                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
                                    searchable: true,
                                    regex: true,
                                    render : function(data){
                                        if (data != null) {
                                            col = JSON.parse(data.replace(/&quot;/g,'"'));
                                            var results = $.map( col, function(e,i){
                                                if( e.field_name === field['search_field'] ) 
                                                return e; 
                                            });
                                            return results.length < 1 ? "" : results[0]['value'];
                                        } else {
                                            return "";
                                        }
                                    
                                    }
                                }
                            );
                            break;

                        case "activity_created":

                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
                                    searchable: true,
                                    regex: true,
                                    render : function(data){
                                        if (data != null) {
                                            return results.length < 1 ? "" : results[0]['value'];
                                        } else {
                                            return "";
                                        }
                                    
                                    }
                                }
                            );
                            break;

                        case "site_name":

                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
                                    searchable: true,
                                    regex: true,
                                    className: function(){
                                        if(field['field_alignment'] != ''){
                                            if(field['field_alignment'] == 'right'){
                                                return 'text-right';
                                            }
                                            else if(field['field_alignment'] == 'center'){
                                                return 'text-center';
                                            }
                                        } else {
                                            return 'text-left';
                                        }
                                    }
        
                                }
                            );
                            break;

                        case 'site_agent':
                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
                                    render : function(data){
                                        if(data != null){
                                            col = JSON.parse(data.replace(/&quot;/g,'"'));
                                            agent = col[0]['firstname'] + " " + col[0]['middlename'] + " " + col[0]['lastname'];
                                            return agent;    
                                        } else {
                                            return "";
                                        }
                                    },
                                    className: classVar
        
                                }
                            );
                            break;

                        case 'pr_memo_id':
                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
                                    render : function(data){
                                        return data ? data : "";
                                    },
                                    className: function(){
                                        if(field['field_alignment'] != ''){
                                            if(field['field_alignment'] == 'right'){
                                                return 'text-right';
                                            }
                                            else if(field['field_alignment'] == 'center'){
                                                return 'text-center';
                                            }
                                        } else {
                                            return 'text-left';
                                        }
                                    }
        
                                }
                            );
                            break;

                        case 'activities':
                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
                                    render : function(data){
                                        col = JSON.parse(data.replace(/&quot;/g,'"'));
                                        return col['activity_name'];
                                    },
                                    className: classVar
        
                                }
                            );
                            break;

                        default:
                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
                                    render : function(data){
                                        // site_name = "</strong>" + data + '</strong>';
                                        return data ? data : "";
                                    },
                                    className: classVar

                                }
                            );
                            // cols.push({data : field['source_field'], name: field['field_name']});
                    }

                });    
            }

        },

        error: function (resp) {
            console.log(resp);
        }

    });


    // console.log(cols);

    return cols;

}

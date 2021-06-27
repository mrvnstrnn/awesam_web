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
                            name: "<input type='checkbox' class='checkAll form-control' style='margin-left:-8px;width:20px;' />",
                            width: '20px',
                            orderable: false,
                            render: function(data){
                                return "<input type='checkbox' class='form-control' style='width:20px;' />";
                            }
                        }
                    );

                }

                resp.forEach(function(field){
                    switch(field['source_field']){
                        case "site_fields":

                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
                                    searchable: true,
                                    regex: true,
                                    render : function(data){
                                        col = JSON.parse(data.replace(/&quot;/g,'"'));
                                        
                                        var results = $.map( col, function(e,i){
                                            if( e.field_name === field['search_field'] ) 
                                            return e; 
                                        });
                                        return results[0]['value'];
                                    
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
                                    }
                                }
                            );
                            break;

                        default:
                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
                                    // render : function(data){
                                    //     site_name = "</strong>" + data + '</strong>';
                                    //     return site_name;
                                    // }
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

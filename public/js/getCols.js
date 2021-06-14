function getCols(active_program){

    var cols = [];


    $.ajax({
        url: "/datatables-columns/"+active_program+"/doc_validation",
        method: 'GET',
        async: false,

        success: function (resp) {

            if(resp.length > 0){
                resp.forEach(function(field){

                    switch(field['source_field']){
                        case "site_fields":
                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
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
                                        col = JSON.parse(data.replace(/&quot;/g,'"'));
                                        agent = col[0]['firstname'] + " " + col[0]['middlename'] + " " + col[0]['lastname'];
                                        return agent;
                                    }
                                }
                            );
                            break;

                        case 'action':
                            cols.push(
                                {
                                    data : field['source_field'], 
                                    name: field['field_name'],
                                    render : function(data){
                                        data_icon = data;
                                        return data_icon;
                                    }
                                }
                            );
                            break;

                        default:
                            cols.push({data : field['source_field'], name: field['field_name']});
                    }

                });    
            }

        },

        error: function (resp) {
            console.log(resp);
        }

    });


    console.log(cols);

    return cols;

}

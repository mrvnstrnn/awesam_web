

            // $.ajax({
            //         url: "/localcoop-values/" + $(this).find('td:first').text() + "/contacts",
            //         method: "GET",
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function (resp){

            //             var html = "";
            //             resp.forEach(function(data){

            //                 var dateParts = data['add_timestamp'].split("-");
            //                 var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
            //                 var dateString = moment(jsDate).format('YYYY-MM-DD');

            //                 var engagement = JSON.parse(data['value'].replace(/&quot;/g,'"'));
            //                 html = html + "<tr>";
                            
            //                     html = html + "<td>" + dateString + "</td><td>" + data['firstname'] + " " +  data['lastname'] + "</td>"

            //                 Object.keys(engagement).forEach(function (key, index){

            //                         html = html + "<td>" + engagement[key] + "</td>";
                                
            //                     // console.log(key + " : " + engagement[key]);

            //                 });
            //                 html = html + "</tr>";
            //             });

            //             $('#contacts_table tbody').empty();
            //             $('#contacts_table tbody').append(html);
            //             $('#contacts_table').DataTable();


            //         },
            //         error: function (resp){
            //             toastr.error(resp.message, "Error");
            //         }
            // });

            // $.ajax({
            //         url: "/localcoop-values/" + $(this).find('td:first').text() + "/engagements",
            //         method: "GET",
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function (resp){

            //             var html = "";
            //             resp.forEach(function(data){

            //                 var dateParts = data['add_timestamp'].split("-");
            //                 var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
            //                 var dateString = moment(jsDate).format('YYYY-MM-DD');

            //                 var engagement = JSON.parse(data['value'].replace(/&quot;/g,'"'));
            //                 html = html + "<tr>";
                            
            //                     html = html + "<td>" + dateString + "</td><td>" + data['firstname'] + " " +  data['lastname'] + "</td>"

            //                 Object.keys(engagement).forEach(function (key, index){

            //                         html = html + "<td>" + engagement[key] + "</td>";
                                
            //                     // console.log(key + " : " + engagement[key]);

            //                 });
            //                 html = html + "</tr>";
            //             });

            //             $('#engagement_table tbody').empty();
            //             $('#engagement_table tbody').append(html);
            //             $('#engagement_table').DataTable();


            //         },
            //         error: function (resp){
            //             toastr.error(resp.message, "Error");
            //         }
            // });

            // $.ajax({
            //         url: "/localcoop-values/" + $(this).find('td:first').text() + "/issues",
            //         method: "GET",
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function (resp){

            //             var html = "";
            //             resp.forEach(function(data){

            //                 var dateParts = data['add_timestamp'].split("-");
            //                 var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
            //                 var dateString = moment(jsDate).format('YYYY-MM-DD');
            //                 var allowed_issues_column = ["dependency", "nature_of_issue", "description", "status_of_issue"];
                            
            //                 var engagement = JSON.parse(data['value'].replace(/&quot;/g,'"'));
            //                 html = html + "<tr data-id='"+data.ID+"'>";
                            
            //                     html = html + "<td>" + dateString + "</td><td>" + data['firstname'] + " " +  data['lastname'] + "</td>"

            //                 Object.keys(engagement).forEach(function (key, index){

            //                     // console.log(key + " : " + engagement[key]);
            //                     if(allowed_issues_column.includes(key) == true){
            //                     html = html + "<td>" + engagement[key] + "</td>";
            //                     }

            //                 });
            //                 html = html + "</tr>";
            //             });

            //             $('#issues_table tbody').empty();
            //             $('#issues_table tbody').append(html);
            //             $('#issues_table').DataTable();

            //         },
            //         error: function (resp){
            //             toastr.error(resp.message, "Error");
            //         }
            // });
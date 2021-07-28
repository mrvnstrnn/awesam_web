<html>
    <head>
        <title>Ceate PR Memo</title>
        <style>
                @page {
                    margin: 0px; 
                }

                #content {
                    margin: 20px 40px;
                }

                body {
                    font-family: Arial, Helvetica, sans-serif;
                    background-image: url('globe-logo.png');
                    background-size: 100px 50px;
                    opacity: .05;
                },
                
                textarea {
                    font-family: Arial, Helvetica, sans-serif;
                },

                label {
                    display: block;
                    width: 100%;
                    padding: 0px;
                    margin: 0px;
                    font-size: 12px;
                }, 
                
                input {
                    display: block;
                    width: 100%;
                    height: 20px;
                    padding: 5px;
                    margin: 0px 0px 10px 0px;
                    font-size: 16px;
                }

                .section {
                    font-size: 20px;
                    padding-top: 20px;
                    font-weight: bold;
                    padding-bottom: 5px;
                }

                h1 {
                    font-size: 26px;
                    padding-top: 30px;
                    margin-bottom: 0px;
                }

                #financial_table {
                    font-family: Arial, Helvetica, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                }

                #financial_table td, #financial_table th {
                    border: 1px solid #ddd;
                    padding: 8px;
                }

                #financial_table tr:nth-child(even){background-color: #f2f2f2;}

                #financial_table tr:hover {background-color: #ddd;}

                #financial_table th {
                    padding-top: 12px;
                    padding-bottom: 12px;
                    text-align: left;
                    background-color: #04AA6D;
                    color: white;
                }
        </style>
    </head>
    <body>
        
        <div id="content">
            <table style='width:100%'>
                <tr>
                    <td style="width: 120px">
                        <img src="globe-logo.png" width="200px" height="100px;" />
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%">
                        <label for="to">To:</label>
                        <input type="text" id="to" name="to" value="{{ $to }}" />
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 50%">
                        <label for="thru">Thru:</label>
                        <input type="text" id="thru" name="thru" value="{{ $thru }}" />
                    </td>
                    <td style="width: 50%">
                        <label for="date_created">Date Created:</label>
                        <input type="text" id="date_created" name="date_created" value="{{ $date_created }}" />
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 50%">
                        <label for="from">From:</label>
                        <input type="text" id="from" name="from" value="{{ $from }}" />
                    </td>
                    <td style="width: 50%">
                        <label for="group">Group:</label>
                        <input type="text" id="group" name="group" value="{{ $group }}" />
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 50%">
                        <label for="division">Division:</label>
                        <input type="text" id="division" name="division" value="{{ $division }}" />
                    </td>
                    <td style="width: 50%">
                        <label for="department">Department:</label>
                        <input type="text" id="department" name="department" value="{{ $department }}" />
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%">
                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" value="{{ $subject }}" />
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 50%">
                        <label for="requested_amount">Requested Amount:</label>
                        <input type="text" id="requested_amount" name="requested_amount" value="{{ $budget_source }}" />
                    </td>
                    <td style="width: 50%">
                        <label for="budget_source">Budget Source:</label>
                        <input type="text" id="budget_source" name="budget_source" value="{{ $budget_source }}" />
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 50%">
                        <label for="requested_amount">Requested Amount:</label>
                        <input type="text" id="requested_amount" name="requested_amount" value="{{ number_format($requested_amount, 2) }}" />
                    </td>
                    <td style="width: 50%">
                        <label for="budget_source">Budget Source:</label>
                        <input type="text" id="budget_source" name="budget_source" value="{{ $budget_source }}" />
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%">
                        <label for="recommendation">Recommendation:</label>
                        <textarea type="text" id="recomentdation" name="recomentdation" style="height:auto;">{{ $recommendation }}</textarea>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%">
                        <label for="financial_analysis">Financial Analysis:</label>
                        <table id="financial_table">
                            <thead>
                                <tr>
                                    <th>Site ID</th>
                                    <th>Searching Name</th>
                                    <th>Region</th>
                                    <th>Province</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sites as $site)
                                <tr>
                                    <td>{{ $site->serial_number }}</td>
                                    <td>{{ $site->search_ring }}</td>
                                    <td>{{ $site->region }}</td>
                                    <td>{{ $site->province }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%">
                        <p>For your approval please.</p>
                        <p>Thank you.</p>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%">
                        <label for="created_by">Ceated by: SAM Tool Document Maker</label>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
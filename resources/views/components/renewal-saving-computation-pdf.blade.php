<html>
    <head>
        <title>Savings Computation</title>
        <style>
                @page {
                    margin: 0px; 
                }

                #content {
                    margin: 50px;
                }

                body {
                    font-family: Arial, Helvetica, sans-serif;
                    /* background-image: url('globe-logo.png');
                    background-size: 100px 50px;
                    opacity: .15; */
                },

                h1 {
                    font-size: 26px;
                    padding-top: 30px;
                    margin-bottom: 0px;
                }

                tr th, tr, td, p {
                    font-size: 12px;
                }

        </style>
    </head>
    <body>
        @php
            $json = json_decode($json_data);
        @endphp
        <div id="content">

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%; text-align: center;">
                        <table style="width: 100%;" border="1" cellspacing="0" cellpadding="0" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Type of Lessor</th>
                                    <th class="text-center">Tax Application (VAT/EWT)</th>
                                    <th class="text-center">Contract Rate</th>
                                    <th class="text-center">Add: 12% VAT</th>
                                    <th class="text-center">Less: 5% EWT</th>
                                    <th class="text-center">Net Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Old Terms:</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Lessors Demand: </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>New Terms: </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>*Amount Used:</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%; text-align: center;">
                        <table style="width: 100%;" border="1" cellspacing="0" cellpadding="0" class="table table-bordered table-hover summary_table">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">Years</th>
                                    <th rowspan="2" colspan="2" class="text-center">Period</th>
                                    <th colspan="2" class="text-center">Per Contract</th>
                                    <th colspan="2" class="text-center">Lessor Demand</th>
                                    <th colspan="2" class="text-center">New Terms</th>
                                    <th colspan="2" class="text-center">Savings</th>
                                </tr>
                                <tr>
                                    <th>Monthly</th>
                                    <th>Annual</th>
                                    <th>Monthly</th>
                                    <th>Annual</th>
                                    <th>Monthly</th>
                                    <th>Annual</th>
                                    <th>Monthly</th>
                                    <th>Annual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ( $i = \Carbon::parse($json->start_date); $i < \Carbon::parse($json->end_date); $i->addYear() )
                                <tr>
                                    <td> test </td>
                                    <td>{{ $i->format("Y-m-d"); }}</td>
                                    <td> formatted_new_date </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                <tr>
                                @endfor
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%; text-align: center;">
                        <table style="width: 100%;" border="1" cellspacing="0" cellpadding="0" class="table table-bordered table-hover summary_exdeal_table">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">Other Consideration</th>
                                    <th colspan="2" class="text-center">Per Contract</th>
                                    <th colspan="2" class="text-center">Lessor Demand</th>
                                    <th colspan="2" class="text-center">New Terms</th>
                                    <th class="text-center">Savings</th>
                                </tr>
                                <tr>
                                    <th>Particulars</th>
                                    <th>Total Amount</th>
                                    <th>Particulars</th>
                                    <th>Total Amount</th>
                                    <th>Particulars</th>
                                    <th>Total Amount</th>
                                    <th>Full Term</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $json->exdeal_request }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                <tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>

        </div>
    </body>
</html>
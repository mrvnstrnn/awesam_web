<html>
    <head>
        <title>Schedule of Rental Payment</title>
        <link href="./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            #content {
                margin: 50px;
            }

            body {
                font-family: Arial, Helvetica, sans-serif;
                /* background-image: url('globe-logo.png');
                background-size: 100px 50px;
                opacity: .15; */
            }

            * {
                font-size: 10px !important;
            }
        </style>
    </head>

    <body>
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Schedule of Rental Payment</h3>
                <div class="table-responsive">
                    @php
                
                        if(!isset($new_lease_terms_in_years) || $new_lease_terms_in_years == ""){
                            $lease_term_years = 10;
            
                        } else {
                            $lease_term_years = $new_lease_terms_in_years;
                        }
            
                        switch($new_terms_tax_application){
            
                            case "Vatable: Net of VAT - Net of EWT":         
            
                                $amount_used = 'Gross to Gross';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 0.95;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Vatable: Inclusive of VAT - Inclusive of EWT":    
            
                            $amount_used = 'Gross to Gross';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 1.12;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Vatable: Inclusive of VAT - Exclusive of EWT":    
            
                                $amount_used = 'Net to Net';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 1.07;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Vatable: Exclusive of VAT - Exclusive of EWT":    
                                
                                $amount_used = 'Gross to Gross';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 0.95;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Vatable: Exclusive of VAT - Inclusive of EWT":      
            
                                $amount_used = 'Gross to Gross';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 1;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Vatable: Silent of Vat - Silent of EWT":     
            
                                $amount_used = 'Gross to Gross';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 1;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Non Vatable: Net of VAT - Net of EWT":       
            
                                $amount_used = 'Net to Net';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 0.95;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Non Vatable: Inclusive of VAT - Inclusive of EWT":     
            
                            $amount_used = 'Gross to Gross';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 1;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Non Vatable: Inclusive of VAT - Exclusive of EWT":     
            
                            $amount_used = 'Net to Net';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 0.95;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Non Vatable: Exclusive of VAT - Exclusive of EWT":   
            
                                $amount_used = 'Net to Net';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 0.95;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Non Vatable: Exclusive of VAT - Inclusive of EWT":     
            
                            $amount_used = 'Gross to Gross';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount / 1;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Non Vatable: Silent of VAT - Silent of VAT":      
            
                                $amount_used = 'Gross to Gross';
            
                                $gross_amt_new =  $new_terms_monthly_contract_amount /  1;
                                $add_vat_new =  $gross_amt_new * 0.12;
                                $less_ewt_new =  $gross_amt_new * 0.05;
                                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;
            
                                break;
            
                            case "Not Applicable":      
            
                                $amount_used = 'Not Applicable';
            
                                $gross_amt_new = 0;
                                $add_vat_new = 0;
                                $less_ewt_new =  0;
                                $net_amt_new = 0;
            
                                break;
            
                        }
            
                    @endphp
            
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Tax Application</th>
                                <th colspan="5" class="text-center">{{ $new_terms_tax_application }}</th>
                            </tr>
                            <tr>
                                <th colspan="1" class="text-center">Yrs</th>
                                <th colspan="2" class="text-center">Contract Period</th>
                                <th colspan="1" class="text-center">Gross</th>
                                <th colspan="1" class="text-center">VAT</th>
                                <th colspan="1" class="text-center">EWT</th>
                                <th colspan="1" class="text-center">NET</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $new_monthly = 0;
                                $running_new_monthly = 0;
            
                                $new_yearly_total = 0;
                                $savings_yearly_total = 0;
            
                            @endphp
            
                            @for ($i = 0; $i < $lease_term_years; $i++)
            
                                @php
            
                                    $dtStart = Carbon::parse($new_terms_start_date)->addYears($i);
                                    $dtEnd = Carbon::parse($dtStart)->addYear()->subDay();
            
                                    if($amount_used === "Gross to Gross"){
                                        $amount_new = $gross_amt_new;
                                    }
                                    elseif($amount_used === "Net to Net"){
                                        $amount_new = $net_amt_new;
                                    }
                                    elseif($amount_used === "Not Applicable"){
                                        $amount_new = $net_amt_new;
                                    }
            
                                    if($new_monthly == 0){
            
                                        if($i < $new_terms_escalation_year - 1){
                                            $new_monthly = $amount_new;
                                        } else {
                                            $new_monthly = ($new_terms_escalation_rate * $amount_new) + $amount_new;
                                        }
            
                                        $running_new_monthly  = $new_monthly ;
            
                                    } else {
            
                                        if($i >= $new_terms_escalation_year - 1){
                                            $running_new_monthly = ($running_new_monthly * $new_terms_escalation_rate) + $running_new_monthly;
            
                                        } else {
                                            $running_new_monthly = $running_new_monthly;
                                        }
                                    }
            
            
                                    $new_yearly_total = $new_yearly_total + ($running_new_monthly * 12);
                                    
            
                                @endphp
                                <tr>
                                    <td class="text-center font-weight-bold"> {{ $i+1 }}</td>
                                    <td class="text-center">{{ $dtStart->format('M d, Y') }}</td>
                                    <td class="text-center">{{ $dtEnd->format('M d, Y') }}</td>
                                    <td class="text-center">{{ number_format($running_new_monthly,2) }}</td>
                                    <td class="text-center">{{ number_format($running_new_monthly * 0.12, 2) }}</td>
                                    <td class="text-center">{{ number_format($running_new_monthly * 0.05,2) }}</td>
                                    <td class="text-center">{{ number_format($running_new_monthly + ($running_new_monthly * 0.12) + ($running_new_monthly * 0.05) ,2) }}</td>
                                </tr>
                                
                            @endfor
                        </tbody>
                    </table>
            
                    <table style="margin-top: 50px; width: 100%;">
                        <tr>
                            <td style="width: 25%;">
                                GLOBE TELECOM INC.
                            </td>
                        </tr>
                    </table>
                    <table style="margin-top: 50px; width: 100%;">
                        <tr>
                            <td style="width: 25%;">
                                PREPARED BY
                            </td>
                            <td style="width: 75%;">
                                <b style="text-decoration: underline;">:_____LM Lead User_____</b>
                            </td>
                        </tr>
                    </table>
                    <table style="margin-top: 50px; width: 100%;">
                        <tr>
                            <td style="width: 25%;">
                                CHECKED & VERIFIED BY: 
                            </td>
                            <td style="width: 75%;">
                                <b style="text-decoration: underline;">:_____RUEL G. GARRO_____</b>
                            </td>
                        </tr>
                    </table>
                    <table style="margin-top: 50px; width: 100%;">
                        <tr>
                            <td style="width: 25%;">
                                CONFORME:
                            </td>
                            <td style="width: 75%;">
                                <b style="text-decoration: underline;">:_____{{ $lessor }}_____</b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>

</html>


<html>
    <head>
        <title>Savings Computation</title>
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
        <h3>Savings Computation - {{ $sam_id }}</h3>
        @php
        $lease_term_years = (int)$new_lease_terms_in_years;

        $old_escalation_rate =  (float) $old_terms_escalation_rate;
        $demand_escalation_rate = (float) $lessor_demand_escalation_rate;
        $new_escalation_rate = (float) $new_terms_escalation_rate;


        switch($old_terms_tax_application){

            case "Vatable: Net of VAT - Net of EWT":         

                $gross_amt_old =  $old_terms_contract_rate / 0.95;
                $add_vat_old =  $gross_amt_old * 0.12;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Vatable: Inclusive of VAT - Inclusive of EWT":         
            
                $gross_amt_old =  $old_terms_contract_rate / 1.12;
                $add_vat_old =  $gross_amt_old * 0.12;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Vatable: Inclusive of VAT - Exclusive of EWT":     

                $gross_amt_old =  $old_terms_contract_rate / 1.07;
                $add_vat_old =  $gross_amt_old * 0.12;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Vatable: Exclusive of VAT - Exclusive of EWT":         
            
                $gross_amt_old =  $old_terms_contract_rate / 0.95;
                $add_vat_old =  $gross_amt_old * 0.12;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;


                break;

            case "Vatable: Exclusive of VAT - Inclusive of EWT":         
            
                $gross_amt_old =  $old_terms_contract_rate / 1;
                $add_vat_old =  $gross_amt_old * 0.12;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Vatable: Silent of Vat - Silent of EWT":         
            
                $gross_amt_old =  $old_terms_contract_rate / 1;
                $add_vat_old =  $gross_amt_old * 0.12;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Non Vatable: Net of VAT - Net of EWT":  
            
                $gross_amt_old =  $old_terms_contract_rate / 0.95;
                $add_vat_old = 0;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Non Vatable: Inclusive of VAT - Inclusive of EWT":         

                $gross_amt_old =  $old_terms_contract_rate / 1;
                $add_vat_old = 0;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Non Vatable: Inclusive of VAT - Exclusive of EWT":         

                $gross_amt_old =  $old_terms_contract_rate / 0.95;
                $add_vat_old = 0;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Non Vatable: Exclusive of VAT - Exclusive of EWT":         

                $gross_amt_old =  $old_terms_contract_rate / 0.95;
                $add_vat_old = 0;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Non Vatable: Exclusive of VAT - Inclusive of EWT":         

                $gross_amt_old =  $old_terms_contract_rate / 1;
                $add_vat_old = 0;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Non Vatable: Silent of VAT - Silent of VAT":         
                
                $gross_amt_old =  $old_terms_contract_rate / 1;
                $add_vat_old = 0;
                $less_ewt_old =  $gross_amt_old * 0.05;
                $net_amt_old = ( $gross_amt_old + $add_vat_old ) - $less_ewt_old;

                break;

            case "Not Applicable":      
                $gross_amt_old = 0;
                $add_vat_old = 0;
                $less_ewt_old =  0;
                $net_amt_old = 0;

                break;

        }

        switch($lessor_demand_tax_application){

            case "Vatable: Net of VAT - Net of EWT":         

                $gross_amt_demand =  $lessor_demand_monthly_contract_amount / 0.95;
                $add_vat_demand =  $gross_amt_demand * 0.12;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Vatable: Inclusive of VAT - Inclusive of EWT":         
            
                $gross_amt_demand =  $lessor_demand_monthly_contract_amount / 1.12;
                $add_vat_demand =  $gross_amt_demand * 0.12;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Vatable: Inclusive of VAT - Exclusive of EWT":     

                $gross_amt_demand =  $lessor_demand_monthly_contract_amount / 1.07;
                $add_vat_demand =  $gross_amt_demand * 0.12;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Vatable: Exclusive of VAT - Exclusive of EWT":         
            
                $gross_amt_demand =  $old_terms_contract_rate / 0.95;
                $add_vat_demand =  $gross_amt_demand * 0.12;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;


                break;

            case "Vatable: Exclusive of VAT - Inclusive of EWT":         
            
                $gross_amt_demand =  $old_terms_contract_rate / 1;
                $add_vat_demand =  $gross_amt_demand * 0.12;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Vatable: Silent of Vat - Silent of EWT":         
            
                $gross_amt_demand =  $old_terms_contract_rate / 1;
                $add_vat_demand =  $gross_amt_demand * 0.12;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Non Vatable: Net of VAT - Net of EWT":  
            
                $gross_amt_demand =  $old_terms_contract_rate / 0.95;
                $add_vat_demand = 0;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Non Vatable: Inclusive of VAT - Inclusive of EWT":         

                $gross_amt_demand =  $old_terms_contract_rate / 1;
                $add_vat_demand = 0;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Non Vatable: Inclusive of VAT - Exclusive of EWT":         

                $gross_amt_demand =  $old_terms_contract_rate / 0.95;
                $add_vat_demand = 0;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Non Vatable: Exclusive of VAT - Exclusive of EWT":         

                $gross_amt_demand =  $old_terms_contract_rate / 0.95;
                $add_vat_demand = 0;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Non Vatable: Exclusive of VAT - Inclusive of EWT":         

                $gross_amt_demand =  $old_terms_contract_rate / 1;
                $add_vat_demand = 0;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Non Vatable: Silent of VAT - Silent of VAT":         
                
                $gross_amt_demand =  $old_terms_contract_rate / 1;
                $add_vat_demand = 0;
                $less_ewt_demand =  $gross_amt_demand * 0.05;
                $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

                break;

            case "Not Applicable":      

                $gross_amt_demand = 0;
                $add_vat_demand = 0;
                $less_ewt_demand =  0;
                $net_amt_demand = 0;

                break;

        }

        switch($new_terms_tax_application){

            case "Vatable: Net of VAT - Net of EWT":         

                $amount_used = 'Gross to Gross';

                $gross_amt_new =  $new_terms_contract_rate / 0.95;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Vatable: Inclusive of VAT - Inclusive of EWT":    

            $amount_used = 'Gross to Gross';

                $gross_amt_new =  $new_terms_contract_rate / 1.12;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Vatable: Inclusive of VAT - Exclusive of EWT":    

                $amount_used = 'Net to Net';

                $gross_amt_new =  $new_terms_contract_rate / 1.07;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Vatable: Exclusive of VAT - Exclusive of EWT":    
                
                $amount_used = 'Gross to Gross';

                $gross_amt_new =  $new_terms_contract_rate / 0.95;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Vatable: Exclusive of VAT - Inclusive of EWT":      

                $amount_used = 'Gross to Gross';

                $gross_amt_new =  $new_terms_contract_rate / 1;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Vatable: Silent of Vat - Silent of EWT":     

                $amount_used = 'Gross to Gross';

                $gross_amt_new =  $new_terms_contract_rate / 1;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Non Vatable: Net of VAT - Net of EWT":       

                $amount_used = 'Net to Net';

                $gross_amt_new =  $new_terms_contract_rate / 0.95;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Non Vatable: Inclusive of VAT - Inclusive of EWT":     

            $amount_used = 'Gross to Gross';

                $gross_amt_new =  $new_terms_contract_rate / 1;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Non Vatable: Inclusive of VAT - Exclusive of EWT":     

            $amount_used = 'Net to Net';

                $gross_amt_new =  $new_terms_contract_rate / 0.95;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Non Vatable: Exclusive of VAT - Exclusive of EWT":   

                $amount_used = 'Net to Net';

                $gross_amt_new =  $new_terms_contract_rate / 0.95;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Non Vatable: Exclusive of VAT - Inclusive of EWT":     

            $amount_used = 'Gross to Gross';

                $gross_amt_new =  $new_terms_contract_rate / 1;
                $add_vat_new =  $gross_amt_new * 0.12;
                $less_ewt_new =  $gross_amt_new * 0.05;
                $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

                break;

            case "Non Vatable: Silent of VAT - Silent of VAT":      

                $amount_used = 'Gross to Gross';

                $gross_amt_new =  $new_terms_contract_rate /  1;
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


        if($amount_used == 'Gross to Gross'){
            $old_renewal_rate = $gross_amt_old;
            $demand_renewal_rate = $gross_amt_demand;
            $new_renewal_rate = $gross_amt_new;
        }
        elseif($amount_used == 'Net to Net'){
            $old_renewal_rate = $net_amt_old;
            $demand_renewal_rate = $net_amt_demand;
            $new_renewal_rate = $net_amt_new;
        }
        elseif($amount_used == 'Not Applicable'){
            $old_renewal_rate = 0;
            $demand_renewal_rate = 0;
            $new_renewal_rate = 0;
        }

        @endphp

        <style>
            td, th {
                font-size: 12px;
            }
        </style>
        
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm" style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>Type of Lessor</th>
                            <th>Tax Application (VAT/EWT)</th>
                            <th>Contract Rate</th>
                            <th>Gross Amt</th>
                            <th>Add: 12% VAT</th>
                            <th>Less: 5% EWT</th>
                            <th>Net Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Old Terms:</td>
                            <td>{{ $old_terms_tax_application }}</td>
                            <td style="text-align: center;">{{ number_format($old_terms_contract_rate, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($gross_amt_old, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($add_vat_old, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($less_ewt_old, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($net_amt_old, 2) }}</td>

                        </tr>
                        <tr>
                            <td>Lessors Demand: </td>
                            <td>{{ $lessor_demand_tax_application }}</td>
                            <td style="text-align: center;">{{ number_format($lessor_demand_monthly_contract_amount, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($gross_amt_demand, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($add_vat_demand, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($less_ewt_demand, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($net_amt_demand, 2) }}</td>

                        </tr>
                        <tr>
                            <td>New Terms: </td>
                            <td>{{ $new_terms_tax_application }}</td>
                            <td style="text-align: center;">{{ number_format($new_terms_contract_rate, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($gross_amt_new, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($add_vat_new, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($less_ewt_new, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($net_amt_new, 2) }}</td>

                        </tr>
                        <tr>
                            <td>*Amount Used:</td>
                            <td>{{ $amount_used }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive mt-3" style="margin: 20px 0px;">
                <table class="table table-bordered table-hover summary_table table-striped" style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th rowspan="1" colspan="3">Renewal Rate</th>
                            <th rowspan="1" colspan="2">{{ number_format($old_renewal_rate, 2) }}</th>
                            <th rowspan="1" colspan="2">{{ number_format($demand_renewal_rate, 2) }}</th>
                            <th rowspan="1" colspan="2">{{ number_format($new_renewal_rate, 2) }}</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th rowspan="1" colspan="3">Annual Escalation</th>
                            <th rowspan="1" colspan="2">{{ number_format($old_escalation_rate * 100, 2) }} %</th>
                            <th rowspan="1" colspan="2">{{ number_format($demand_escalation_rate * 100, 2) }} %</th>
                            <th rowspan="1" colspan="2">{{ number_format($new_escalation_rate * 100, 2) }} %</th>
                            <th></th>
                        </tr>

                        <tr>
                            <th rowspan="2">Yrs</th>
                            <th rowspan="2" colspan="2">Period</th>
                            <th colspan="2">Per Contract</th>
                            <th colspan="2">Lessor Demand</th>
                            <th colspan="2">New Terms</th>
                            <th colspan="2">Savings</th>
                        </tr>
                        <tr>
                            <th>Monthly</th>
                            <th>Annual</th>
                            <th>Monthly</th>
                            <th>Annual</th>
                            <th>Monthly</th>
                            <th>Annual</th>
                            <th>Full Term</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $per_contract_monthly = 0;
                            $running_per_contract_monthly = 0;

                            $demand_monthly = 0;
                            $running_demand_monthly = 0;

                            $new_monthly = 0;
                            $running_new_monthly = 0;

                            $per_contract_yearly_total = 0;
                            $demand_yearly_total = 0;
                            $new_yearly_total = 0;
                            $savings_yearly_total = 0;

                        @endphp

                        {{-- @for ($i = 0; $i < $lease_term_years; $i++) --}}
                        @for ($i = 0; $i < $lease_term_years; $i++)

                        @php
                            // $dtStart = new DateTime($new_terms_start_date);
                            // $dtStart->modify('+' . $i .' years');

                            $dtStart = Carbon::parse($new_terms_start_date)->addYears($i);
                            // $dtEnd = new DateTime($end_date);

                            // $dtEnd = new DateTime($dtStart);
                            // $dtEnd->modify('+' . $i .' years');
                            // $dtEnd->modify('-1 day');

                            $dtEnd = Carbon::parse($dtStart)->addYear()->subDay();

                            if($amount_used === "Gross to Gross"){
                                $amount_old = $gross_amt_old;
                                $amount_demand = $gross_amt_demand;
                                $amount_new = $gross_amt_new;
                            }
                            elseif($amount_used === "Net to Net"){
                                $amount_old = $net_amt_old;
                                $amount_demand = $net_amt_demand;
                                $amount_new = $net_amt_new;
                            }
                            elseif($amount_used === "Not Applicable"){
                                $amount_old = $net_amt_old;
                                $amount_demand = $net_amt_demand;
                                $amount_new = $net_amt_new;
                            }

                            if($per_contract_monthly == 0){
                                $per_contract_monthly = ($old_escalation_rate * $amount_old) + $amount_old;
                                $running_per_contract_monthly  = $per_contract_monthly ;
                            } else {

                                $running_per_contract_monthly = ($running_per_contract_monthly * $old_escalation_rate) + $running_per_contract_monthly;
                            }

                            if($demand_monthly == 0){

                                if($i < $lessor_demand_escalation_year){
                                    $demand_monthly = $amount_demand;
                                } else {
                                    $demand_monthly = ($demand_escalation_rate * $amount_demand) + $amount_demand;
                                }

                                $running_demand_monthly  = $demand_monthly ;

                            } else {


                                if($i >= $lessor_demand_escalation_year){
                                    $running_demand_monthly = ($running_demand_monthly * $demand_escalation_rate) + $running_demand_monthly;

                                } else {
                                    $running_demand_monthly = $running_demand_monthly;
                                }
                                


                            }

                            if($new_monthly == 0){

                                if($i < $new_terms_escalation_year){
                                    $new_monthly = $amount_new;
                                } else {
                                    $new_monthly = ($new_escalation_rate * $amount_new) + $amount_new;
                                }

                                $running_new_monthly  = $new_monthly ;

                            } else {

                                if($i >= $new_terms_escalation_year){
                                    $running_new_monthly = ($running_new_monthly * $new_escalation_rate) + $running_new_monthly;

                                } else {
                                    $running_new_monthly = $running_new_monthly;
                                }
                            }


                            $per_contract_yearly_total = $per_contract_yearly_total + ($running_per_contract_monthly * 12);
                            $demand_yearly_total = $demand_yearly_total + ($running_demand_monthly * 12);
                            $new_yearly_total = $new_yearly_total + ($running_new_monthly * 12);
                            
                            $savings_yearly_total = $per_contract_yearly_total - $new_yearly_total;

                        @endphp
                        <tr>
                            <td class="text-center font-weight-bold"> {{ $i+1 }}</td>
                            <td>{{ $dtStart->format('Y-m-d') }}</td>
                            <td>{{ $dtEnd->format('Y-m-d') }}</td>
                            <td style="text-align: center;">{{ number_format($running_per_contract_monthly, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($running_per_contract_monthly * 12, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($running_demand_monthly, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($running_demand_monthly * 12, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($running_new_monthly, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($running_new_monthly * 12, 2) }}</td>
                            <td style="text-align: center;" class="font-weight-bold text-right">{{ number_format(($running_per_contract_monthly * 12) - ($running_new_monthly *12), 2) }}</td>
                        </tr>
                            
                        @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th colspan="2">{{ number_format($per_contract_yearly_total, 2) }}</th>
                            <th colspan="2">{{ number_format($demand_yearly_total, 2) }}</th>
                            <th colspan="2">{{ number_format($new_yearly_total, 2) }}</th>
                            <th colspan="1">{{ number_format($savings_yearly_total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-hover table-sm table-striped summary_exdeal_table" style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th rowspan="2">Other Consideration</th>
                            <th colspan="2">Per Contract</th>
                            <th colspan="2">Lessor Demand</th>
                            <th colspan="2">New Terms</th>
                            <th>Savings</th>
                        </tr>
                        <tr>
                            <th>Particulars</th>
                            <th>Total Amt</th>
                            <th>Particulars</th>
                            <th>Total Amt</th>
                            <th>Particulars</th>
                            <th>Total Amt</th>
                            <th>Full Term</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Handset</td>
                            @if($old_exdeal_request == 'HANDSET')
                                <td>{{ $old_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($old_exdeal_request == 'HANDSET')
                                <td style="text-align: center;">{{ number_format($old_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($lessor_demand_exdeal_request == 'HANDSET')
                                <td>{{ $lessor_demand_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($lessor_demand_exdeal_request == 'HANDSET')
                                <td style="text-align: center;">{{ number_format($lessor_demand_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($new_terms_exdeal_request == 'HANDSET')
                                <td>{{ $new_terms_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($new_terms_exdeal_request == 'HANDSET')
                                <td style="text-align: center;">{{ number_format($new_terms_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            <td> - </td>
                        </tr>
                        <tr>
                            <td>OTP</td>
                            @if($old_exdeal_request == 'OTP')
                                <td>{{ $old_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($old_exdeal_request == 'OTP')
                                <td style="text-align: center;">{{ number_format($old_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($lessor_demand_exdeal_request == 'OTP')
                                <td>{{ $lessor_demand_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($lessor_demand_exdeal_request == 'OTP')
                                <td style="text-align: center;">{{ number_format($lessor_demand_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($new_terms_exdeal_request == 'OTP')
                                <td>{{ $new_terms_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($new_terms_exdeal_request == 'OTP')
                                <td style="text-align: center;">{{ number_format($new_terms_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            <td> - </td>
                        </tr>
                        <tr>
                            <td>Plan</td>
                            @if($old_exdeal_request == 'PLAN')
                                <td>{{ $old_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($old_exdeal_request == 'PLAN')
                                <td style="text-align: center;">{{ number_format($old_exdeal_amount, 2) }}</td>
                            @else
                                <td></td>
                            @endif
                            @if($lessor_demand_exdeal_request == 'PLAN')
                                <td>{{ $lessor_demand_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($lessor_demand_exdeal_request == 'PLAN')
                                <td style="text-align: center;">{{ number_format($lessor_demand_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($new_terms_exdeal_request == 'PLAN')
                                <td>{{ $new_terms_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($new_terms_exdeal_request == 'PLAN')
                                <td style="text-align: center;">{{ number_format($new_terms_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            <td> - </td>
                        </tr>
                        <tr>
                            <td>Others</td>
                            @if($old_exdeal_request == 'OTHERS')
                                <td>{{ $old_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($old_exdeal_request == 'OTHERS')
                                <td style="text-align: center;">{{ number_format($old_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($lessor_demand_exdeal_request == 'OTHERS')
                                <td>{{ $lessor_demand_exdeal_particulars}}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($lessor_demand_exdeal_request == 'OTHERS')
                                <td style="text-align: center;">{{ number_format($lessor_demand_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            @if($new_terms_exdeal_request == 'OTHERS')
                                <td>{{ $new_terms_exdeal_particulars}}</td>
                            @else
                                <td> - </td>
                            @endif
                            @if($new_terms_exdeal_request == 'OTHERS')
                                <td style="text-align: center;">{{ number_format($new_terms_exdeal_amount, 2) }}</td>
                            @else
                            <td> - </td>
                            @endif
                            <td> - </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th></th>
                            <th style="text-align: center;">{{ number_format($old_exdeal_amount, 2) }}</th>
                            <th></th>
                            <th style="text-align: center;">{{ number_format($lessor_demand_exdeal_amount, 2) }}</th>
                            <th></th>
                            <th style="text-align: center;">{{ number_format($new_terms_exdeal_amount, 2) }}</th>
                            <th style="text-align: center;">{{ number_format($old_exdeal_amount - $new_terms_exdeal_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>

</html>

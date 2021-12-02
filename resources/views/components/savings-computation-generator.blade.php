@php

$lease_term_years = (int)$lease_term;

$old_terms_escalation_rate = 0.03;
$lessor_demand_escalation_rate = 0.04;
$new_escalation_rate = 0.04;

    

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

        $gross_amt_demand =  $lessor_demand_contract_rate / 0.95;
        $add_vat_demand =  $gross_amt_demand * 0.12;
        $less_ewt_demand =  $gross_amt_demand * 0.05;
        $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

        break;

    case "Vatable: Inclusive of VAT - Inclusive of EWT":         
    
        $gross_amt_demand =  $lessor_demand_contract_rate / 1.12;
        $add_vat_demand =  $gross_amt_demand * 0.12;
        $less_ewt_demand =  $gross_amt_demand * 0.05;
        $net_amt_demand = ( $gross_amt_demand + $add_vat_demand ) - $less_ewt_demand;

        break;

    case "Vatable: Inclusive of VAT - Exclusive of EWT":     

        $gross_amt_demand =  $lessor_demand_contract_rate / 1.07;
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

        $gross_amt_new =  $new_terms__contract_rate / 0.95;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Vatable: Inclusive of VAT - Inclusive of EWT":    

    $amount_used = 'Gross to Gross';

        $gross_amt_new =  $new_terms__contract_rate / 1.12;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Vatable: Inclusive of VAT - Exclusive of EWT":    

        $amount_used = 'Net to Net';

        $gross_amt_new =  $new_terms__contract_rate / 1.07;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Vatable: Exclusive of VAT - Exclusive of EWT":    
         
        $amount_used = 'Gross to Gross';

        $gross_amt_new =  $new_terms__contract_rate / 0.95;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Vatable: Exclusive of VAT - Inclusive of EWT":      

        $amount_used = 'Gross to Gross';

        $gross_amt_new =  $new_terms__contract_rate / 1;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Vatable: Silent of Vat - Silent of EWT":     

        $amount_used = 'Gross to Gross';

        $gross_amt_new =  $new_terms__contract_rate / 1;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Non Vatable: Net of VAT - Net of EWT":       

        $amount_used = 'Net to Net';

        $gross_amt_new =  $new_terms__contract_rate / 0.95;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Non Vatable: Inclusive of VAT - Inclusive of EWT":     

    $amount_used = 'Gross to Gross';

        $gross_amt_new =  $new_terms__contract_rate / 1;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Non Vatable: Inclusive of VAT - Exclusive of EWT":     

    $amount_used = 'Net to Net';

        $gross_amt_new =  $new_terms__contract_rate / 0.95;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Non Vatable: Exclusive of VAT - Exclusive of EWT":   

        $amount_used = 'Net to Net';

        $gross_amt_new =  $new_terms__contract_rate / 0.95;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Non Vatable: Exclusive of VAT - Inclusive of EWT":     

    $amount_used = 'Gross to Gross';

        $gross_amt_new =  $new_terms__contract_rate / 1;
        $add_vat_new =  $gross_amt_new * 0.12;
        $less_ewt_new =  $gross_amt_new * 0.05;
        $net_amt_new = ( $gross_amt_new + $add_vat_new ) - $less_ewt_new;

        break;

    case "Non Vatable: Silent of VAT - Silent of VAT":      

        $amount_used = 'Gross to Gross';

        $gross_amt_new =  $new_terms__contract_rate /  1;
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

<style>
    td, th {
        font-size: 12px;
    }
</style>
<div class="col-12">
    {{-- <h6>If there is a change of Tax Application:</h6> --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th class="text-center">Type of Lessor</th>
                    <th class="text-center">Tax Application (VAT/EWT)</th>
                    <th class="text-center">Contract Rate</th>
                    <th class="text-center">Gross Amt</th>
                    <th class="text-center">Add: 12% VAT</th>
                    <th class="text-center">Less: 5% EWT</th>
                    <th class="text-center">Net Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Old Terms:</td>
                    <td class="text-center">{{ $old_terms_tax_application }}</td>
                    <td class="text-right">{{ number_format($old_terms_contract_rate, 2) }}</td>
                    <td class="text-right">{{ number_format($gross_amt_old, 2) }}</td>
                    <td class="text-right">{{ number_format($add_vat_old, 2) }}</td>
                    <td class="text-right">{{ number_format($less_ewt_old, 2) }}</td>
                    <td class="text-right">{{ number_format($net_amt_old, 2) }}</td>

                </tr>
                <tr>
                    <td>Lessors Demand: </td>
                    <td class="text-center">{{ $lessor_demand_tax_application }}</td>
                    <td class="text-right">{{ number_format($lessor_demand_contract_rate, 2) }}</td>
                    <td class="text-right">{{ number_format($gross_amt_demand, 2) }}</td>
                    <td class="text-right">{{ number_format($add_vat_demand, 2) }}</td>
                    <td class="text-right">{{ number_format($less_ewt_demand, 2) }}</td>
                    <td class="text-right">{{ number_format($net_amt_demand, 2) }}</td>

                </tr>
                <tr>
                    <td>New Terms: </td>
                    <td class="text-center">{{ $new_terms_tax_application }}</td>
                    <td class="text-right">{{ number_format($new_terms__contract_rate, 2) }}</td>
                    <td class="text-right">{{ number_format($gross_amt_new, 2) }}</td>
                    <td class="text-right">{{ number_format($add_vat_new, 2) }}</td>
                    <td class="text-right">{{ number_format($less_ewt_new, 2) }}</td>
                    <td class="text-right">{{ number_format($net_amt_new, 2) }}</td>

                </tr>
                <tr>
                    <td>*Amount Used:</td>
                    <td class="text-center">{{ $amount_used }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive mt-3">
        <table class="table table-bordered table-hover summary_table table-striped">
            <thead>
                <tr>
                    <th rowspan="1" colspan="3" class="text-center">Renewal Rate</th>
                    <th rowspan="1" colspan="2" class="text-center"></th>
                    <th rowspan="1" colspan="2" class="text-center"></th>
                    <th rowspan="1" colspan="2" class="text-center"></th>
                    <th rowspan="1" colspan="1" class="text-center"></th>
                </tr>
                <tr>
                    <th rowspan="1" colspan="3" class="text-center">Annual Escalation</th>
                    <th rowspan="1" colspan="2" class="text-center"></th>
                    <th rowspan="1" colspan="2" class="text-center"></th>
                    <th rowspan="1" colspan="2" class="text-center"></th>
                    <th rowspan="1" colspan="1" class="text-center"></th>
                </tr>

                <tr>
                    <th rowspan="2" class="text-center">Yrs</th>
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

                @for ($i = 0; $i < $lease_term_years; $i++)

                @php
                    $dtStart = new DateTime($start_date);
                    $dtStart->modify('+' . $i .' years');
                    $dtEnd = new DateTime($end_date);
                    $dtEnd->modify('+' . $i .' years');
                    $dtEnd->modify('-1 day');

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
                        $per_contract_monthly = ($old_terms_escalation_rate * $amount_old) + $amount_old;
                        $running_per_contract_monthly  = $per_contract_monthly ;
                    } else {

                        $running_per_contract_monthly = ($running_per_contract_monthly * $old_terms_escalation_rate) + $running_per_contract_monthly;
                    }

                    if($demand_monthly == 0){

                        if($i < $escalation_year){
                            $demand_monthly = $amount_demand;
                        } else {
                            $demand_monthly = ($lessor_demand_escalation_rate * $amount_demand) + $amount_demand;
                        }

                        $running_demand_monthly  = $demand_monthly ;

                    } else {


                        if($i >= $escalation_year){
                            $running_demand_monthly = ($running_demand_monthly * $lessor_demand_escalation_rate) + $running_demand_monthly;

                        } else {
                            $running_demand_monthly = $running_demand_monthly;
                        }
                        


                    }

                    if($new_monthly == 0){

                        if($i < $escalation_year){
                            $new_monthly = $amount_new;
                        } else {
                            $new_monthly = ($new_escalation_rate * $amount_new) + $amount_new;
                        }

                        $running_new_monthly  = $new_monthly ;

                    } else {

                        if($i >= $escalation_year){
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
                    <td class="text-right">{{ number_format($running_per_contract_monthly, 2) }}</td>
                    <td class="text-right">{{ number_format($running_per_contract_monthly * 12, 2) }}</td>
                    <td class="text-right">{{ number_format($running_demand_monthly, 2) }}</td>
                    <td class="text-right">{{ number_format($running_demand_monthly * 12, 2) }}</td>
                    <td class="text-right">{{ number_format($running_new_monthly, 2) }}</td>
                    <td class="text-right">{{ number_format($running_new_monthly * 12, 2) }}</td>
                    <td class="font-weight-bold text-right">{{ number_format(($running_per_contract_monthly * 12) - ($running_new_monthly *12), 2) }}</td>
                </tr>
                    
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th colspan="2" class="text-right">{{ number_format($per_contract_yearly_total, 2) }}</th>
                    <th colspan="2" class="text-right">{{ number_format($demand_yearly_total, 2) }}</th>
                    <th colspan="2" class="text-right">{{ number_format($new_yearly_total, 2) }}</th>
                    <th colspan="1" class="text-right">{{ number_format($savings_yearly_total, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-hover summary_exdeal_table">
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
                    <th>Total Amt</th>
                    <th>Particulars</th>
                    <th>Total Amt</th>
                    <th>Particulars</th>
                    <th>Total Amt</th>
                    <th>Full Term</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <button class="btn btn-lg btn-shadow btn-primary back_to_form pull-right">Generate and Upload</button>
    <button class="btn btn-lg btn-shadow btn-secondary back_to_form pull-right mr-1">Edit Details</button>
</div>
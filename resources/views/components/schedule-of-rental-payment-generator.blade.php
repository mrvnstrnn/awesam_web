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

<div class="col-12">

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-hover summary_table table-striped">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">Tax Application</th>
                    <th colspan="5" class="text-left">{{ $new_terms_tax_application }}</th>
                </tr>
                <tr>
                    <th class="text-center">Yrs</th>
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
                    // $dtStart = new DateTime($new_terms_start_date);
                    // $dtStart->modify('+' . $i .' years');
                    // $dtEnd = new DateTime($new_terms_start_date);
                    // $dtEnd->modify('+' . $i .' years');
                    // $dtEnd->modify('-1 day');

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
                        <td class="text-right">{{ number_format($running_new_monthly,2) }}</td>
                        <td class="text-right">{{ number_format($running_new_monthly * 0.12, 2) }}</td>
                        <td class="text-right">{{ number_format($running_new_monthly * 0.05,2) }}</td>
                        <td class="text-right">{{ number_format($running_new_monthly + ($running_new_monthly * 0.12) + ($running_new_monthly * 0.05) ,2) }}</td>
                    </tr>
                    
                @endfor
            </tbody>
        </table>
    </div>
    <button class="btn btn-lg btn-shadow btn-primary pull-right mb-4 save_computation">Generate and Upload</button>
    <button class="btn btn-lg btn-shadow btn-secondary back_to_form pull-right mb-4 mr-1">Edit Details</button>
</div>
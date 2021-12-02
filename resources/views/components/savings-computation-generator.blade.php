@php

$lease_term_years = (int)$lease_term;


$amount_used = '';

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
                    <th class="text-center">Add: 12% VAT</th>
                    <th class="text-center">Less: 5% EWT</th>
                    <th class="text-center">Net Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Old Terms:</td>
                    <td class="text-center">{{ $old_terms_tax_application }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Lessors Demand: </td>
                    <td class="text-center">{{ $lessor_demand_tax_application }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>New Terms: </td>
                    <td class="text-center">{{ $new_terms_tax_application }}</td>
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
    </div>
    
    <div class="table-responsive mt-3">
        <table class="table table-bordered table-hover summary_table">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center">Years</th>
                    <th rowspan="2" colspan="" class="text-center">Period</th>
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
                @for ($i = 1; $i <= $lease_term_years; $i++)
                <tr>
                    <td class="text-center"> {{ $i }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                    
                @endfor
            </tbody>
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
<html>
    <head>
        <title>LRN</title>
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

                p {
                    font-size: 12px;
                }

        </style>
    </head>
    <body>
        @php
            //////////////////////
            // One Time Payment //
            //////////////////////

            $json = json_decode($json_data);

            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

            if ($json->company == 'BAYANTEL') {
                $company_name = "BAYAN TELECOMMUNICATIONS, INC.";
            } elseif ($json->company == 'INNOVE') {
                $company_name = "INNOVE COMMUNICATIONS, INC.";
            } else if ($json->company == 'GLOBE') {
                $company_name = "GLOBE TELECOM, INC.";
            }

            switch($json->new_terms_tax_application){

                case "Vatable: Net of VAT - Net of EWT":         

                    $tax1 = "Net";
                    $tax2 = "Net";

                    break;

                case "Vatable: Inclusive of VAT - Inclusive of EWT":         

                    $tax1 = "Inclusive";
                    $tax2 = "Inclusive";

                    break;

                case "Vatable: Inclusive of VAT - Exclusive of EWT":            

                    $tax1 = "Inclusive";
                    $tax2 = "Exclusive";

                    break;

                case "Vatable: Exclusive of VAT - Exclusive of EWT":         

                    $tax1 = "Exclusive";
                    $tax2 = "Exclusive";

                    break;

                case "Vatable: Exclusive of VAT - Inclusive of EWT":         

                    $tax1 = "Exclusive";
                    $tax2 = "Inclusive";

                    break;

                case "Vatable: Silent of Vat - Silent of EWT":         

                    $tax1 = "Silent";
                    $tax2 = "Silent";

                    break;

                case "Non Vatable: Net of VAT - Net of EWT":  

                    $tax1 = "Net";
                    $tax2 = "Net";

                    break;

                case "Non Vatable: Inclusive of VAT - Inclusive of EWT":         

                    $tax1 = "Inclusive";
                    $tax2 = "Inclusive";

                    break;

                case "Non Vatable: Inclusive of VAT - Exclusive of EWT":         

                    $tax1 = "Inclusive";
                    $tax2 = "Exclusive";

                    break;

                case "Non Vatable: Exclusive of VAT - Exclusive of EWT":         

                    $tax1 = "Exclusive";
                    $tax2 = "Exclusive";

                    break;

                case "Non Vatable: Exclusive of VAT - Inclusive of EWT":         

                    $tax1 = "Exclusive";
                    $tax2 = "Inclusive";

                    break;

                case "Non Vatable: Silent of VAT - Silent of VAT":         
                    
                    $tax1 = "Silent";
                    $tax2 = "Silent";

                    break;

                case "Not Applicable":      
                    $tax1 = "NA";
                    $tax2 = "NA";

                    break;

            }
        @endphp
        <div id="content">

            <table style="width: 100%; margin-top: 0px; margin-bottom: 10px;">
                <tr>
                    <td style="width: 100%; text-align: left;">
                        <img src="globe-logo.png" width="100px">
                    </td>
                </tr>
            </table>

            @if ($json->company != 'Globe')
                <table style="width: 100%; margin-top: 0px;">
                    <tr>
                        <td style="width: 100%; text-align: left;">
                            @if ($json->company == 'BAYANTEL')
                            <p style="margin-bottom: 0px; margin-top: 0px;">BAYAN TELECOMMUNICATIONS, INC.</p>
                            @elseif ($json->company == 'INNOVE')
                            <p style="margin-bottom: 0px; margin-top: 0px;">INNOVE COMMUNICATIONS, INC.</p>
                            @endif
                        </td>
                    </tr>
                </table>
            @endif

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%; text-align: left;">
                        <p style="margin-bottom: 0px;">Date: {{ \Carbon::now()->toDateString() }}</p>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%; text-align: left;">
                        <p style="margin-bottom: 0px;">Vendor's Name: {{ $json->vendor }}</p>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%; text-align: left;">
                        <p style="margin-bottom: 0px;">Representative: {{ $json->representative }}</p>
                    </td>
                </tr>
            </table>
            
            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%; text-align: center;">
                        <p><b>LEASE RENEWAL NOTICE</b></p>
                    </td>
                </tr>
            </table>

            <table border="0" cellspacing="0" cellpadding="0" style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 30%; text-align: center; border: 1px solid black; padding: 10px;">
                        <p><b>LESSOR/S</b></p>
                    </td>
                    <td style="width: 100%; border: 1px solid black; padding: 10px;">
                        <p>{{ $json->lessor }}</p>
                    </td>
                </tr>
            </table>

            <table border="0" cellspacing="0" cellpadding="0" style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 30%; text-align: center; border: 1px solid black; padding: 10px;">
                        <p><b>LEASED PREMISES</b></p>
                    </td>
                    <td style="width: 100%; border: 1px solid black; padding: 10px;">
                        <p>{{ $json->lease_premises }}</p>
                    </td>
                </tr>
            </table>

            <table border="0" cellspacing="0" cellpadding="0" style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 30%; text-align: center; border: 1px solid black; padding: 10px; margin: 0px;">
                        <p><b>BASIC COMMERCIAL TERMS</b></p>
                    </td>
                    <td style="width: 100%; text-align: left; border: 1px solid black; padding: 10px; margin: 0px;">
                        <p style="text-align: justify; text-justify: inter-word;"><b>A.</b>
                            Term: <span style="text-decoration: underline;">{{ ucwords($f->format( $json->new_lease_terms_in_years )) }}</span> (<span style="text-decoration: underline;">{{ $json->new_lease_terms_in_years }}</span>) years;
                            Commencing on <span style="text-decoration: underline;">{{ date('M d, Y', strtotime($json->new_terms_start_date)) }}</span> to <span style="text-decoration: underline;">{{ date('M d, Y', strtotime('-1 day', strtotime($json->new_terms_end_date))) }}</span>.
                        </p>
                        
                        <p style="text-align: justify; text-justify: inter-word;"><b>B.</b>
                            Consideration: ___________________ (Php___________). 
                            Tax Application: <span style="text-decoration: underline;"><b>{{ strtoupper( $tax1) }}</b></span> of VAT and <span style="text-decoration: underline;"><b>{{ strtoupper( $tax2) }}</b></span> of Withholding Tax.
                        </p>

                        <p style="text-align: justify; text-justify: inter-word;"><b>C.</b>
                            Mode of Payment: <b>One Time Payment</b>.
                        </p>

                        <p style="text-align: justify; text-justify: inter-word;"><b>D.</b>
                            Upon execution of this Renewal Notice and Grantor’s submission of all the documents required by {{ ucwords($company_name) }} (“{{ $json->company }}”), the payment shall be made via bank deposit through the nominated bank account of the Grantor/s.
                        </p>

                        <p style="text-align: justify; text-justify: inter-word;"><b>E.</b>
                            GRANTOR warrants that he/she is the duly registered owner/legal possessor of the Assigned Premises. Further, GRANTOR shall hold {{ $json->company }} free and harmless from any claims and suits related to the GRANTOR’s ownership and possession of the Leased Premises.
                        </p>

                        <p style="text-align: justify; text-justify: inter-word;"><b>F.</b>
                            This Renewal Notice is intended to set the basic terms and conditions of the Memorandum of Agreement (“Agreement”) and shall be binding to the Parties, subject to execution of the said Agreement. Parties agree that any delay in the execution of the Agreement due to fortuitous events, national emergencies or as a consequence of a government order shall be excused. Accordingly, the execution of the Agreement shall be complied with whenever possible.
                        </p>

                        <p style="text-align: justify; text-justify: inter-word;"><b>G.</b>
                            GRANTOR agrees to the collection, processing, use, and sharing of the data that the GRANTOR provides to {{ ucwords($company_name) }} and its representatives through this Lease Renewal Notice for the requirements needed for the Renewal of the Contract of Lease. The GRANTOR understands and recognizes that the collection, processing, use, and sharing of such data, which may include Personal and Sensitive Personal Information, shall be in accordance with the Data Privacy Act of 2012 and the Privacy Policy of {{ ucwords($company_name) }}
                        </p>

                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 40px; margin-bottom: 0px;">
                <tr>
                    <td style="width: 60%;">
                        <p style="margin-bottom: 0px;">Approved by:</p>
                        <p style="margin-top: 0px;"><b>{{ ucwords($company_name) }}</b></p>
                        <p style="margin-top: 40px;">___________________________</p>
                        <p style="margin-top: 0px; margin-top: 0px;"><b>Vincent L. Tempongko</b></p>
                    </td>
                    <td style="width: 40%;">
                        <p style="margin-bottom: 0px;">Conforme:</p>
                        <p style="margin-bottom: 0px; margin-top: 40px;"><span style="text-decoration: underline;">{{ $json->lessor }}</span></p>
                        <p style="margin-top: 0px;"><b>Lessor/s</b></p>
                    </td>
                </tr>
            </table>

        </div>
    </body>
</html>
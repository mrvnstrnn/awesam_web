<html>
    <head>
        <title>LOI to Renew</title>
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

                p, li {
                    font-size: 14px;
                }
        </style>
    </head>
    <body>
        @php
            $json = json_decode($json_data);

            $honorific = "";
            if ( $json->salutation == 'Not Applicable' ) {
                $honorific = "";
                $lessor_surname = $json->lessor;
            } else {
                $surname = explode(" ", $json->lessor);

                $honorific = $json->salutation;
                $lessor_surname = $json->salutation . " " . end($surname);
            }

            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

            if ( $json->terms_in_years > 1 ) {
                $date_word = $f->format($json->terms_in_years) .' ('.$json->terms_in_years.') years';
            } else {
                $date_word = $f->format($json->terms_in_years) .' ('.$json->terms_in_years.') year';
            }

            if ($json->company == 'BAYANTEL') {
                $company_name = "Bayan Telecommunications, Inc.";
            } elseif ($json->company == 'INNOVE') {
                $company_name = "Innove Communications, Inc";
            } else if ($json->company == 'GLOBE') {
                $company_name = "Globe Telecom, Inc.";
            }
        @endphp
        <div id="content">

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%">
                    </td>

                    <td style="width: 100%; text-align: right;">
                        <img src="globe-logo.png" width="200px">
                    </td>
                </tr>
            </table>
            
            <table style="width: 50%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%">
                        <p>{{ \Carbon::now()->format('M d, Y') }}</p>
                        <p style="margin-bottom: 0px;"><b>{{ ucwords(str_replace("&amp;", "and", $json->lessor)) }}</b></p>
                        <p style="margin-bottom: 0px; margin-top: 0px;">{{ $json->lessor_position }}</p>
                        <p style="margin-top: 0px;">{{ $json->lessor_address }}</p>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 0px;">
                <tr>
                    <td style="width: 100%">
                        <p>Dear <b>{{ $honorific ." ". ucwords(strtolower($json->lessor_surname) ) }}</b>,
                        <p style="text-align: justify; text-justify: inter-word;">
                            We are writing on behalf of {{ $company_name }} ({{ ucfirst(strtolower($json->company)) }}) in connection with the existing Contract of
                            Lease of their telecommunications facility located at <b>{{ $json->cell_site_address }}</b> which will expire on <b>{{ $json->expiration_date }}</b>. Please be informed that {{ ucfirst(strtolower($json->company)) }} would like to signify its intent
                            to renew the said Contract of Lease for {{ $date_word }} or from <b>{{ $json->new_terms_start_date }}</b> to <b>{{ $json->new_terms_end_date }}</b>. In
                            line with this, we would like to request for the submission of the following documents which are
                            necessary in the processing of the contract renewal:</p>
                            <ul>
                                <li>Newly issued Certified True Copy of the Transfer Certificate of Title</li>
                                <li>Newly issued Certified True Copy of the Updated Tax Declaration for the land and building</li>
                                <li>Government issued ID of the contract signatory</li>
                                <li>Updated/latest Special Power of Attorney for the authorized Attorney-in-Fact</li>
                            </ul>

                            <p style="text-align: justify; text-justify: inter-word;">
                            However, in case you have other plans for your property and will not consider renewing the contract
                            anymore, we would like to request that {{ ucfirst(strtolower($json->company)) }} be given sufficient time to relocate their
                            telecommunications facilities. Being a public utility company, {{ ucfirst(strtolower($json->company)) }} services are always imbued with
                            public interest wherein it needs to provide seamless coverage as mandated by the National
                            Telecommunications Commission. Thus, they would need at least <b>24 months</b> upon receipt of your
                            formal notification to facilitate the following activities:</p>
                            <ul>
                                <li>Site acquisition for the replacement site</li>
                                <li>Civil and Telecom Works</li>
                                <li>Pull out and dismantling of existing installations</li>
                                <li>Restoration of leased premises</li>
                            </ul>
                            <p style="text-align: justify; text-justify: inter-word;">
                            For further coordination, please get in touch with the undersigned at {{ $json->undersigned_number }}, or at email
                            address {{ $json->undersigned_email }}.</p>

                            <p>Thank you.</p>
                            <p>Very truly yours,</p>
                            {{-- <p style="margin-top: 60px;"><b>{{ $json->signatory }}</b></p>
                            <p style="margin-top: 0px;">{{ $json->signatory_position }}</p> --}}
                            <p style="margin-top: 60px; margin-bottom: 0px;"><b>{{ \Auth::user()->name }}</b></p>
                            {{-- <p style="margin-top: 0px;">{{ \Auth::user()->getUserProfile()->profile }}</p> --}}
                            <p style="margin-top: 0px;">Contract Admin</p>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
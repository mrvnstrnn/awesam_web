@extends('layouts.enrollment')

@section('content')
<style>
    .nda_div p {
        text-align: justify;
    }
</style>
    <div class="row  vw-100 mt-4">
        <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div id="smartwizard" class="sw-main sw-theme-default">
                        <ul class="forms-wizard nav nav-tabs step-anchor">
                            <li class="nav-item step-1-li active">
                                <a href="javascript:void(0)" class="nav-link">
                                    <em>1</em>
                                    <span>User</span>
                                </a>
                            </li>
                            <li class="nav-item step-2-li">
                                <a href="javascript:void(0)" class="nav-link">
                                    <em>2</em>
                                    <span>Photo</span>
                                </a>
                            </li>
                            <li class="nav-item step-3-li">
                                <a href="javascript:void(0)" class="nav-link">
                                    <em>3</em>
                                    <span>NDA</span>
                                </a>
                            </li>
                            <li class="nav-item step-4-li">
                                <a href="javascript:void(0)" class="nav-link">
                                    <em>4</em>
                                    <span>Validation</span>
                                </a>
                            </li>
                        </ul>
                        <div class="form-wizard-content sw-container tab-content d-block" style="min-height: 353px;">
                            <form id="onboardingForm" enctype="multipart/form-data">
                                <div id="step-1" class="tab-pane step-content">
                                    <div class="divider"></div>
                                    <div class="form-row">
                                        <div class="col-4">
                                            <h5>My Details</h5>
                                        </div>
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="firstname">Firstname</label>
                                                        <input name="firstname" id="firstname" type="text" class="form-control" readonly>
                                                        <small class="firstname-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="middlename">Middlename</label>
                                                        <input name="middlename" id="middlename" placeholder="Middle Name" type="text" class="form-control">
                                                        <small class="middlename-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="lastname">Lastname</label>
                                                        <input name="lastname" id="lastname" type="text" class="form-control" readonly>
                                                        <small class="lastname-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="suffix">Suffix</label>
                                                        <select name="suffix" id="suffix"  class="form-control">
                                                            <option  disabled selected>Suffix</option>
                                                            <option value="Sr">Sr</option>
                                                            <option value="Jr">Jr</option>
                                                            <option value="III">III</option>
                                                            <option value="IV">IV</option>
                                                            <option value="V">V</option>
                                                        </select>
                                                        <small class="suffix-error text-danger"></small>
                                                    </div>
                                                </div> 
                                                <div class="divider"></div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="nickname">Nickname</label>
                                                        <input name="nickname" id="nickname" placeholder="Nickname" type="text" class="form-control" required>
                                                        <small class="nickname-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="birthday">Birthday</label>
                                                        <input name="birthday" id="birthday" placeholder="" type="text" class="flatpicker form-control" style="background-color: white;" required>
                                                        <small class="birthday-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="gender">Gender</label>
                                                        <select name="gender" id="gender" class="form-control" required>
                                                            <option  disabled selected>Gender</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                        <small class="gender-error text-danger"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="form-row">
                                        <div class="col-4">
                                            <h5>Contact Information</h5>
                                        </div>
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="email">Email</label>
                                                        <input name="email" id="email" type="email" class="form-control" data-toggle="tooltip" title="You're not be able to change the email." readonly required>
                                                        <small class="email-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="contact_no">Cellphone</label>
                                                        <input name="contact_no" id="contact_no" placeholder="0917-XXX-XXX"  type="text" class="form-control" required>
                                                        <small class="contact_no-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="landline">Landline</label>
                                                        <input name="landline" id="landline" placeholder="Telephone Number"  type="text" class="form-control">
                                                        <small class="landline-error text-danger"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="form-row">
                                        <div class="col-4">
                                            <h5>Address Details</h5>
                                        </div>
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="region">Region</label>
                                                        <select class="form-control" name="address" id="region" autocomplete="off">
                                                            <option >Please select region</option>
                                                            @foreach ($locations as $location)
                                                            <option value="{{ $location->region_id }}">{{ $location->region_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="province">Province</label>
                                                        <select class="form-control" name="address" id="province" disabled required autocomplete="off"></select>
                                                        <small class="designation-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="lgu">City</label>
                                                        <select class="form-control" name="address" id="lgu" disabled required autocomplete="off"></select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="address">Address</label>
                                                        <textarea name="address" id="address" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="form-row">
                                        <div class="col-4">
                                            <h5>Employment Details</h5>
                                        </div>
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="designation">Designation</label>
                                                        @if (\Auth::user()->profile_id != null)
                                                            @if (\Auth::user()->getUserProfile()->mode == "vendor")
                                                                <select name="designation" id="designation"  class="form-control" required>
                                                                    <option  disabled selected>Designation</option>
                                                                    <option value="2">Agent</option>
                                                                    <option value="3">Supervisor</option>
                                                                </select>
                                                            @else
                                                                <input type="text" class="form-control" value="{{ \Auth::user()->getUserProfile()->profile }}" readonly>
                                                                <input type="hidden" name="designation" id="designation" value="{{ \Auth::user()->profile_id }}">
                                                                {{-- <input type="hidden" name="mode" id="mode" value="{{ \Auth::user()->getUserProfile()->mode }}"> --}}
                                                            @endif
                                                        @else
                                                            @php
                                                                $designation = \App\Models\UserDetail::select('designation')
                                                                                        ->where('user_id', \Auth::id()) 
                                                                                        ->first();
                                                            @endphp
                                                                @if (!is_null($designation))
                                                                    @if (!is_null($designation->designation))
                                                                        @php
                                                                            $profile_name = \App\Models\Profile::find($designation->designation);   
                                                                        @endphp

                                                                        <input type="text" class="form-control" value="{{ $profile_name->profile }}" readonly>
                                                                        <input type="hidden" name="designation" id="designation" value="{{ $designation->designation }}">
                                                                    @else
                                                                        <select name="designation" id="designation"  class="form-control" required>
                                                                            <option  disabled selected>Designation</option>
                                                                            <option value="2">Agent</option>
                                                                            <option value="3">Supervisor</option>
                                                                        </select>
                                                                    @endif
                                                                @else
                                                                    <select name="designation" id="designation"  class="form-control" required>
                                                                        <option  disabled selected>Designation</option>
                                                                        <option value="2">Agent</option>
                                                                        <option value="3">Supervisor</option>
                                                                    </select>
                                                                @endif
                                                        @endif
                                                        <small class="designation-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="employment_classification">Employment Classification</label>
                                                        <select name="employment_classification" id="employment_classification"  class="form-control" required>
                                                            <option  disabled selected>Employment Classification</option>
                                                            <option value="regular">Regular</option>
                                                            <option value="subcon">Sub Contractor</option>
                                                        </select>
                                                        <small class="employment_classification-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="employment_status">Employment Status</label>
                                                        <select name="employment_status" id="employment_status"  class="form-control" required>
                                                            <option  disabled selected>Employment Status</option>
                                                            <option value="active">Active</option>
                                                        </select>
                                                        <small class="employment_status-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="hiring_date">Hiring Date</label>
                                                        <input name="hiring_date" id="hiring_date" placeholder="Hiring Date" type="text" class="flatpicker form-control" style="background-color: white;" required>
                                                        
                                                        <small class="hiring_date-error text-danger"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="clearfix">
                                        {{-- <button type="button" id="reset-btn-1" class="btn-shadow float-left btn btn-link reset-btn">Reset</button> --}}
                                        <button type="button" id="next-btn-1" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">Next</button>
                                    </div>
                                </div>                                
                                <div id="step-2" class="tab-pane step-content d-none">
                                    <div class="divider"></div>
                                    <div class="form-row">
                                        <div class="col-4">
                                            <h5>User Photo</h5>
                                        </div>
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">

                                                        <div class="justify-content-center mb-3 upload-take-button">
                                                            <button id="take_photo" type="button" class="btn-shadow mt-3 btn-wide btn btn-primary btn-sm">Take Photo</button>
                                                             or 
                                                            <button id="upload_phto" type="button" class="btn-shadow mt-3 btn-wide btn btn-secondary btn-sm">Upload photo</button>
                                                        </div>

                                                        <div class="d-none upload-photo-div">
                                                            <div class="dropzone"></div>

                                                            <button id="drop_take_photo" type="button" class="btn-shadow mt-3 btn-wide btn btn-primary btn-sm">Take Photo</button>
                                                        </div>

                                                        <div class="d-none webcam-div">
                                                            <label for="player">Webcam Shot</label>
                                                            <video id="player" autoplay style="width:100%"></video>
    
                                                            <canvas id="canvas" class="d-none"></canvas>
    
                                                            <div id="snapshot"></div>
                                                            
                                                            <input type="hidden" name="capture_image">
    
                                                            <button id="shoot_camera" type="button" class="btn-shadow mt-3 btn-wide btn btn-danger btn-sm">Take Photo</button>
    
                                                            <button type="button" id="change_photo" class="btn-shadow mt-3 btn-wide btn btn-primary btn-sm">Change photo</button>

                                                            <button id="web_upload_phto" type="button" class="btn-shadow mt-3 btn-wide btn btn-secondary btn-sm">Upload photo</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="divider"></div>
                                    <div class="clearfix">
                                        {{-- <button type="button" id="reset-btn-2" class="btn-shadow float-left btn btn-link reset-btn">Reset</button> --}}
                                        <button type="button" id="next-btn-2" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">Next</button>
                                        <button type="button" id="prev-btn-2" class="btn-shadow btn-wide mr-2 float-right btn-pill btn-hover-shine btn btn-default">Previous</button>
                                    </div>
                                </div>
                                <div id="step-3" class="tab-pane step-content d-none">
                                    <div class="col-12">
                                        <p class="text-center"><b>MUTUAL CONFIDENTIALITY AND NON-DISCLOSURE AGREEMENT</b></p>
                                        <div style="height: 400px !important; overflow: auto;" class="nda_div">
                                            <div class="row border p-3 m-3">
                                                <div class="col-md-6 col-12">
                                                    <p><b>
                                                        This Mutual Confidentiality and Non-Disclosure Agreement
                                                        (the “Agreement”) is entered into by Globe Telecom, Inc.
                                                        and the Second Party named hereunder (individually the
                                                        “Party” a
                                                    </b></p>

                                                    <p><b>A. Globe</b></p>
                                                    <p>
                                                        <b>GLOBE TELECOM, INC.,</b>a corporation duly organized and
                                                        existing under the laws of the Republic of the Philippines, with
                                                        principal address at The Globe Tower, 32nd Street corner 7th
                                                        Avenue, Bonif
                                                    </p>

                                                    <p><b>B. Second Party</b></p>

                                                    <p>
                                                        __________________________________________________,
                                                        a corporation/partnership/ single proprietorship duly organized
                                                        and existing under the laws of the _______________ with
                                                        address at __________________________________________
                                                        __________________________________________________
                                                        ,
                                                    </p>

                                                    <p><b>C. Description of Potential Transaction</b></p>

                                                    <p>
                                                        __________________________________________________
                                                        __________________________________________________
                                                        (the “<b>Potential Transaction</b>”) 
                                                    </p>

                                                    <p><b>D. Term</b></p>

                                                    <p>
                                                        This Agreement shall expire either three (3) years from the date
                                                        hereof, or upon the termination of the evaluation or pursuit of the
                                                        Potential Transaction, whichever occurs later; provided,
                                                        however, that the Receiving Party’s obligations with respect to
                                                        the Confidential Information shall survive for three (3) years
                                                        following the date of such termination of this Agreement (the
                                                        “Term”) and with respect to Trade Secrets, for as long as such
                                                        Confidential Information is considered a trade secret under the
                                                        applicable law.
                                                    </p>

                                                    <p><b>E. Contract</b></p>

                                                    <p>
                                                        This Agreement and Terms and Conditions stated below
                                                        constitute the entire agreement of the Parties and shall govern
                                                        their relationship.
                                                    </p>

                                                    <p class="text-center"><b>TERMS AND CONDITIONS</b></p>
                                                    
                                                    <p><b>ARTICLE 1 CONFIDENTIAL INFORMATION</b></p>

                                                    <p>
                                                        All communications or data, in any form, whether tangible or
                                                        intangible, which are disclosed or furnished by any director,
                                                        employee, agent, consultant, successor, or assign of any
                                                        department or business area of any Party hereto, including their
                                                        affiliates and subsidiaries, (hereinafter “Disclosing Party”) to the
                                                        other Party, including their affiliates and subsidiaries,
                                                        (hereinafter “Receiving Party”) and which are to be protected
                                                        hereunder against unrestricted disclosure or competitive use by
                                                        the Receiving Party shall be deemed to be “Confidential
                                                        Information”.
                                                    </p>

                                                    
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <p>
                                                        As used herein, the term "Confidential Information" shall mean
                                                        all non-public, confidential or proprietary information disclosed
                                                        hereunder, in any tangible or intangible form, such as but not
                                                        limited to written, oral, visual, audio, those produced by
                                                        electronic media, or through any other means, that is designated
                                                        as confidential or that by its nature or circumstances surrounding
                                                        its disclosure, should be reasonably considered as confidential.
                                                        Confidential Information shall include but not be limited to
                                                        products or planned products, processes and/or procedures,
                                                        technological achievements and interests, customers and
                                                        potential customers, business prospects, financial statements
                                                        and information, financial situation and corporate plans, internal
                                                        activities, future plans of both Parties, and other information
                                                        deemed proprietary or confidential by the Disclosing Party or any
                                                        other matter in which the Disclosing Party may have any interest
                                                        whatsoever.
                                                        Confidential Information shall also include any materials,
                                                        information, processes, plans, and procedures treated by the
                                                        Disclosing Party as, and deemed under applicable law to be,
                                                        trade secrets (“Trade Secrets”).
                                                        Each Disclosing Party hereby represents and warrants to the
                                                        Receiving Party that it has lawful rights to provide the
                                                        Confidential Information. Confidential Information will be
                                                        disclosed either:
                                                        
                                                        <ol style="list-style-type: lower-alpha;">
                                                            <li>in writing,</li>
                                                            <li>by delivery of items,</li>
                                                            <li>by initiation of access to Information, such as
                                                                may be in a database, or</li>
                                                            <li>by oral or visual presentation.</li>
                                                        </ol>
                                                    </p>

                                                    <p>
                                                        Confidential Information should be marked with a restrictive
                                                        legend of the Disclosing Party. If information is not marked with
                                                        such legend or is disclosed orally, the information will be
                                                        identified as confidential at the time of disclosure. Nevertheless,
                                                        if the information is not clearly marked or no disclosure is made,
                                                        the information will be considered confidential if these are clearly
                                                        recognizable as confidential information to a prudent person with
                                                        no special knowledge of the Disclosing Party’s industry.
                                                    </p>

                                                    <p><b>ARTICLE 2 EXCEPTIONS TO THE SCOPE OF CONFIDENTIAL INFORMATION</b></p>

                                                    <p>The term Confidential Information does not include information which:</p>

                                                    <p>
                                                        <ol style="list-style-type: lower-alpha;">
                                                            <li>has been or becomes now or in the future
                                                                published in the public domain without breach of this
                                                                Agreement or breach of a similar agreement by a third
                                                                party; or</li>
                                                            <li>prior to disclosure hereunder, is properly
                                                                within the legitimate possession of the Receiving Party,
                                                                which fact can be proven or verified by independent
                                                                evidence; or</li>

                                                            <li>
                                                                subsequent to disclosure hereunder, is
                                                                lawfully received from a third party having rights therein
                                                                without restriction on the third party's or the Receiving
                                                                Party's rights to disseminate the information and
                                                                without notice of any restriction against its further
                                                                disclosure; or
                                                            </li>
                                                            <li>
                                                                is independently developed by the Receiving
                                                                Party through persons who have not had, either directly
                                                                or indirectly, access to or knowledge of such
                                                                information which can be verified by independent
                                                                evidence; or
                                                            </li>
                                                            <li>
                                                                is disclosed with the written approval of the
                                                                Disclosing Party or after the applicable peri
                                                            </li>
                                                        </ol>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row border p-3 m-3">
                                                <div class="col-md-6 col-12">
                                                    <p><b>ARTICLE 3 DURATION OF THIS AGREEMENT</b></p>

                                                    <p>
                                                        This Agreement is intended to cover Confidential Information
                                                        received by the Receiving Party, both prior to and subsequent to
                                                        the execution of this Agreement and shall be valid for the Term
                                                        stated in Clause D. 
                                                    </p>

                                                    <p><b>ARTICLE 4 RESTRICTIONS ON USE: NO GRANT OF RIGHTS</b></p>

                                                    <p>
                                                        Each Party agrees to use the Confidential Information received
                                                        from the other Party only for the purpose of the Potential
                                                        Transaction stated in Clause C.
                                                    </p>

                                                    <p>
                                                        The Receiving Party agrees, for itself, its subsidiaries, and
                                                        affiliates, and its and their respective directors, employees,
                                                        agents, consultants, successors, and assigns, to (a) hold all
                                                        Confidential Information (regardless of whether it is specifically
                                                        marked confidential or not) in strict confidence; (b) transmit the
                                                        Confidential Information only to its director, employee, agent,
                                                        consultant, successor, and assign on a need to know basis and
                                                        after each one of them has agreed to be bound by confidentiality
                                                        obligations substantially equivalent to the terms and conditions
                                                        of this Agreement and not to disclose the same except as
                                                        provided herein; (c) not to directly or indirectly use, copy, digest,
                                                        or summarize any Confidential Information except as provided
                                                        in this Agreement, and (d) not to disclose any Confidential
                                                        Information to any other party without the prior written consent
                                                        of the Disclosing Party. The Disclosing Party may grant its
                                                        consent for the disclosure of the Confidential Information in its
                                                        sole discretion and on a case-by-case basis. The Receiving
                                                        Party expressly agrees not to use the Confidential Information to
                                                        gain or attempt to gain a competitive advantage over the
                                                        Disclosing Party.
                                                    </p>

                                                    <p>
                                                        If requested by the Disclosing Party, the Receiving Party shall
                                                        acknowledge receipt of any Confidential Information by signing
                                                        receipts, initialing documents, or any other means that the
                                                        Disclosing Party may reasonably request.
                                                    </p>

                                                    <p>
                                                        Except for purposes of the Potential Transaction stated in
                                                        Clause C, the Receiving Party will not permit copies of the
                                                        Confidential Information to be made without the express written
                                                        consent of the Disclosing Party. Copies shall be deemed
                                                        confidential and in all respects subject to the terms and
                                                        conditions of this Agreement.
                                                    </p>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <p>
                                                        No other rights, and particularly no license and no assignment
                                                        of intellectual property right including copyrights, patent rights,
                                                        design rights, trademarks, and mask work, protection, rights are
                                                        implied or granted under this Agreement. Neither Party shall
                                                        make use of the existence of any bilateral business relationship
                                                        between them for the purpose of their own advertisement.
                                                    </p>

                                                    <p><b>ARTICLE 5 PROPERTY OF DISCLOSING PARTY</b></p>

                                                    <p>
                                                        All Confidential Information, unless otherwise specified in
                                                        writing, shall remain the sole and exclusive property of the
                                                        Disclosing Party and shall be used by the Receiving Party only
                                                        for the purpose intended herein, except as may be required by
                                                        applicable law or legal process.  
                                                    </p>

                                                    <p>
                                                        The Receiving Party shall not disclose, reproduce, or
                                                        disseminate such Confidential Information to anyone, except to
                                                        those directors, employees, agents, consultants, successors,
                                                        and assigns (including those of its parent, subsidiaries and
                                                        affiliates) on a need to know basis for purposes of the Potential
                                                        Transaction stated in Clause C. 
                                                    </p>

                                                    <p>
                                                        If the Receiving Party is requested by a government entity or
                                                        other third party to disclose any Confidential Information, it will
                                                        promptly notify the Disclosing Party to allow the latter to seek a
                                                        protective order or take other appropriate action, at the sole cost
                                                        and expense of the Disclosing Party. The Receiving Party will
                                                        also cooperate in the Disclosing Party's efforts to obtain a
                                                        protective order or other reasonable assurance that confidential
                                                        treatment will be afforded the Confidential Information. If in the
                                                        absence of a protective order the Receiving Party is compelled
                                                        as a matter of law to disclose the Confidential Information based
                                                        upon the written opinion of the Receiving Party’s counsel, the
                                                        Receiving Party may disclose to the government entity or other
                                                        third party compelling the disclosure only the part of the
                                                        Confidential Information as required by law to be disclosed.
                                                    </p>

                                                    <p><b>ARTICLE 6 SAFEKEEPING</b></p>

                                                    <p>
                                                        The Receiving Party shall use the same care to avoid disclosure
                                                        or unauthorized use of the Confidential Information as it uses to
                                                        protect its own confidential information, but in no event less than
                                                        reasonable care. It is agreed that:

                                                        
                                                        <ol style="list-style-type: lower-alpha;">
                                                            <li>all Confidential Information shall be retained
                                                                by the Receiving Party in a secure place, and</li>
                                                            <li>
                                                                <p>Confidential Information will be disclosed only
                                                                to each Party’s employees who are involved in the
                                                                Potential Transaction and to agents, consultants,
                                                                successors, and assigns (but not including vendors,
                                                                who shall not be receiving Confidential Information in
                                                                any event) who have been engaged for the purpose of
                                                                discussing the Potential Transaction, which the
                                                                Disclosing Party has prior notice of such engagement;
                                                                provided that in the event of such disclosure to any
                                                                third person or entity not employed or retained by the
                                                                Receiving Party, the Receiving Party shall nonetheless
                                                                remain liable for any unauthorized disclosure by such
                                                                person or entity. 
                                                                </p>
                                                                <p>
                                                                    It is further agreed that the Receiving Party shall ensure that all
                                                                    of its directors, employees, agents, consultants, successors, and
                                                                    assigns (including those of its parent, subsidiaries and affiliates)
                                                                    having access to Confidential Information agree to be bound by
                                                                    confidentiality obligations substantially equivalent to the terms
                                                                    and conditions as set out in this Agreement.
                                                                </p>
                                                            </li>
                                                        </ol>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row border p-3 m-3">
                                                <div class="col-md-6 col-12">
                                                    <p><b>ARTICLE 7 RETURN OF CONFIDENTIAL INFORMATION</b></p>

                                                    <p>
                                                        All Confidential Information, including but not limited to copies,
                                                        summaries, excerpts, extracts or other reproduction thereof,
                                                        shall be returned to the Disclosing Party or destroyed after the
                                                        Receiving Party’s need for it has expired or upon request of the
                                                        Disclosing Party, and in any event, upon termination of this
                                                        Agreement
                                                    </p>

                                                    <p>
                                                        Further, in any event at any time a Receiving Party ceases to
                                                        have an active interest in the Potential Transaction, it will
                                                        immediately return to the Disclosing Party all copies of written,
                                                        taped or audio-visual recorded Confidential Information in its
                                                        possession and shall not retain any such copies.
                                                    </p>

                                                    <p>
                                                        Notwithstanding anything to the contrary contained in this
                                                        Agreement, the Receiving Party may retain a copy of any
                                                        materials (together with necessary supporting documents) that
                                                        the Receiving Party develops for the Disclosing Party for archival
                                                        purposes, provided that the Receiving Party will continue to keep
                                                        such materials and documents confidential in accordance with
                                                        the terms and conditions of this Agreement. 
                                                    </p>

                                                    <p>
                                                        For the avoidance of doubt, the Receiving Party will not be
                                                        required to destroy electronic records automatically backed up in
                                                        the ordinary course of business for disaster recovery purposes.
                                                        Such electronic records shall be kept confidential in accordance
                                                        with the terms and conditions of this Agreement until the time
                                                        these electronic records are destroyed. 
                                                    </p>

                                                    <p><b>ARTICLE 8 NO OBLIGATION TO CONTRACT</b></p>

                                                    <p>
                                                        This Agreement does not constitute a proposal or offer for any
                                                        specific business whatsoever between the Parties, and is only
                                                        intended to bind the Parties to the confidentiality and limited use
                                                        of the Confidential Information.
                                                    </p>

                                                    <p>
                                                        Nothing in this Agreement shall impose any obligation upon
                                                        either Party to consummate a transaction, to enter into any
                                                        discussion or negotiations with respect thereto, or to take any
                                                        other action not expressly agreed to herein. Neither Party shall
                                                        have any obligation to the other Party for any such action the
                                                        other Party may take or refrain from taking based on or otherwise
                                                        attributable to any information (whether or not constituting
                                                        Confidential Information) furnished to such other Party
                                                        hereunder.                                                        
                                                    </p>

                                                    <p><b>ARTICLE 9 REMEDY AGAINST DEFAULTING PARTY</b></p>

                                                    <p>
                                                        The Parties acknowledge and agree that disclosure, divulgence,
                                                        or unauthorized use of the Confidential Information could
                                                        damage the Disclosing Party and that such Disclosing Party,
                                                        therefore, has a strong interest in protecting the Confidential
                                                        Information by all legal means.
                                                    </p>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <p>
                                                        A Party violating its obligations under this Agreement shall be
                                                        responsible to the other Party for all damages directly caused by
                                                        such breach. Moreover, because money damages may not be a
                                                        sufficient remedy for any breach of the foregoing covenants and
                                                        agreements, the Disclosing Party shall be entitled to resort to
                                                        specific performance and injunctive and other equitable relief as
                                                        a remedy for any such breach of this Agreement in addition to all
                                                        monetary or other remedies available at law or in equity.
                                                    </p>

                                                    <p><b>ARTICLE 10 NO REPRESENTATION OR WARRANTY</b></p>

                                                    <p>
                                                        The Disclosing Party makes no representation or warranty as to
                                                        the accuracy or completeness of the Confidential Information
                                                        and the Receiving Party agrees that the Disclosing Party and its
                                                        employees and agents shall have no liability to the Receiving
                                                        Party resulting from any use of the Confidential Information.
                                                    </p>
                                                    
                                                    <p>
                                                        However, this disclaimer shall, in and of itself, not apply to or limit
                                                        any specific warranties that the Disclosing Party may expressly
                                                        give in other agreements between the Disclosing Party and the
                                                        Receiving Party. The Receiving Party agrees that it will form its
                                                        own conclusions as to the reliability of any Confidential
                                                        Information and as to any conclusions to be drawn therefrom,
                                                        and will not charge the Disclosing Party with liability for any
                                                        damages resulting from mistakes, inaccuracies or
                                                        misinformation contained therein. The Receiving Party
                                                        understands and acknowledges that the Disclosing Party does
                                                        not undertake any obligation to provide any party with access to
                                                        any specific or additional information.
                                                    </p>

                                                    <p><b>ARTICLE 11 NON-WAIVER; REMEDIES CUMULATIVE</b></p>

                                                    <p>
                                                        Any failure of either Party to insist upon the strict performance of
                                                        any term or condition of this Agreement shall not be deemed a
                                                        waiver of any of the Party's rights or remedies, including the right
                                                        to insist on the strict performance of the same. No waiver or other
                                                        modification to this Agreement shall be valid unless it is in writing
                                                        and is signed by the Parties.
                                                    </p>
                                                    
                                                    <p>
                                                        The rights and remedies herein expressly provided are
                                                        cumulative and not exclusive of any rights or remedies, which
                                                        any of the Parties would otherwise have.
                                                    </p>

                                                    <p><b>ARTICLE 12 NO PUBLICITY</b></p>
                                                    
                                                    <p>
                                                        Neither Party hereto shall in any way or in any form disclose,
                                                        publicize, or advertise in any manner the discussions that give
                                                        rise to this Agreement nor the discussions or negotiations
                                                        covered by this Agreement without the prior written consent of
                                                        the other Party.                                                        
                                                    </p>

                                                    <p><b>ARTICLE 13 INTERPRETATION AND AMENDMENT</b></p>
                                                    
                                                    <p>
                                                        This Agreement constitutes the entire agreement between the
                                                        Parties with respect to the subject matter hereof. It excludes and
                                                        supersedes everything else which has occurred between the
                                                        Parties whether written or verbal, including all other
                                                        communications with respect to the subject matter hereof. The
                                                        headings of Clauses or Articles are for reference and shall not
                                                        affect their interpretation.
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row border p-3 m-3">
                                                <div class="col-md-6 col-12">
                                                    <p>
                                                        This Agreement may not be amended or modified except in writing.
                                                    </p>

                                                    <p>
                                                        This Agreement shall not be construed in favor or against any Party, but shall be construed equally as to both Parties
                                                    </p>

                                                    <p><b>ARTICLE 14 PERSONAL INFORMATION</b></p>

                                                    <p>
                                                        In the interest of both Parties, the Disclosing Party agrees not to
                                                        send the Receiving Party any information that can identify an
                                                        individual (“Personal Information”) unless both Parties otherwise
                                                        mutually agree. In such circumstances, the Receiving Party shall
                                                        comply with the obligations imposed on the Receiving Party by
                                                        this Agreement, the applicable data privacy laws, including, but
                                                        not limited to, Republic Act 10173 or the Data Privacy Act of 2012
                                                        and its Implementing Rules and Regulations. 
                                                    </p>

                                                    <p>
                                                        If sending Personal Information to the Receiving Party is required under this Agreement, the Receiving Party agrees to:
                                                    </p>

                                                    <p>
                                                        <ol style="list-style-type: lower-alpha;">
                                                            <li>
                                                                only process such Personal Information in
                                                                accordance with the Disclosing Party’s written
                                                                instructions, and only for purposes of evaluating the
                                                                Potential Transaction;
                                                            </li>
                                                            <li>
                                                                ensure that it implements and maintains
                                                                technical and organizational measures at a level
                                                                appropriate to the security of the Personal Information
                                                                shared by the Disclosing Party;
                                                            </li>
                                                            <li>
                                                                notify the Disclosing Party promptly (where
                                                                permitted under applicable law) if the Receiving Party
                                                                receives any request for access to the Personal
                                                                Information shared by the Disclosing Party by an
                                                                individual, regulator, or government authority, and
                                                                provide reasonable assistance to the Disclosing Party to
                                                                help the Disclosing Party comply with any such request;
                                                            </li>
                                                            <li>
                                                                notify the Disclosing Party within twenty-four
                                                                (24) hours upon knowledge or reasonable belief of the
                                                                Receiving Party that it has suffered any incident that
                                                                may impact the Personal Information shared by the
                                                                Disclosing Party;
                                                            </li>

                                                            <li>
                                                                not disclose the Personal Information shared
                                                                by the Disclosing Party to any third party without the
                                                                Disclosing Party’s prior written consent, save as
                                                                required by applicable law or in accordance with this
                                                                Agreement;
                                                            </li>

                                                            <li>
                                                                upon written request, provide the Disclosing
                                                                Party with details of the Receiving Party’s processing
                                                                of the Personal Information shared by the Disclosing
                                                                Party, including the technical and organizational
                                                                measures the Receiving Party has employed to protect
                                                                the said Personal Information; and
                                                            </li>

                                                            <li>
                                                                delete the Personal Information shared by the
                                                                Disclosing Party at the end, expiration, or early
                                                                termination of this Agreement.
                                                            </li>
                                                        </ol>
                                                    </p>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <p><b>ARTICLE 15 SEPARABILITY CLAUSE</b></p>

                                                    <p>
                                                        If any provision of this Agreement is illegal or unenforceable, its
                                                        invalidity shall not affect the other provisions of this Agreement
                                                        that can be given effect without the invalid provision. If any
                                                        provision of this Agreement does not comply with any law,
                                                        ordinance or regulation, such provision to the extent possible
                                                        shall be interpreted in such a manner to comply with such law,
                                                        ordinance or regulation, or if such interpretation is not possible,
                                                        it shall be deemed to satisfy the minimum requirements thereof
                                                    </p>

                                                    <p><b>ARTICLE 16 LEGAL CAPACITY OF REPRESENTATIVES</b></p>

                                                    <p>
                                                        Each Party represents and warrants to the other Party that its
                                                        representative executing this Agreement on its behalf is its duly
                                                        appointed and acting representative and has the legal capacity
                                                        required under applicable law to enter into this Agreement and
                                                        bind it.
                                                    </p>

                                                    <p><b>ARTICLE 17 GOVERNING LAW AND DISPUTE RESOLUTION</b></p>

                                                    <p>
                                                        This Agreement shall be governed by and construed in
                                                        accordance with the laws of the Republic of the Philippines,
                                                        without regard to any conflicts of law rules. Exclusive jurisdiction
                                                        over and venue of any suit arising out of or relating to this
                                                        Agreement will be in Taguig City, at the option of the
                                                        complaining Party. The Parties hereby consent and submit to
                                                        the exclusive jurisdiction and venue of those courts.
                                                    </p>

                                                    <p>
                                                        The Parties hereby waive all defenses of lack of personal
                                                        jurisdiction and forum non-convenience. Process may be served
                                                        on either Party in the manner authorized by applicable law or
                                                        court rule.
                                                    </p>

                                                    <p><b>ARTICLE 18 COUNTERPARTS; ELECTRONIC SIGNATURE</b></p>

                                                    <p>
                                                        This Agreement may be executed in any number of
                                                        counterparts, each of which is an original, but all of which
                                                        together constitute one and the same agreement.
                                                    </p>

                                                    <p>
                                                        This Agreement may be executed electronically or by way of
                                                        electronic signature and such electronic signatures shall be
                                                        deemed original signatures, have the same force and effect as
                                                        manual signatures and binding upon the Parties. If this
                                                        Agreement shall be executed electronically, the best evidence
                                                        of this Agreement shall be a copy of this Agreement bearing an
                                                        electronic signature, in portable document format (.pdf) form, or
                                                        in any other electronic format intended to preserve the original
                                                        graphic and pictorial appearance of a document.
                                                    </p>

                                                    <p><b>IN WITNESS WHEREOF, </b>the Parties have hereunto affixed their
                                                        signatures this _____________________________________at
                                                        __________________________________________________</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="check-non-disclosure" id="check-non-disclosure">
                                            By checking this it means you agree to the <b><a href="/files/nda/2020GlobeMutualConfidentialityandNon-DisclosureAgreementTemplate-fillable.pdf" download="2020GlobeMutualConfidentialityandNon-DisclosureAgreementTemplate-fillable.pdf">Non-Disclosure Agreement.</a></b>
                                          </label>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="clearfix">
                                        {{-- <button type="button" id="reset-btn-3" class="btn-shadow float-left btn btn-link reset-btn">Reset</button> --}}
                                        <button type="button" id="next-btn-3" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">Next</button>
                                        <button type="button" id="prev-btn-3" class="btn-shadow btn-wide mr-2 float-right btn-pill btn-hover-shine btn btn-default">Previous</button>
                                    </div>
                                </div>
                                <div id="step-4" class="tab-pane step-content  d-none">
                                    <div class="col-12">
                                        <div class="no-results">
                                            <div class="swal2-icon swal2-success swal2-animate-success-icon">
                                                <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                                                <span class="swal2-success-line-tip"></span>
                                                <span class="swal2-success-line-long"></span>
                                                <div class="swal2-success-ring"></div>
                                                <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                                                <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                                            </div>
                                            <div class="results-subtitle mt-4">Finished!</div>
                                            <div class="results-title">You can now submit your details for validation!</div>
                                            <div class="mt-3 mb-3"></div>
                                            <div class="text-center">
                                                {{-- <button id="finish-btn" type="button" class="btn-shadow btn-wide btn btn-success btn-lg" data-href="{{ route('finish.onboarding') }}">{{ \Auth::user()->getUserProfile()->mode == "vendor" ? "Request Validation" : "Finish Onboarding" }}</button> --}}
                                                <button id="finish-btn" type="button" class="btn-shadow btn-wide btn btn-success btn-lg" data-href="{{ route('finish.onboarding') }}">Finish Onboarding</button>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="divider"></div>
                                    <div class="clearfix">
                                        {{-- <button type="button" id="reset-btn-4" class="btn-shadow float-left btn btn-link reset-btn">Reset</button> --}}
                                        <button type="button" id="prev-btn-4" class="btn-shadow btn-wide mr-2 float-right btn-pill btn-hover-shine btn btn-default">Previous</button>
                                    </div>
                                </div>
                                {{-- <input type="hidden" name="hidden_route" id="hidden_route" value="{{ route('get.address') }}"> --}}
                                <input type="hidden" name="hidden_region" id="hidden_region">
                                <input type="hidden" name="hidden_province" id="hidden_province">
                                <input type="hidden" name="hidden_lgu" id="hidden_lgu">
                                {{-- <input type="hidden" id="hidden_mode" name="hidden_mode" > --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>                
        </div>
    </div>

    {{-- <input type="hidden" name="firsttime_login" id="firsttime_login" value="{{ \Auth::user()->first_time_login }}"> --}}
    {{-- <input type="hidden" name="user_detail" id="user_detail" value="{{ $user_details ? $user_details : '' }}"> --}}
@endsection

@section('modals')
<div class="modal fade" id="firsttimeModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Password</h5>
            </div>
            <form id="passwordUpdateForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" aria-describedby="helpId">
                        <small id="password-error" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Please confirm your password" aria-describedby="helpId">
                        <small id="password_confirmation-error" class="text-muted"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn-shadow float-left btn btn-link reset-btn"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <button type="button" class="btn btn-primary update_password" data-href="{{ route('update.password') }}">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>

        $(document).ready(function(){
            if ("{{ \Auth::user()->first_time_login }}" == "0" && "{{ \Auth::user()->getUserProfile()->mode }}" != "vendor" || "{{ !is_null(\Auth::user()->profile_id) }}") {
                $("#firsttimeModal").modal("show");
            }
        });

        $("#take_photo, #drop_take_photo").on("click", function(){
            // console.log("take photo");
            
            $("input[name=capture_image]").val("");
            $(".webcam-div").removeClass("d-none");
            $(".upload-photo-div").addClass("d-none");
            $(".upload-take-button").addClass("d-none");

            const player = document.getElementById('player');

            var btnCapture = document.getElementById( "shoot_camera" );
            var stream = document.getElementById( "player" );

            btnCapture.addEventListener( "click", captureSnapshot );

            var capture = document.getElementById( "canvas" );

            const constraints = {
                video: true,
            };

            navigator.mediaDevices.getUserMedia(constraints)
            .then((stream) => {
                player.srcObject = stream;
            });

            function captureSnapshot() {
                var ctx = capture.getContext( '2d' );
                var img = new Image();

                ctx.drawImage( stream, 0, 0, capture.width, capture.height );

                var dataUrl = capture.toDataURL( "image/png" );
                img.src = capture.toDataURL( "image/png" );
                // img.width = 240;
                img.setAttribute("class", "w-100 h-auto");

                snapshot.innerHTML = '';

                snapshot.appendChild( img );

                $("input[name=capture_image]").val(dataUrl);

                $("#snapshot").removeClass("d-none");
                $("#player").addClass("d-none");
                $("#shoot_camera").addClass("d-none");

                $("#change_photo").removeClass("d-none");
            }
        });

        $("#upload_phto, #web_upload_phto").on("click", function(){
            
            const player = document.getElementById('player');

            var btnCapture = document.getElementById( "shoot_camera" );
            var stream = document.getElementById( "player" );

            var capture = document.getElementById( "canvas" );

            const constraints = {
                video: false,
            };

            stream.stop = function(){         
                this.getTracks().forEach(function (track) {
                    track.stop();
                });
            };
            
            $("input[name=capture_image]").val("");
            $(".webcam-div").addClass("d-none");
            $(".upload-photo-div").removeClass("d-none");
            $(".upload-take-button").addClass("d-none");
        });



    Dropzone.autoDiscover = false;  
    $(".dropzone").dropzone({
        addRemoveLinks: true,
        maxFiles: 1,
        // maxFilesize: 1,
        acceptedFiles: '.jpg, .jpeg, png',
        paramName: "file",
        url: "/upload-image-file",
        init: function() {
            this.on("maxfilesexceeded", function(file){
                this.removeFile(file);
            });
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, resp) {
            $("input[name=capture_image]").val(resp.file);
            console.log(resp.message);
        },
        error: function (file, resp) {
            $("input[name=capture_image]").val("");
            Swal.fire(
                'Error',
                resp,
                'error'
            )
        }
    });
            
    $("#change_photo").addClass("d-none");

    $("#change_photo").on("click", function(){
        $("#snapshot").addClass("d-none");

        $("#player").removeClass("d-none");
        $("#shoot_camera").removeClass("d-none");


        $("input[name=capture_image]").val("");
        $("#change_photo").addClass("d-none");
    });    

    $(document).on("click", ".update_password", function(){
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $.ajax({
            url: "/change-password",
            method: "POST",
            data: $("#passwordUpdateForm").serialize(),
            success: function (resp) {
                if (!resp.error) {
                    // Swal.fire(
                    //     'Success',
                    //     resp.message,
                    //     'success'
                    // )

                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )

                    $("#firsttimeModal").modal("hide");

                    $(".update_password").removeAttr("disabled");
                    $(".update_password").text("Update");
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }


                    $(".update_password").removeAttr("disabled");
                    $(".update_password").text("Update");
                }
            },

            error: function (resp) {
                // Swal.fire(
                //     'Error',
                //     resp,
                //     'error'
                // )

                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".update_password").removeAttr("disabled");
                $(".update_password").text("Update");
            }
        })

    });

    $("#finish-btn").on('click', function(){
        $.ajax({
            url: $(this).attr('data-href'),
            data: $("#onboardingForm").serialize(),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if (!resp.error){   
                    $(".step-1-li").removeClass('active');
                    $(".step-2-li").removeClass('active');
                    $(".step-3-li").removeClass('active');

                    $(".step-1-li").addClass('done');
                    $(".step-2-li").addClass('done');
                    $(".step-3-li").addClass('done');

                    $("#step-1").addClass('d-none');
                    $("#step-2").addClass('d-none');
                    $("#step-3").addClass('d-none');

                    $(".results-title").text($("#mode").val());

                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )

                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("." + index + "-error").text(data);
                        });

                        $(".step-1-li").addClass('active');
                        $(".step-2-li").removeClass('done');
                        $(".step-3-li").removeClass('done');
                        $(".step-4-li").removeClass('done');

                        $("#step-1").removeClass('d-none');
                        $("#step-2").addClass('d-none');
                        $("#step-3").addClass('d-none');
                        $("#step-4").addClass('d-none');
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )

                        $(".step-1-li").addClass('active');
                        $(".step-2-li").removeClass('done');
                        $(".step-3-li").removeClass('done');
                        $(".step-4-li").removeClass('done');

                        $("#step-1").removeClass('d-none');
                        $("#step-2").addClass('d-none');
                        $("#step-3").addClass('d-none');
                        $("#step-4").addClass('d-none');
                    }
                }
            },
            error: function(resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            }
        });
    });

    $(document).ready(function () {

        var user_details_data = JSON.parse("{{ json_encode(\Auth::user()->getUserDetail()->first()); }}".replace(/&quot;/g,'"'));
        var user_data = JSON.parse("{{ json_encode(\Auth::user()); }}".replace(/&quot;/g,'"'));

        if (user_details_data != null) {

            if (user_details_data.birthday != null) {
                $(".step-1-li").addClass('done');
                $(".step-2-li").addClass('done');
                $(".step-3-li").addClass('done');
                $(".step-4-li").addClass('active');

                $("#step-1").addClass('d-none');
                $("#step-2").addClass('d-none');
                $("#step-3").addClass('d-none');
                $("#step-4").removeClass('d-none');

                $.each(user_details_data, function(index, data) {
                    if (index == "region_id") {
                        $("#onboardingForm #region").val(data);
                        $("#onboardingForm #hidden_region").val(data);
                    } else if (index == "province_id") {
                        $("#onboardingForm #province").val(data);
                        $("#onboardingForm #hidden_province").val(data);
                    } else if (index == "lgu_id") {
                        $("#onboardingForm #lgu").val(data);
                        $("#onboardingForm #hidden_lgu").val(data);
                    } else {
                        $("#onboardingForm #"+index).val(data);
                    }
                });
            }
        }
        
        $.each(user_data, function(index, data) {
            $("#onboardingForm #"+index).val(data);
        });
    });

    </script>
    <script src="{{ asset('/js/enrollment.js') }}"></script>
@endsection
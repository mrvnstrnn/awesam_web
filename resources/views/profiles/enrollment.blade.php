@extends('layouts.enrollment')

@section('content')
    <div class="row  vw-100 mt-4">
        <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div id="smartwizard" class="sw-main sw-theme-default">
                        <ul class="forms-wizard nav nav-tabs step-anchor">
                            <li class="nav-item step-1-li active">
                                <a href="#step-1" class="nav-link">
                                    <em>1</em>
                                    <span>User Information</span>
                                </a>
                            </li>
                            <li class="nav-item step-2-li">
                                <a href="#step-2" class="nav-link">
                                    <em>2</em>
                                    <span>Profile Information</span>
                                </a>
                            </li>
                            <li class="nav-item step-3-li">
                                <a href="#step-3" class="nav-link">
                                    <em>3</em>
                                    <span>Finish Registration</span>
                                </a>
                            </li>
                        </ul>
                        <div class="form-wizard-content sw-container tab-content d-block" style="min-height: 353px;">
                            <form id="onboardingForm">
                                <div id="step-1" class="tab-pane step-content">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="firstname">Firstname</label>
                                                <input name="firstname" id="firstname" placeholder="" value="{{ \Auth::user()->firstname }}" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="lastname">Lastname</label>
                                                <input name="lastname" id="lastname" placeholder="" value="{{ \Auth::user()->lastname }}" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="email">Email</label>
                                                <input name="email" id="email" placeholder="" value="{{ \Auth::user()->email }}" type="email" class="form-control" data-toggle="tooltip" title="You're not be able to change the email." readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="region">Region</label>
                                                <select class="form-control" name="address" id="region">
                                                    <option value="">Please select region</option>
                                                    @foreach ($locations as $location)
                                                    <option value="{{ $location->region }}">{{ $location->region }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="province">Province</label>
                                                <select class="form-control" name="address" id="province" disabled required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="lgu">City</label>
                                                <select class="form-control" name="address" id="lgu" disabled required></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="clearfix">
                                        <button type="button" id="reset-btn-1" class="btn-shadow float-left btn btn-link reset-btn">Reset</button>
                                        <button type="button" id="next-btn-1" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">Next</button>
                                    </div>
                                </div>                                
                                <div id="step-2" class="tab-pane step-content d-none">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="region">Mode</label>
                                                <input type="text" class="form-control" id="mode" name="mode" value="{{ \Auth::user()->getUserDetail()->first()->mode }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="clearfix">
                                        <button type="button" id="reset-btn-2" class="btn-shadow float-left btn btn-link reset-btn">Reset</button>
                                        <button type="button" id="finish-btn" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary" data-href="{{ route('finish.onboarding') }}">Finish</button>
                                        <button type="button" id="prev-btn" class="btn-shadow btn-wide mr-2 float-right btn-pill btn-hover-shine btn btn-default">Previous</button>
                                    </div>
                                </div>
                                <div id="step-3" class="tab-pane step-content  d-none">
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
                                        <div class="results-title"></div>
                                        <div class="mt-3 mb-3"></div>
                                    </div>
                                </div>
                                <input type="hidden" name="hidden_route" id="hidden_route" value="{{ route('get.address') }}">
                                <input type="hidden" name="hidden_region" id="hidden_region">
                                <input type="hidden" name="hidden_province" id="hidden_province">
                                <input type="hidden" name="hidden_lgu" id="hidden_lgu">
                                <input type="hidden" id="hidden_mode" hidden_mode="mode" value="{{ \Auth::user()->getUserDetail()->first()->mode }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>                
        </div>
    </div>

    <input type="hidden" name="firsttime_login" id="firsttime_login" value="{{ \Auth::user()->first_time_login }}">
    <input type="hidden" name="user_detail" id="user_detail" value="{{ $user_details ? $user_details : '' }}">
@endsection

@section('modals')
<div class="modal fade" id="firsttimeModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <script src="{{ asset('js/invite.js') }}"></script>
@endsection
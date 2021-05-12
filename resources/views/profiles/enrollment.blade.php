

@extends('layouts.enrollment')

@section('content')
    <div class="row  vw-100 mt-4">
        <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div id="smartwizard" class="sw-main sw-theme-default">
                        <ul class="forms-wizard nav nav-tabs step-anchor">
                            <li class="nav-item step-1-li active">
                                <a href="javascript:void(0)" class="nav-link">
                                    <em>1</em>
                                    <span>User Information</span>
                                </a>
                            </li>
                            <li class="nav-item step-2-li">
                                <a href="javascript:void(0)" class="nav-link">
                                    <em>2</em>
                                    <span>Profile Information</span>
                                </a>
                            </li>
                            <li class="nav-item step-3-li">
                                <a href="javascript:void(0)" class="nav-link">
                                    <em>3</em>
                                    <span>Non-Disclosure Agreement</span>
                                </a>
                            </li>
                            <li class="nav-item step-4-li">
                                <a href="javascript:void(0)" class="nav-link">
                                    <em>4</em>
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
                                                <input name="firstname" id="firstname" placeholder="" value="{{ \Auth::user()->firstname }}" type="text" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="lastname">Lastname</label>
                                                <input name="lastname" id="lastname" placeholder="" value="{{ \Auth::user()->lastname }}" type="text" class="form-control" readonly>
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
                                                <input type="text" class="form-control" id="mode" name="mode" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="clearfix">
                                        <button type="button" id="reset-btn-2" class="btn-shadow float-left btn btn-link reset-btn">Reset</button>
                                        <button type="button" id="next-btn-2" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">Next</button>
                                        <button type="button" id="prev-btn-2" class="btn-shadow btn-wide mr-2 float-right btn-pill btn-hover-shine btn btn-default">Previous</button>
                                    </div>
                                </div>
                                <div id="step-3" class="tab-pane step-content d-none">
                                    <div class="col-12">
                                        <p style="height: 200px !important; overflow: auto;">
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Explicabo iusto voluptate inventore tempore obcaecati delectus itaque nostrum sapiente veritatis. Numquam commodi repellendus iste, eligendi aperiam blanditiis, aspernatur deleniti delectus ipsum eum debitis totam maxime perspiciatis impedit quo. Eveniet optio, necessitatibus nihil atque quia neque sit autem iste iusto cum! Facere placeat suscipit enim beatae. Possimus repellendus obcaecati a ad, atque illum adipisci reprehenderit cupiditate. Cumque, qui at. Assumenda velit maxime aliquam et incidunt eaque in repudiandae ullam architecto eum alias enim fugiat commodi, iure deleniti cum veritatis aliquid nihil, sapiente minima, adipisci dicta voluptates! Blanditiis quos fuga id. Voluptatem temporibus natus ipsa atque neque nobis corporis officia. Quaerat, perferendis. Culpa inventore ab laborum id praesentium voluptatum, maxime natus quibusdam autem consequatur ipsam tempore laudantium? Numquam, id? Ad eaque consequuntur eos tenetur similique praesentium voluptatibus ut modi quasi unde! Provident maiores magni consectetur qui, minima porro vitae quam quae obcaecati, maxime explicabo libero praesentium quia alias officia dolore ea aliquam in molestiae quod. Hic, enim. Reprehenderit fugit, quasi officiis distinctio velit esse voluptates eum commodi atque. Cupiditate sint nihil, quas dolores, natus voluptates, ea aut laborum aliquid sed sequi placeat neque unde? Voluptates asperiores voluptatem nisi iusto placeat delectus deleniti dolorum sit enim voluptatum sunt illo sint modi expedita eaque vel fugit, earum nemo nam cupiditate officia recusandae? Commodi odit non adipisci in dolore quia officiis voluptatem corporis architecto quibusdam obcaecati explicabo molestias at aperiam, aliquam nihil veritatis sunt facilis tenetur sequi provident porro rem. Itaque fugit sapiente repellat eaque consequuntur, tenetur impedit incidunt officia soluta consequatur quod dicta? Ullam veritatis nam facere error ad ut totam quis cum adipisci, obcaecati reprehenderit! Officia nemo quaerat distinctio asperiores sint, repellat nihil. Dicta doloremque deserunt, quo rerum iusto cupiditate in nam, veritatis dolores quod asperiores, amet laudantium dolor autem illum dignissimos doloribus temporibus corporis perspiciatis odit provident dolorum repellat! Aspernatur, magnam? Tempora repellat nihil consequatur asperiores necessitatibus ea deleniti temporibus sint harum, quia provident pariatur porro corrupti mollitia recusandae inventore iusto nobis! Ipsam voluptas modi corporis, quae consequuntur quia repudiandae beatae, pariatur totam provident adipisci dolore impedit consequatur quas amet, voluptatum doloribus similique soluta. Sit, ad distinctio amet veniam magnam eligendi nemo, impedit ea ipsam quibusdam tempora aut a exercitationem autem, placeat id esse magni odit architecto accusamus eum quos quaerat qui! Voluptatibus sapiente, perferendis nisi eos, nobis sit quidem adipisci impedit optio, consectetur porro est aut eligendi natus quod aspernatur ipsum quas sint dolore recusandae distinctio totam qui. Dolorum nam, quasi, corporis corrupti ea nihil, dolor iure laudantium quisquam earum harum quia recusandae qui praesentium illum ex ratione animi provident dolore? Tenetur ipsa ea quis reiciendis eos? Dignissimos provident distinctio unde officiis eius corporis, consequatur veritatis molestiae dolorem perferendis, eveniet laboriosam dolorum. Architecto commodi minima consequatur porro doloribus aut, repudiandae eum, dolores vero voluptatum amet eos qui vitae, officia eaque corrupti molestiae! Pariatur explicabo dignissimos voluptas nihil numquam autem quibusdam ipsam laudantium qui alias fugiat quis doloribus hic, ea expedita? Excepturi, natus aliquid ratione beatae cumque possimus asperiores doloribus voluptate quos assumenda?
                                        </p>

                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="check-non-disclosure" id="check-non-disclosure">
                                                By checking this it means you agree to the <b>Non-Disclosure Agreement.</b>
                                          </label>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="clearfix">
                                        <button type="button" id="reset-btn-3" class="btn-shadow float-left btn btn-link reset-btn">Reset</button>
                                        <button type="button" id="finish-btn" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary" data-href="{{ route('finish.onboarding') }}" disabled>Finish</button>
                                        <button type="button" id="prev-btn-3" class="btn-shadow btn-wide mr-2 float-right btn-pill btn-hover-shine btn btn-default">Previous</button>
                                    </div>
                                </div>
                                <div id="step-4" class="tab-pane step-content  d-none">
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
                                <input type="hidden" id="hidden_mode" hidden_mode="mode" value="">
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
{{-- <div class="modal fade" id="firsttimeModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div> --}}
@endsection

@section('scripts')
    <script src="{{ asset('js/invite.js') }}"></script>
@endsection
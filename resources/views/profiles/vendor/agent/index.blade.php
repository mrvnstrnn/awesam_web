@extends('layouts.home')

@section('content')

    @php
        $user_program = \Auth::user()->getUserProgram()[0]->program_id;
    @endphp

    <x-home-dashboard-sites />

    <x-home-dashboard-productivity />

    <x-home-dashboard-milestone :programid="$user_program" />

    {{-- <div class="divider"></div>
    <div class="row">
        <div class="col-12">
            <h3>My Badges</h3>
        </div>
    </div>
    <div class="row p-2">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">                
                            <div class="star-box text-center">
                                <img src="/images/blue-star.png" width="40px">
                            </div>
                            <div class="star-box-type text-center" style="font-weight: bold; font-size: 14px !important;">
                                97
                            </div>
                            <div class="star-box-type text-center" style="font-size: 12px !important;">
                                Daily Login
                            </div>
                        </div>
                        <div class="col">
                            <div class="star-box text-center">
                                <img src="/images/blue-star.png" width="40px">
                            </div>
                            <div class="star-box-type text-center" style="font-weight: bold; font-size: 14px !important;">
                                45
                            </div>
                            <div class="star-box-type text-center" style="font-size: 12px !important;">
                                RTB Sites
                            </div>
                        </div>
                        <div class="col">
                            <div class="star-box text-center">
                                <img src="/images/blue-star.png" width="40px">
                            </div>
                            <div class="star-box-type text-center" style="font-weight: bold; font-size: 14px !important;">
                                65
                            </div>
                            <div class="star-box-type text-center" style="font-size: 12px !important;">
                                Completed Sites
                            </div>
                        </div>
                        <div class="col">
                            <div class="star-box text-center">
                                <img src="/images/blue-star.png" width="40px">
                            </div>
                            <div class="star-box-type text-center" style="font-weight: bold; font-size: 14px !important;">
                                34
                            </div>
                            <div class="star-box-type text-center" style="font-size: 12px !important;">
                                Sites w/ No Issue
                            </div>
                        </div>
                        <div class="col">
                            <div class="star-box text-center">
                                <img src="/images/blue-star.png" width="40px">
                            </div>
                            <div class="star-box-type text-center" style="font-weight: bold; font-size: 14px !important;">
                                77
                            </div>
                            <div class="star-box-type text-center" style="font-size: 12px !important;">
                                Attendance
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div> --}}


@endsection

@section("js_script")


@endsection
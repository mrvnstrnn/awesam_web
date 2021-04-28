@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Personal Information</h5>
                <form class="">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="firstname" class="">Firstname</label>
                                <input name="firstname" id="firstname" placeholder="John" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="lastname" class="">Lastname</label>
                                <input name="lastname" id="lastname" placeholder="Doe" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="email" class="">Email</label>
                                <input name="email" id="email"
                                    placeholder="johndoe@gmail.com" type="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="mobile_no" class="">Mobile no.</label>
                                <input name="mobile_no" id="mobile_no"
                                    placeholder="+639123456789" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="password" class="">Password</label>
                                <input name="password" id="password"
                                    placeholder="********" type="password" class="form-control">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="card-title">Address Information</h5>

                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="region" class="">Region</label>
                                <input name="region" id="region" type="text" class="form-control" placeholder="CALABARZON">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="province" class="">Province</label>
                                <input name="province" id="province" type="text" class="form-control" placeholder="BATANGAS">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="city" class="">City</label>
                                <input name="city" id="city" type="text" class="form-control" placeholder="CITY OF TANAUAN">
                            </div>
                        </div>
                    </div>

                        <hr>
                    <h5 class="card-title">Profile & Mode Information</h5>

                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="mode" class="">Mode</label>
                                <input name="mode" id="mode" type="text" class="form-control" placeholder="Vendor">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="profile" class="">Profile</label>
                                <input name="profile" id="profile" type="text" class="form-control" placeholder="Vendor Admin">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="program" class="">Program</label>
                                <input name="program" id="program" type="text" class="form-control" placeholder="NOKIA">
                            </div>
                        </div>
                    </div>
                    <button class="mt-2 btn btn-primary float-right">Update Details</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
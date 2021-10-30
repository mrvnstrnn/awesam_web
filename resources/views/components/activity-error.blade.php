<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header p-0">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content text-left">
                                    <div>
                                        <h5 class="menu-header-title">
                                            {{ $site }}
                                            @if($site_category != 'none')
                                                <span class="mr-3 badge badge-secondary"><small>{{ $site_category }}</small></span>
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row p-0">
                                <div class="col-12">
                                    <img src="{{ asset('images/construction.gif') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
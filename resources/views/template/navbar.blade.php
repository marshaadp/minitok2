<style type="text/css">
    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
        /* remove the gap so it doesn't close */
    }
</style>
<div class="container-fluid" style=" width: 100%;background-color: #e0e0e0;">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4 col-12">
                    <img src="{{ asset('resources/img/minitok.jpeg') }}" class="img-fluid" alt="Logo"
                        style="width: 120px; height: auto; max-width: 100%;">
                </div>
                <div class="col-md-8 col-12">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="font-weight-bold">
                            <span class="d-md-none" style="font-size: 20px;">Minimum Stock</span><br>
                            <span class="d-none d-md-block"
                                style="font-size: 25px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">Minimum
                                Stock</span>

                            <span class="d-md-none" style="font-size: 12px;">The Ultimate Novelty Tools As
                                Solutions</span>
                            <span class="d-none d-md-block" style="font-size: 20px;">The Ultimate Novelty Tools As
                                Solutions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2" style="padding-top: 30px; padding-bottom: 5px">
            <div class="icon" onclick="toggleNotifi()">
                <div class="d-flex justify-content-end">
                    <a class="active btn btn-danger align-middle my-auto" style="color: white; height: 40px">
                        <img src="{{ asset('resources/img/bell.png') }}" alt="" /><span
                            id="notifesHeader"></span>
                    </a>
                </div>
            </div>
            @include('template.notification')
        </div>
        {{-- <div class="col-md-1" style="padding-top: 30px; padding-bottom: 5px">
            <div class="icon" onclick="toggleNotifi()">
                <div class="d-flex justify-content-end">
                    <a
                        class="active btn btn-danger align-middle my-auto"
                        style="color: white; height: 40px"
                    >
                        <img
                            src="{{ asset('resources/img/bell.png') }}"
                            alt=""
                        /><span id="notifesHeader"></span>
                    </a>
                </div>
            </div>
        </div> --}}

        <div class="col-md-2" style="padding-top: 30px; padding-bottom: 5px">
            <div class="d-flex justify-content-end">
                <a class="active btn btn-danger align-middle my-auto" style="color: white; height: 40px"
                    href="{{ url('/logout') }}">Logout</a>
            </div>
            {{-- @include('template.message_toast.message') --}}
        </div>
    </div>
</div>

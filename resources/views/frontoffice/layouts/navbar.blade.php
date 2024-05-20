<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="nav-container container-fluid">
        {{-- <a class="navbar-brand me-5 fw-bold fs-3" href="{{ route('home') }}">{{ $shareSite->site_title }}</a> --}}
        <a class="navbar-brand fw-bold fs-3 p-0" href="{{ route('home') }}">
            <figure style="width: 186px; margin: 0 !important;">
                <img src="images\logo\โลโก้รีสอร์ท.jpg" alt="" style="width: 100%;">
            </figure>
        </a>
        <button class="navbar-toggler shadow-none border-none border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link me-2 fs-6" data-slug="/" aria-current="page"
                        href="{{ route('home') }}">หน้าหลัก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2 fs-6" data-slug="/rooms" href="{{ route('rooms') }}">ห้องพัก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2 fs-6" data-slug="/facilities"
                        href="{{ route('facilities') }}">สิ่งอำนวยความสะดวก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2 fs-6" data-slug="/contactus" href="{{ route('contactus') }}">ติดต่อเรา</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2 fs-6" data-slug="/bookingsearch" href="javascript:"
                        onclick="bookingSearch()">ค้นหารายการจอง</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

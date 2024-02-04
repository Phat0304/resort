<footer class="footer-container bg-white mt-auto shadow-sm">
    <div class="row">
        <div class="col-lg-4 p-4">
            <h1 class="fw-bold fs-2 mb-2">{{ $shareSite->site_title }}</h1>
            <p>
                {{ $shareSite->site_about }}
            </p>
        </div>
        <div class="col-lg-4 p-4">
            <h4 class="mb-3">หน้า</h4>
            <div class="d-flex flex-column">
                <a href="{{ route('home') }}" class="d-inline-block mb-2 text-dark text-decoration-none">หน้าหลัก</a>
                <a href="{{ route('rooms') }}" class="d-inline-block mb-2 text-dark text-decoration-none">ห้องพัก</a>
                <a href="{{ route('facilities') }}"
                    class="d-inline-block mb-2 text-dark text-decoration-none">สิ่งอำนวยความสะดวก</a>
                <a href="{{ route('contactus') }}"
                    class="d-inline-block mb-2 text-dark text-decoration-none">ติดต่อเรา</a>
                <a href="{{ route('about') }}"
                    class="d-inline-block mb-2 text-dark text-decoration-none">เกี่ยวกับเรา</a>
            </div>
        </div>
        <div class="col-lg-4 p-4">
            <h4 class="mb-3">ติดตามเรา</h4>
            <a href="{{ $shareContact->line }}" target="_blank"
                class="d-inline-block mb-2 text-dark text-decoration-none mb-2">
                <i class="bi bi-line me-1"></i> Line
            </a><br>
            <a href="{{ $shareContact->fb }}" target="_blank"
                class="d-inline-block mb-2 text-dark text-decoration-none mb-2">
                <i class="bi bi-facebook me-1"></i> Facebook
            </a><br>
            <a href="{{ $shareContact->ig }}" target="_blank"
                class="d-inline-block mb-2 text-dark text-decoration-none">
                <i class="bi bi-instagram me-1"></i> Instagram
            </a><br>
        </div>
    </div>
    <h5 class="text-center bg-dark text-white p-3 m-0 fw-normal fs-6">{{ $shareSite->site_title }}</h5>
</footer>

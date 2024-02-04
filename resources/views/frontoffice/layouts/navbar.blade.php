<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="nav-container container-fluid">
        {{-- <a class="navbar-brand me-5 fw-bold fs-3" href="{{ route('home') }}">{{ $shareSite->site_title }}</a> --}}
        <a class="navbar-brand fw-bold fs-3 p-0" href="{{ route('home') }}">
            <figure style="width: 186px; margin: 0 !important;">
                <img src="images/logo/logo.png" alt="" style="width: 100%;">
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
                    <a class="nav-link me-2 fs-6" data-slug="/bookingsearch" href="javascript:" onclick="bookingSearch()">ค้นหารายการจอง</a>
                </li>
            </ul>
            {{-- <div class="d-flex">
                <button type="button" class="btn btn-outline-dark me-lg-2 me-3 shadow-none" data-bs-toggle="modal"
                    data-bs-target="#loginModal">
                    เข้าสู่ระบบ
                </button>
                <button type="button" class="btn btn-outline-dark me-lg-2 me-3 shadow-none" data-bs-toggle="modal"
                    data-bs-target="#registerModal">
                    สมัครสมาชิก
                </button>
            </div> --}}
        </div>
    </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <i class="bi bi-person-circle fs-3 me-2"></i>
                    <h4 class="modal-title" id="staticBackdropLabel">เข้าสู่ระบบ</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email address :</label>
                        <input type="email" class="form-control shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password :</label>
                        <input type="password" class="form-control shadow-none" required>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <button class="btn btn-dark shadow-none" type="submit">Login</button>
                        <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot
                            Password?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <i class="bi bi-person-lines-fill fs-3 me-2"></i>
                    <h4 class="modal-title" id="staticBackdropLabel">สมัครสมาชิก</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge rounded-pill text-bg-light mb-3 text-wrap lh-base text-dark">
                        Note: Your details must match with your ID (Aadharr card, passport, driving, licence, etc.)
                    </span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name :</label>
                                <input type="text" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email :</label>
                                <input type="email" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number :</label>
                                <input type="text" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Picture :</label>
                                <input type="file" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address :</label>
                                <textarea class="form-control shadow-none" rows="1"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pincode :</label>
                                <input type="number" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of birth :</label>
                                <input type="date" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">password :</label>
                                <input type="password" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm Password :</label>
                                <input type="password" class="form-control shadow-none" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-center my-1">
                        <button type="submit" class="btn btn-dark shadow-none">สมัครสมาชิก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

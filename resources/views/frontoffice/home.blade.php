@extends('frontoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/home.css">
@endsection

@section('content')
    <!-- Carousel -->
    <div class="fluid">
        <!-- Swiper -->
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                @foreach ($slide_img as $slide)
                    <div class="swiper-slide" style="max-height: 585px;">
                        <img src="{{ $slide->image }}" class="w-100 h-100 d-block" style="object-fit: fill;" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Check availability form -->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <div class="d-flex align-items-center">
                    <i class="bi bi-building-fill-check fs-3 me-2"></i>
                    <h5 class="">ตรวจสอบห้องว่าง</h5>
                </div>
                <form onsubmit="return searchrooms(event)">
                    <div class="row align-items-end">
                        <div class="col-lg-3">
                            <label class="form-label" style="font-weight: 500;">เช็คอิน</label>
                            <input type="date" name="checkin" min="{{ date('Y-m-d') }}" id="date-checkin"
                                class="form-control shadow-none pointer" required>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label" style="font-weight: 500;">เช็คเอ้าท์</label>
                            <input type="date" name="checkout" id="date-checkout"
                                class="form-control shadow-none pointer" required disabled>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label" style="font-weight: 500;">ผู้ใหญ่/คน</label>
                            <select class="form-select shadow-none pointer text-center" id="select-adult" name="adult"
                                required>
                                <option value="1">1</option>
                                <option value="2" selected>2</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label" style="font-weight: 500;">เด็ก/คน</label>
                            <select class="form-select shadow-none pointer text-center" id="select-children" name="children"
                                required>
                                <option value="0">0</option>
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="col-12 mt-3 text-center">
                            <button type="submit" class="btn text-white shadow-none custom-bg">ค้นหา</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- OUR ROOMS -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">ห้องพัก</h2>
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($rooms as $room)
                <div class="col-lg-4 col-md-6 my-3">
                    <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <div style="max-width: 350px;">
                            <div class="swiper swiper-gallery">
                                <div class="swiper-wrapper">
                                    @foreach ($room->gallery as $slide)
                                        <div class="swiper-slide" style="max-height: 198px; max-wight: 350px;">
                                            <img src="{{ $slide->image }}" class="card-img-top"height=198>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4>{{ $room->name }}</h4>
                            <h5 class="mb-4">฿ {{ $room->price }} / วัน</h5>
                            <div class="features mb-2">
                                <h5 class="mb-1">คุณสมบัติห้อง</h5>
                                @foreach ($room->features as $fea)
                                    <span class="badge rounded-pill bg-light text-wrap text-dark"
                                        style="font-size: 14px; font-weight: 400;">
                                        {{ $fea->name }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="facilities mb-4">
                                <h5 class="mb-1">สิ่งอำนวยความสะดวก</h5>
                                @foreach ($room->facs as $fac)
                                    <span class="badge rounded-pill bg-light text-wrap text-dark"
                                        style="font-size: 14px; font-weight: 400;">
                                        {{ $fac->name }}
                                    </span>
                                @endforeach
                            </div>
                            {{-- <div class="rating mb-4">
                                <h5 class="mb-1">ระดับความพึงพอใจ</h5>
                                <span class="badge rounded-pill bg-light">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                </span>
                            </div> --}}
                            <div class="d-flex justify-content-evenly mb-2">
                                <a href="{{ route('rooms') }}"
                                    class="btn btn-sm text-white custom-bg shadow-none">จองห้อง</a>
                                <a href="/roomdetails?id={{ $room->id }}"
                                    class="btn btn-sm btn-outline-dark shadow-none">รายละเอียด</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-12 text-center mt-5">
                <a href="{{ route('rooms') }}"
                    class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">ดูห้องเพิ่มเติม >>></a>
            </div>
        </div>
    </div>

    <!-- FACILITIES -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">สิ่งอำนวยความสะดวกของเรา</h2>

    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            @foreach ($facilities as $fac)
                <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                    <img src="{{ $fac->icon }}" width="80px">
                    <h4 class="mt-3">{{ $fac->name }}</h4>
                </div>
            @endforeach
            <div class="col-lg-12 text-center mt-5">
                <a href="{{ route('facilities') }}"
                    class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">ดูเพิ่มเติม >>></a>
            </div>
        </div>
    </div>

   
    <!-- Contact US -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">ติดต่อเรา</h2>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe class="w-100 rounded" src="{{ $contactUs->iframe }}" height="450" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h4>โทร</h4>
                    <a href="tel: {{ $contactUs->phone1 }}" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill me-1"></i>{{ $contactUs->phone1 }}
                    </a>
                    <br>
                    <a href="tel: {{ $contactUs->phone2 }}" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill me-1"></i>{{ $contactUs->phone2 }}
                    </a>
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h4>ติดตามเรา</h4>
                    <a href="{{ $contactUs->line }}" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-line me-1"></i>
                            Line
                        </span>
                    </a>
                    <br>
                    <a href="{{ $contactUs->fb }}" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook me-1"></i>
                            Facebook
                        </span>
                    </a>
                    <br>
                    <a href="{{ $contactUs->ig }}" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram me-1"></i>
                            Instagram
                        </span>
                    </a>
                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }
        });

        var swiper = new Swiper(".swiper-gallery", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }
        });

        var swiper = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: 3,
            loop: true,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    </script>

    <script src="js/frontoffice/home.js"></script>
@endsection

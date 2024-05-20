@extends('frontoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/rooms.css">
@endsection

@section('content')
    <div class="my-5 px-4 scroll-top">
        <h1 class="fw-bold text-center">ห้องพักทั้งหมด</h1>
        <div class="h-line bg-dark"></div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-lg-rounded">

                <div class="container-fluid flex-lg-column bg-white shadow py-2 rounded">
                    <h4 class="mt-2">เลือกวันที่เข้าพัก</h4>
                    <form onsubmit="return searchrooms(event)" id="form-search">
                        <div class="border bg-light p-3 rounded mb-3">
                            <label class="form-label" style="font-weight: 500;">เช็คอิน</label>
                            <input type="date" name="checkin" min="{{ date('Y-m-d') }}" id="date-checkin"
                                class="form-control shadow-none pointer mb-3" required>
                            <label class="form-label" style="font-weight: 500;">เช็คเอ้าท์</label>
                            <input type="date" class="form-control shadow-none pointer" name="checkout"
                                id="date-checkout" required>
                        </div>

                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="mb-3" style="font-size: 18px;">จำนวนผู้เข้าพัก</h5>
                            <div class="d-flex">
                                <div class="row w-100">
                                    <div class="col-12 col-md-6 col-lg-12">
                                        <label class="form-label" style="font-weight: 500;">ผู้ใหญ่/คน</label>
                                        <select class="form-select select shadow-none pointer text-center" id="select-adult"
                                            name="adult" required>
                                            <option value="1">1</option>
                                            <option value="2" selected>2</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-12">
                                        <label class="form-label" style="font-weight: 500;">เด็ก/คน</label>
                                        <select class="form-select select shadow-none pointer text-center"
                                            id="select-children" name="children" required>
                                            <option value="0">0</option>
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="w-100 d-flex justify-content-center align-items-center">
                            <div class="d-none">
                                <button type="submit"
                                    class="btn text-white btn-search shadow-none custom-bg">ค้นหา</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-9 col-md-12 px-4">
                {{-- Rooms --}}
                @foreach ($rooms as $room)
                    <div class="card mb-4 border-0 shadow">
                        <div class="row g-0 p-3 align-items-center">
                            <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                @if (count($room->gallery) === 0)
                                    <div class="swiper swiper-gallery">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide" style="max-height: 198px; max-wight: 350px;">
                                                <figure style="height: 198px; wight: 350px;">
                                                    <img src="/images/rooms/no-img.jpg" class="h-100 w-100 rounded">
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="swiper swiper-gallery">
                                        <div class="swiper-wrapper">
                                            @foreach ($room->gallery as $slide)
                                                <div class="swiper-slide" style="max-height: 198px; max-wight: 350px;">
                                                    <figure style="height: 198px; wight: 350px;">
                                                        <img src="{{ $slide->image }}" class="h-100 w-100 rounded">
                                                    </figure>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                <h5 class="mb-3">{{ $room->name }}</h5>
                                <div class="features mb-2">
                                    <h5 class="mb-1">คุณสมบัติห้อง</h5>
                                    @foreach ($room->features as $fea)
                                        <span class="badge rounded-pill bg-light text-wrap text-dark"
                                            style="font-size: 14px; font-weight: 400;">
                                            {{ $fea->name }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="features mb-2">
                                    <h5 class="mb-1">จำนวนผู้เข้าพัก</h5>
                                    <span class="badge rounded-pill bg-light text-wrap text-dark"
                                        style="font-size: 14px; font-weight: 400;">
                                        ผู้ใหญ่ : {{ $room->adult }}
                                    </span>
                                    <span class="badge rounded-pill bg-light text-wrap text-dark"
                                        style="font-size: 14px; font-weight: 400;">
                                        เด็ก : {{ $room->children }}
                                    </span>
                                </div>
                                <div class="facilities mb-3">
                                    <h5 class="mb-1">สิ่งอำนวยความสะดวก</h5>
                                    @foreach ($room->facs as $fac)
                                        <img src="{{ $fac->icon }}" width=25 class="me-1 mb-2">
                                        <span class="badge rounded-pill bg-light text-wrap text-dark"
                                            style="font-size: 14px; font-weight: 400;">
                                            {{ $fac->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                                <h6 class="mb-4">฿ {{ $room->price }} </h6>

                                {{-- <button onclick="book({{ $room->id }})"
                                    class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">จองห้อง</button> --}}



                                <button onclick="book({{ $room->id }})"
                                    class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2"
                                    style="height: 40px; font-size: 18px;">จองห้อง</button>
                                <button id="recap-modal" data-bs-toggle="modal" data-bs-target="#reCaptcha"
                                    class="d-none btn btn-sm w-100 text-white custom-bg shadow-none mb-2"></button>

                                <button onclick="roomDetails({{ $room->id }})"
                                    class="btn btn-sm w-100 btn-outline-dark shadow-none">ดูรายละเอียด</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    <!-- Booking form Modal -->
    <div class="modal fade" id="reCaptcha" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return confirmreCaptcha(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ข้อมูลผู้จอง / รายละเอียด</h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 mb-0">
                            <div class="row">
                                <p class="invalid text-danger hidden"></p>
                                <div style="display: flex; align-items: center; justify-content: center;">
                                    <div class="g-recaptcha" data-sitekey="6Ld4nnspAAAAAAlI4h13-v8_I5tpZeUo4Y2DrVZa">
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-center">
                        <button onclick="closeModal()" type="button"
                            class="btn-close-modal btn bg-secondary text-white shadow-none"
                            data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit"
                            class="btn btn-confirm custom-bg d-flex align-items-center justify-content-center text-white shadow-none"
                            style="width: 117px;">
                            <div class="spinner-border loading d-none" role="status" style="width: 20px; height: 20px;">
                            </div>
                            <div class="text-btn-confirm">ยืนยัน</div>
                        </button>
                    </div>
                </div>
                <input class="bookingURL" type="hidden" name="bookingURL">


            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/frontoffice/rooms.js"></script>
    <script>
        var swiper = new Swiper(".swiper-gallery", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }
        });
    </script>
@endsection

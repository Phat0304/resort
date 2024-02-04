@extends('frontoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/rooms.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 my-3 px-4">
                <h2 class="fw-bold">ห้อง : {{ $room->name }}</h2>
                <div style="font-size: 14px;">
                    <a href="{{ route('home') }}" class="text-secondary text-decoration-none">หน้าหลัก</a>
                    <span class="text-secondary"> > </span>
                    <a href="{{ route('rooms') }}" class="text-secondary text-decoration-none">ห้องพัก</a>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 px-4">
                <div id="roomCarousel" class="carousel slide">
                    <div class="carousel-indicators">
                        @foreach ($room->gallery as $key => $slide)
                            <button type="button" data-bs-target="#roomCarousel" data-bs-slide-to="{{ $key }}"
                                class="{{ $slide->default === 1 ? 'active' : '' }} custom-bg"
                                aria-current="{{ $slide->default === 1 ? 'true' : '' }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($room->gallery as $slide)
                            <div class="carousel-item {{ $slide->default === 1 ? 'active' : '' }}">
                                <img src="{{ $slide->image }}" class="d-block w-100 h-100 rounded">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
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
                        <div class="facilities mb-2">
                            <h5 class="mb-1">สิ่งอำนวยความสะดวก</h5>
                            <div class="row">
                                @foreach ($room->facs as $fac)
                                    <div class="col-4 d-flex flex-column align-items-center gap-2 mb-2">
                                        <img src="{{ $fac->icon }}" width=30>
                                        <span class="badge rounded-pill bg-light text-wrap text-dark"
                                            style="font-size: 14px; font-weight: 400;">
                                            {{ $fac->name }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="filter mb-1">
                            <div class="container-fluid flex-lg-column bg-white py-2 rounded">
                                <form onsubmit="return checkroom(event)" id="form-search">
                                    <div class="border bg-light p-3 rounded mb-3">
                                        <label class="form-label" style="font-weight: 500;">เช็คอิน</label>
                                        <input type="date" name="checkin" min="{{ date('Y-m-d') }}" id="date-checkin"
                                            class="form-control shadow-none pointer mb-3" required>
                                        <label class="form-label" style="font-weight: 500;">เช็คเอ้าท์</label>
                                        <input type="date" class="form-control shadow-none pointer" name="checkout"
                                            id="date-checkout" required>
                                    </div>
                                    {{-- <div class="border bg-light p-3 rounded mb-3">
                                        <h5 class="mb-3" style="font-size: 18px;">จำนวนผู้เข้าพัก</h5>
                                        <div class="d-flex">
                                            <div class="row w-100">
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" style="font-weight: 500;">ผู้ใหญ่/คน</label>
                                                    <select class="form-select select shadow-none pointer text-center"
                                                        id="select-adult" name="adult" required>
                                                        <option value="1">1</option>
                                                        <option value="2" selected>2</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
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
                                    </div> --}}
                                    <div class="w-100 d-flex justify-content-center align-items-center">
                                        <div class="d-none">
                                            <button type="submit"
                                                class="btn text-white btn-search shadow-none custom-bg">ค้นหา</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <h6 class="d-none text-danger cant-book">ไม่สามารถจองห้องนี้ในวันเวลาที่เลือกได้ หรือ ห้องอาจไม่ว่าง
                        </h6>
                        {{-- <h6 class="text-success can-book">ห้องว่างอยู่ กดจองได้เลยจ้า</h6> --}}
                        <div class="d-flex justify-content-evenly">
                            <button onclick="booking({{ $room->id }})"
                                class="btn btn-sm text-white btn-book custom-bg w-100 fs-4"
                                style="height: 45px;">จองห้อง</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 px-4">
                <div class="mb-4 mt-3">
                    <h5>รายละเอียดห้อง</h5>
                    <p>{{ $room->description }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="js/frontoffice/room-details.js"></script>
    <script>
        const isAvailable = @json($isAvailable); // from laravel controller
        const details_only = @json($details_only); // from laravel controller

        const urlParams = new URLSearchParams(window.location.search);
        const date_checkin = document.getElementById("date-checkin");
        const date_checkout = document.getElementById("date-checkout");
        const btn_search = document.querySelector(".btn-search");
        const btn_book = document.querySelector(".btn-book");
        const cant_book = document.querySelector(".cant-book");

        let detailsURL = "";

        function setDateSelected(date_checkin) {
            const checkin = dayjs(date_checkin);
            const tomorrow = checkin.add(1, "day");
            const formatted = tomorrow.format("YYYY-MM-DD");

            date_checkout.setAttribute("min", formatted);
            date_checkout.removeAttribute("disabled");
        }

        const urls = {
            checkin: urlParams.get("checkin"),
            checkout: urlParams.get("checkout"),
            room_id: urlParams.get('id'),
        };

        const someNullParam = Object.values(urls).some((value) => value === null);

        if (someNullParam) {
            date_checkin.value = "";
            date_checkout.setAttribute("disabled", "");
            btn_book.setAttribute("disabled", "");
            detailsURL = '/roomdetails?id='
        } else {
            date_checkin.value = urls.checkin;
            date_checkout.value = urls.checkout;
            detailsURL =
                `/roomdetails?checkin=${urls.checkin}&checkout=${urls.checkout}&adult=${urls.adult}&children=${urls.children}&id=`

            setDateSelected(urls.checkin);
        }

        if (details_only) {
            btn_book.setAttribute("disabled", "");
            cant_book.classList.add('d-none')
        } else {
            if (!isAvailable) {
                btn_book.setAttribute("disabled", "");
                cant_book.classList.remove('d-none')
            } else {
                btn_book.removeAttribute("disabled");
                cant_book.classList.add('d-none')
            }
        }

        date_checkin.addEventListener("change", function() {
            if (date_checkout.value) {
                date_checkout.value = "";
            }
            btn_book.setAttribute("disabled", "");
            setDateSelected(date_checkin.value);
        });

        date_checkout.addEventListener("input", function(event) {
            btn_search.click();
        });

        function checkroom(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            const data = {
                checkin: formData.get("checkin"),
                checkout: formData.get("checkout"),
                room_id: urls.room_id,
            };

            window.location.href = `/roomdetails?checkin=${data.checkin}&checkout=${data.checkout}&id=${data.room_id}`;
        }

        function booking(_id) {
            const data = {
                checkin: urls.checkin,
                checkout: urls.checkout,
                room_id: urls.room_id,
            }

            window.location.href = `/bookingdetails?checkin=${data.checkin}&checkout=${data.checkout}&id=${data.room_id}`;
        }
    </script>
@endsection

@extends('frontoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/home.css">
@endsection

@section('content')
    <div class="container my-5 bg-white shadow rounded" style="">
        <div class="row">
            <div class="col-12 p-4">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="bi bi-search fs-3 me-2"></i>
                    <h5 class="">ค้นหารายการจอง</h5>
                </div>
            </div>
            <div class="col-12 pb-5">
                <form onsubmit="return search(event)">
                    <div class="row align-items-end justify-content-center">
                        <div class="col-lg-3 mb-3 mb-lg-0">
                            <label class="form-label" style="font-weight: 500;">เบอร์โทรศัพท์ที่ใช้ในการจอง</label>
                            <input type="number" name="phone" id="phone"
                                class="form-control shadow-none text-center pointer"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                onKeyPress="if(this.value.length>=10) return false;" minlength="10" required>
                        </div>
                        <div class="col-lg-3 mb-3 mb-lg-0">
                            <label class="form-label" style="font-weight: 500;">เลขประชาชน 4 ตัวท้าย</label>
                            <input type="number" name="four_id" id="card-id"
                                class="form-control shadow-none text-center pointer"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                onKeyPress="if(this.value.length>=4) return false;" minlength="4" required>
                        </div>


                        <div class="col-lg-1 col-md-1 mt-3 text-center">
                            <button type="submit" class="btn text-white shadow-none custom-bg">ค้นหา</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">ประวัติการจอง <span class="text-secondary">({{ count($bookings) }}
            รายการ)</span></h2>
    <div class="container">
        <div class="row">
            @foreach ($bookings as $book)
                <div class="col-lg-4 col-md-6 my-3">
                    <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5>ห้องพัก : {{ $book->room_title }}</h5>
                                <span class="badge rounded-pill bg-{{ $book->bg_color }}">{{ $book->status_name }}</span>
                            </div>
                            <h6 class="">รหัสการจอง : {{ $book->booking_number }}</h6>
                            <h6 class="">ชื่อผู้จอง : {{ $book->cus_fname . ' ' . $book->cus_lname }}</h6>
                            <h6 class="">เช็คอิน : {{ $book->date_checkin }}</h6>
                            <h6 class="">เช็คเอาท์ : {{ $book->date_checkout }}</h6>
                            <h6 class="">วันเวลาที่จอง : {{ $book->created_at }} </h6>
                            <h6 class="">จำนวนวันที่เข้าพัก : {{ $book->days }} คืน</h6>
                            <h6 class="">ราคา/คืน : {{ $book->price_per_date }} บาท</h6>
                            <h6 class="">ราคา : {{ $book->price }} บาท</h6>
                            <h6 class="mb-4">หมายเหตุ : {{ $book->note }} </h6>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const phone = localStorage.getItem('phone')
        const four_id = localStorage.getItem('four_id')



        const phone_input = document.querySelector('#phone')
        const cardId_input = document.querySelector('#card-id')

        phone_input.value = phone;
        cardId_input.value = four_id;

        function search(event) {
            event.preventDefault();

            localStorage.setItem('phone', phone_input.value)
            localStorage.setItem('four_id', cardId_input.value)

            window.location.href = `/bookingsearch?phone=${phone_input.value}&four_id=${cardId_input.value}`;
        }
    </script>
@endsection

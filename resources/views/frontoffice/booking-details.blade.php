@extends('frontoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/preview-img.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4 mb-3 px-2 ">
                <h2 class="fw-bold">รายละเอียดการจอง</h2>
                <div class="d-flex justify-content-between align-items-center">
                    <div style="font-size: 14px;">
                        <a href="{{ route('home') }}" class="text-secondary text-decoration-none">หน้าหลัก</a>
                        <span class="text-secondary"> > </span>
                        <a class="text-secondary text-decoration-none">การจอง</a>
                    </div>
                    <div class="d-flex justify-content-center align-items-center" style="font-size: 18px;">
                        <span class="text-warning" style="font-size: 16px;">ชำระเงินภายใน</span>
                        <div class="text-center" style="width: 65px;">
                            <span class="time-minute"></span>
                            <span class="">:</span>
                            <span class="time-second"></span>
                        </div>
                        <span class="">นาที</span>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row shadow p-4 mb-4">
                    <form onsubmit="return confirmBooking(event)" class="row">
                        <div class="col-lg-8 col-md-12 mb-0">
                            <h6>ข้อมูลผู้จอง / รายละเอียด</h6>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="mt-3">
                                        <label class="form-label" style="font-weight: 500;">*ชื่อ <span
                                                class="text-secondary">(ภาษาไทย)</span></label>
                                        <input name="fname" type="text" class="form-control form-room shadow-none"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="mt-3">
                                        <label class="form-label" style="font-weight: 500;">*นามสกุล <span
                                                class="text-secondary">(ภาษาไทย)</span></label>
                                        <input name="lname" type="text" class="form-control form-room shadow-none"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="mt-3">
                                        <label class="form-label" style="font-weight: 500;">*เบอร์โทรศัพท์</label>
                                        <input name="phone" type="number" class="form-control form-room shadow-none"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            onKeyPress="if(this.value.length>=10) return false;" minlength="10" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="mt-3">
                                        <label class="form-label" style="font-weight: 500;">*อีเมล</label>
                                        <input name="email" type="email" class="form-control form-room shadow-none"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="mt-3">
                                        <label class="form-label" style="font-weight: 500;">*เลขบัตรประชาชน <span
                                                class="text-secondary">(ใช้เป็นเลขอ้างอิงการจอง)</span></label>
                                        <input name="card_id" type="number" class="form-control form-room shadow-none "
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            onKeyPress="if(this.value.length>=13) return false;" minlength="13" required>
                                        <input type="hidden" id="four_id_input" name="four_id" value="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="mt-3">
                                        <label class="form-label" style="font-weight: 500;">Line ID <span
                                                class="text-secondary">(ถ้ามี)</span></label>
                                        <input name="line_id" type="text" class="form-control form-room shadow-none">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card mb-4 border-0">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-12 p-3 pb-0">
                                                <h6 class="text-secondary" style="font-size: 14px;">รายละเอียดการจอง</h6>
                                                <h6 style="font-size: 14px; font-weight: 300;">เช็คอิน :
                                                    {{ $checkin }}</h6>
                                                <h6 style="font-size: 14px; font-weight: 300;">เช็คเอาท์ :
                                                    {{ $checkout }}</h6>
                                                <h6 style="font-size: 14px; font-weight: 300;">คืน : {{ $diff_date }}
                                                </h6>
                                                <h6 style="font-size: 14px; font-weight: 300;">ราคา/คืน :
                                                    {{ $room->price }}
                                                </h6>
                                                <h6 style="font-size: 16px; font-weight: 500;">ราคาทั้งหมด :
                                                    {{ $room->price * $diff_date }} ฿</h6>
                                            </div>
                                        </div>
                                        <div class="row g-0 align-items-center">
                                            <div class="col-md-3 p-3">
                                                <img src="{{ $room->gallery[0]->image }}" class="h-100 w-100 rounded">
                                            </div>
                                            <div class="col-md-9 py-3 px-md-0 px-3">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <h6>{{ $room->name }}</h6>
                                                        <h6>{{ $room->price }} ฿</h6>
                                                    </div>
                                                    <div class="col-md-4 features mb-2">
                                                        <h6 class="mb-2" style="font-size: 12px;">คุณสมบัติห้อง</h6>
                                                        @foreach ($room->features as $fea)
                                                            <span class="badge rounded-pill bg-light text-wrap text-dark"
                                                                style="font-size: 12px; font-weight: 400;">
                                                                {{ $fea->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-md-2 features mb-2">
                                                        <h6 class="mb-1" style="font-size: 12px;">จำนวนผู้เข้าพัก</h6>
                                                        <span class="badge rounded-pill bg-light text-wrap text-dark"
                                                            style="font-size: 12px; font-weight: 400;">
                                                            ผู้ใหญ่ : {{ $room->adult }}
                                                        </span>
                                                        <span class="badge rounded-pill bg-light text-wrap text-dark"
                                                            style="font-size: 12px; font-weight: 400;">
                                                            เด็ก : {{ $room->children }}
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4 facilities mb-2">
                                                        <h6 class="mb-1" style="font-size: 12px;">สิ่งอำนวยความสะดวก
                                                        </h6>
                                                        @foreach ($room->facs as $fac)
                                                            <span class="badge rounded-pill bg-light text-wrap text-dark"
                                                                style="font-size: 12px; font-weight: 400;">
                                                                {{ $fac->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 mb-5">
                            <h6>การชำระเงิน</h6>
                            <div class="card mb-4 border-0">
                                <div class="row g-0 p-3 align-items-center justify-content-center">
                                    <h2 class="text-center">ที่ต้องชำระ {{ $room->price * $diff_date }} ฿</h2>
                                    <div class="col-md-10 mb-4">
                                        <img src="{{ $bank_details->bank_image }}"
                                            class="d-block w-100 h-100 mb-2 rounded">
                                        <h6>{{ $bank_details->bank_name }}</h6>
                                        <h6>ชื่อบัญชี : {{ $bank_details->account_name }}</h6>
                                        <h6>เลขที่บัญชี : {{ $bank_details->account_number }}</h6>
                                    </div>
                                    <div class="col-8 col-md-8 mb-4 border-secondary p-3 rounded"
                                        style="border-style: dashed;">
                                        {{-- <img src="/images/bank/slip-upload.png" class="d-block w-100 h-100 mb-2 rounded"> --}}
                                        <div class="group-image mb-3 h-auto">
                                            <figure class="image-upload shadow-sm bg-white">
                                                <input onchange="previewImg()" class="img-input" id="file1"
                                                    type="file" name="image" id="image"
                                                    accept="image/jpeg, image/png, image/jpg" required>
                                                <img class="" src="/images/bank/slip-upload.png" id="preview-img"
                                                    alt="" style="width: 100%;">
                                            </figure>
                                        </div>
                                        <h6 class="text-center text-slip">อัพโหลดสลิป</h6>
                                        <h6 class="text-center text-slip text-secondary"
                                            style="font-size: 13px; font-weight: 400;">(jpeg,png,jpg)</h6>
                                    </div>
                                    <h6 class="text-danger text-center not-available d-none">
                                        มีคนจองไปแล้วเมื่อสักครู่หากคุณชำระเงินไปแล้วกรุณา<span><a
                                                href="#">ติดต่อเจ้าหน้าที่</a></span>เพื่อขอรับเงินคืน</h6>




                                    <div class="col-8 col-md-8 mb-4 rounded">
                                        <div class="d-flex justify-content-evenly">
                                            <button type="submit"
                                                class="btn-sm text-white btn-confirm custom-bg w-100 fs-4 border-none d-flex justify-content-center align-items-center"
                                                style="height: 45px;">
                                                <div class="spinner-border loading d-none" role="status"></div>
                                                <span class="text-btn-confirm fs-md-5 fs-lg-4">ยืนยันการจอง</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="checkin" value="{{ $checkin }}">
                        <input type="hidden" name="checkout" value="{{ $checkout }}">
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        <input type="hidden" name="price" value="{{ $room->price * $diff_date }}">
                        <input type="hidden" name="price_per_date" value="{{ $room->price }}">
                        <input type="hidden" name="days" value="{{ $diff_date }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="/js/frontoffice/booking-details.js"></script> --}}
    <script src="/js/preview-img.js"></script>

    <script>
        // window.onload = () => {
        //     localStorage.clear();
        // }


        const minute_local = localStorage.minute;
        const second_local = localStorage.second;
        const isAvailable = @json($isAvailable); // from laravel controller








        const btn_confirm = document.querySelector(".btn-confirm");
        const loading = document.querySelector(".loading");
        const not_available = document.querySelector(".not-available");
        const text_confirm = document.querySelector(".text-btn-confirm");

        const show_minute = document.querySelector(".time-minute");
        const show_second = document.querySelector(".time-second");


        let minutes = minute_local ? parseInt(minute_local) : 15;
        let seconds = second_local ? parseInt(second_local) : 0;

        const interval = setInterval(() => {
            if (seconds % 10 === 0) {
                // check booking timeout
                axios.get(`/checkbooktimeout?temp_id=${temp_id}`).then((res) => {
                    console.log(res);
                }).catch(err => {
                    if (err.response.status === 408) {
                        clearInterval(interval);
                        localStorage.removeItem('minute');
                        localStorage.removeItem('second');
                        console.log('clear')
                        window.location.href = '/rooms'
                    };
                })
            }

            if (seconds < 0) {
                minutes--;
                seconds = 59;
            }
            if (minutes <= 0 && seconds <= 0) {
                clearInterval(interval);
                localStorage.removeItem('minute');
                localStorage.removeItem('second');
                console.log('clear')
                show_minute.innerText = '00';
                show_second.innerText = '00';

                setTimeout(() => {
                    axios.delete(`/deletetempbook/${temp_id}`).then((res) => {
                        window.location.href = '/rooms';
                    }).catch(err => console.log(err))
                }, 3000)
            } else {
                show_minute.innerText = minutes.toString().padStart(2, '0');
                show_second.innerText = seconds.toString().padStart(2, '0');
                seconds--;

                localStorage.setItem('minute', minutes);
                localStorage.setItem('second', seconds);
            }

        }, 1000);

        if (!isAvailable) {
            btn_confirm.classList.add('d-none');
            not_available.classList.remove('d-none')
        } else {
            btn_confirm.classList.remove('d-none');
            not_available.classList.add('d-none')
        }







        function confirmBooking(event) {

            event.preventDefault();

            //รับค่า card_id มา
            const card_id = document.querySelector('input[name="card_id"]').value;


            if (card_id.length >= 13) {

                const four_id = card_id.slice(-4); //เอาเลข 4 ตัวท้ายมา

                // ใส่ค่า four_id ลงใน <input> ที่มี name เป็น "four_id"
                document.querySelector('input[name="four_id"]').value = four_id;

            } else {
                console.log("ความยาวของ card_id ต้องไม่น้อยกว่า 13 ตัว");
                alert("เลขบัตรประชาชนไม่ถูกต้อง");
                document.querySelector('input[name="card_id"]').value = ''; // เคลียร์ค่าใน input
                return false;

            }

            const form = event.target;
            const formData = new FormData(form);



            clearInterval(interval);
            localStorage.removeItem('minute');
            localStorage.removeItem('second');

            btn_confirm.setAttribute('disabled', '')
            loading.classList.remove('d-none')
            text_confirm.classList.add('d-none')

            axios.post('/confirmbooking', formData).then(({
                data
            }) => {

                setTimeout(() => {
                    if (data.status) {
                        loading.classList.add('d-none')
                        localStorage.setItem('four_id', formData.get('four_id'))
                        localStorage.setItem('phone', formData.get('phone'))
                        Swal.fire({
                            title: 'จองห้องสำเร็จ!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href =
                                `/bookingsearch?phone=${formData.get('phone')}&four_id=${formData.get('four_id')}`;
                        })
                    }
                }, 500);
            }).catch(({
                response
            }) => {
                setTimeout(() => {
                    loading.classList.add('d-none')
                    if (response.status === 403) {
                        btn_confirm.classList.add('d-none');
                        not_available.classList.remove('d-none')
                        return false;
                    } else {
                        btn_confirm.classList.remove('d-none');
                        not_available.classList.add('d-none')
                        return false;
                    }
                }, 500);
            })
            // return;
        }
    </script>
@endsection

@extends('backoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/backoffice/managebook.css">
@endsection

@section('content')
    <h3><i class="bi bi-list-task"></i> ประวัติการจอง</h3>
    <div class="d-flex flex-column gap-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="card-title m-0 mb-4">
                        #ประวัติการจองทั้งหมด
                    </h5>
                    <div class="col-2 mb-3">
                        <select class="form-select select-booking-type shadow-none" id="admin-role" name="admin_role"
                            style="cursor: pointer;">
                            <option value="all">รายการจองทั้งหมด</option>
                            <option value="online">จองแบบออนไลน์</option>
                            <option value="walk-in">จองแบบ Walk-in</option>
                        </select>
                    </div>
                </div>

                {{-- Booking All --}}
                <table id="booking-all" class="table table-striped table-booking" type="all" style="width:100%">
                    <thead>
                        <tr>
                            <th>รหัสการจอง</th>
                            <th>เลขอ้างอิง</th>
                            <th>ชื่อผู้จอง</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>ห้อง</th>
                            <th>เช็คอิน - เช็คเอาท์</th>
                            <th>วันเวลาที่จอง</th>
                            <th>สถานะการจอง</th>
                            <th>slip</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td style="width: 100px;">{{ $booking->booking_number }}</td>
                                <td style="width: 100px;">{{ $booking->card_id }}</td>
                                <td style="width: 200px;">{{ $booking->cus_fname . ' ' . $booking->cus_lname }}</td>
                                <td>{{ $booking->cus_phone }}</td>
                                <td style="width: 200px;">
                                    <p>ห้อง : {{ $booking->room_name }}</p>
                                    <p>จำนวนวันที่เข้าพัก : {{ $booking->days }} วัน</p>
                                    <p>ราคา/คืน : {{ $booking->price_per_date }} บาท</p>
                                    <p>ราคารวม : {{ $booking->price }} บาท</p>
                                </td>
                                <td style="width: 260px;">
                                    <div class="checkdete">
                                        <p>เช็คอิน : {{ $booking->date_checkin }}</p>

                                        <p>เช็คเอาท์ : {{ $booking->date_checkout }}</p>
                                    </div>
                                </td>

                                <td style="width: 230px;">
                                    <div class="createAt">
                                        <p>{{ $booking->created_at }}</p>
                                    </div>
                                </td>
                                <td class="td-status">
                                    <span style="width: 112px;"
                                        class="badge rounded-pill d-flex align-items-center justify-content-between bg-{{ $booking->bg_color }}">{{ $booking->status_name }}
                                        <span><i class="bi bi-caret-down-fill"></i></span>
                                    </span>
                                    <select onchange="updateBookStatus(this, {{ $booking->id }})"
                                        class="form-select status-select shadow-none pointer" id="select-children"
                                        name="children" style="cursor: pointer; width: 112px; height: 22px;">
                                        @foreach ($statuses as $status)
                                            @if ($status->id === $booking->status_id)
                                                <option value="{{ $status->id }}" selected style="font-size: 14px;">
                                                    {{ $status->name }}</option>
                                            @else
                                                <option value="{{ $status->id }}" style="font-size: 14px;">
                                                    {{ $status->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td><img onclick="previewSlip('{{ $booking->slip }}')" src="{{ $booking->slip }}"
                                        width="100%" style="width: 126px; cursor: pointer;"></td>
                                <td class="">
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center gap-2"
                                        style="height: 163px !important;">
                                        <button class="btn-modal btn btn-primary shadow-none" data-bs-toggle="modal"
                                            onclick="getBooking(this, {{ $booking->id }})" data-bs-target="#message-s"><i
                                                class="bi bi-eye-fill"></i></button>


                                        @if ($shareUser->admin_role === 'แอดมินสูงสุด')
                                            <button class="btn btn-danger shadow-none"
                                                onclick="deleteBooking(this, {{ $booking->id }})"><i
                                                    class="bi bi-trash-fill"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Booking Online --}}
                <table id="booking-online" class="table table-striped table-booking" type="online" style="width:100%">
                    <thead>
                        <tr>
                            <th>รหัสการจอง</th>
                            <th>เลขอ้างอิง</th>
                            <th>ชื่อผู้จอง</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>ห้อง</th>
                            <th>เช็คอิน - เช็คเอาท์</th>
                            <th>วันเวลาที่จอง</th>
                            <th>สถานะการจอง</th>
                            <th>slip</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking_online as $booking)
                            <tr>
                                <td style="width: 100px;">{{ $booking->booking_number }}</td>
                                <td style="width: 100px;">{{ $booking->card_id }}</td>
                                <td style="width: 200px;">{{ $booking->cus_fname . ' ' . $booking->cus_lname }}</td>
                                <td>{{ $booking->cus_phone }}</td>
                                <td style="width: 200px;">
                                    <p>ห้อง : {{ $booking->room_name }}</p>
                                    <p>จำนวนวันที่เข้าพัก : {{ $booking->days }} วัน</p>
                                    <p>ราคา/คืน : {{ $booking->price_per_date }} บาท</p>
                                    <p>ราคารวม : {{ $booking->price }} บาท</p>
                                </td>
                                <td style="width: 260px;">
                                    <div class="checkdete">
                                        <p>เช็คอิน : {{ $booking->date_checkin }}</p>

                                        <p>เช็คเอาท์ : {{ $booking->date_checkout }}</p>
                                    </div>
                                </td>

                                <td style="width: 230px;">
                                    <div class="createAt">
                                        <p>{{ $booking->created_at }}</p>
                                    </div>
                                </td>
                                <td class="td-status">
                                    <span style="width: 112px;"
                                        class="badge rounded-pill d-flex align-items-center justify-content-between bg-{{ $booking->bg_color }}">{{ $booking->status_name }}
                                        <span><i class="bi bi-caret-down-fill"></i></span>
                                    </span>
                                    <select onchange="updateBookStatus(this, {{ $booking->id }})"
                                        class="form-select status-select shadow-none pointer" id="select-children"
                                        name="children" style="cursor: pointer; width: 112px; height: 22px;">
                                        @foreach ($statuses as $status)
                                            @if ($status->id === $booking->status_id)
                                                <option value="{{ $status->id }}" selected style="font-size: 14px;">
                                                    {{ $status->name }}</option>
                                            @else
                                                <option value="{{ $status->id }}" style="font-size: 14px;">
                                                    {{ $status->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td><img onclick="previewSlip('{{ $booking->slip }}')" src="{{ $booking->slip }}"
                                        width="100%" style="width: 126px; cursor: pointer;"></td>
                                <td class="">
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center gap-2"
                                        style="height: 163px !important;">
                                        <button class="btn-modal btn btn-primary shadow-none" data-bs-toggle="modal"
                                            onclick="getBooking(this, {{ $booking->id }})" data-bs-target="#message-s"><i
                                                class="bi bi-eye-fill"></i></button>
                                        @if ($shareUser->admin_role === 'แอดมินสูงสุด')
                                            <button class="btn btn-danger shadow-none"
                                                onclick="deleteBook(this, {{ $booking->id }})"><i
                                                    class="bi bi-trash-fill"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Booking walkin --}}
                <table id="booking-walkin" class="table table-striped table-booking" type="walkin" style="width:100%">
                    <thead>
                        <tr>
                            <th>รหัสการจอง</th>
                            <th>เลขอ้างอิง</th>
                            <th>ชื่อผู้จอง</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>ห้อง</th>
                            <th>เช็คอิน - เช็คเอาท์</th>
                            <th>วันเวลาที่จอง</th>
                            <th>สถานะการจอง</th>
                            <th>slip</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking_walkin as $booking)
                            <tr>
                                <td style="width: 100px;">{{ $booking->booking_number }}</td>
                                <td style="width: 100px;">{{ $booking->card_id }}</td>
                                <td style="width: 200px;">{{ $booking->cus_fname . ' ' . $booking->cus_lname }}</td>
                                <td>{{ $booking->cus_phone }}</td>
                                <td style="width: 200px;">
                                    <p>ห้อง : {{ $booking->room_name }}</p>
                                    <p>จำนวนวันที่เข้าพัก : {{ $booking->days }} วัน</p>
                                    <p>ราคา/คืน : {{ $booking->price_per_date }} บาท</p>
                                    <p>ราคารวม : {{ $booking->price }} บาท</p>
                                </td>
                                <td style="width: 260px;">
                                    <div class="checkdete">
                                        <p>เช็คอิน : {{ $booking->date_checkin }}</p>

                                        <p>เช็คเอาท์ : {{ $booking->date_checkout }}</p>
                                    </div>
                                </td>

                                <td style="width: 230px;">
                                    <div class="createAt">
                                        <p>{{ $booking->created_at }}</p>
                                    </div>
                                </td>
                                <td class="td-status">
                                    <span style="width: 112px;"
                                        class="badge rounded-pill d-flex align-items-center justify-content-between bg-{{ $booking->bg_color }}">{{ $booking->status_name }}
                                        <span><i class="bi bi-caret-down-fill"></i></span>
                                    </span>
                                    <select onchange="updateBookStatus(this, {{ $booking->id }})"
                                        class="form-select status-select shadow-none pointer" id="select-children"
                                        name="children" style="cursor: pointer; width: 112px; height: 22px;">
                                        @foreach ($statuses as $status)
                                            @if ($status->id === $booking->status_id)
                                                <option value="{{ $status->id }}" selected style="font-size: 14px;">
                                                    {{ $status->name }}</option>
                                            @else
                                                <option value="{{ $status->id }}" style="font-size: 14px;">
                                                    {{ $status->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td><img onclick="previewSlip('{{ $booking->slip }}')" src="{{ $booking->slip }}"
                                        width="100%" style="width: 126px; cursor: pointer;"></td>
                                <td class="">
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center gap-2"
                                        style="height: 163px !important;">
                                        <button class="btn-modal btn btn-primary shadow-none" data-bs-toggle="modal"
                                            onclick="getBooking(this, {{ $booking->id }})"
                                            data-bs-target="#message-s"><i class="bi bi-eye-fill"></i></button>
                                        @if ($shareUser->admin_role === 'แอดมินสูงสุด')
                                            <button class="btn btn-danger shadow-none"
                                                onclick="deleteBook(this, {{ $booking->id }})"><i
                                                    class="bi bi-trash-fill"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Show message Modal -->
    <div class="modal fade" id="message-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">รายละเอียดการจอง</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">รหัสการจอง</label>
                                    <input name="booking_number" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">เลขอ้างอิง</label>
                                    <input name="card_id" type="number"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">ห้อง</label>
                                    <input name="room" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">เช็คอิน</label>
                                    <input name="checkin" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">เช็คเอาท์</label>
                                    <input name="checkout" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">จำนวนวันที่เข้าพัก (วัน)</label>
                                    <input name="days" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">ราคารวม (บาท)</label>
                                    <input name="price" type="number"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">วันเวลาที่จอง</label>
                                    <input name="booking_date" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">สถานะการจอง</label>
                                    <input name="status" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">ชื่อผู้จอง</label>
                                    <input name="cus_name" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">อีเมล</label>
                                    <input name="email" type="email"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">Line ID</label>
                                    <input name="line_id" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">การชำระเงิน</label>
                                    <input name="payment_type" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">ประเภทการจอง</label>
                                    <input name="payment_type" type="text"
                                        class="form-control form-booking shadow-none text-center" readonly>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-close-modal btn btn-secondary shadow-none"
                            data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/backoffice/managebook.js"></script>
@endsection

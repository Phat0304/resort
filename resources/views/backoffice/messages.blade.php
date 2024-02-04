@extends('backoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/backoffice/carousel.css">
@endsection

@section('content')
    <h3><i class="bi bi-images"></i> กล่องข้อความ</h3>

    <div class="d-flex flex-column gap-3">
        <!-- Message section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 mb-4">
                        #ข้อความทั้งหมด
                    </h5>
                </div>
                <table id="messages" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>วันที่ส่ง</th>
                            <th>ชื่อ</th>
                            <th>อีเมล</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>หัวข้อเรื่อง</th>
                            <th>ข้อความ</th>
                            <th>สถานะ</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <td style="width: 100px;">{{ $message->send_date }}</td>
                                <td style="width: 200px;">{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td style="width: 100px;">{{ $message->phone }}</td>
                                <td>{{ $message->subject }}</td>
                                <td style="width: 300px;">{{ $message->submsg }}...</td>
                                <td>
                                    <span
                                        class="badge rounded-pill {{ $message->seen ? 'bg-secondary' : 'bg-warning text-dark' }}">
                                        {{ $message->seen ? 'อ่านแล้ว' : 'ยังไม่อ่าน' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-modal btn btn-primary shadow-none" data-bs-toggle="modal" onclick="getMessage(this, {{ $message->id }})"
                                        data-bs-target="#message-s"><i class="bi bi-eye-fill"></i></button>
                                    <button class="btn btn-danger shadow-none" onclick="deleteMessage(this, {{ $message->id }})"><i class="bi bi-trash-fill"></i></button>
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
                        <h5 class="modal-title">รายละเอียดข้อความ</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">ชื่อ</label>
                            <input name="name" type="text" class="form-control form-msg shadow-none" readonly>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">อีเมล</label>
                                    <input name="email" type="email" class="form-control form-msg shadow-none" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">เบอร์โทร</label>
                                    <input name="phone" type="number" class="form-control form-msg shadow-none"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=10) return false;" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">หัวข้อเรื่อง</label>
                            <input name="subject" type="text" class="form-control form-msg shadow-none" readonly>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">ข้อความ</label>
                            <textarea name="message" class="form-control form-msg shadow-none" rows="5" style="resize: none;" readonly></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-close-modal btn btn-secondary shadow-none" data-bs-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/backoffice/messages.js"></script>
@endsection

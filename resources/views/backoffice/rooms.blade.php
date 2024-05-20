@extends('backoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/backoffice/rooms.css">
    <link rel="stylesheet" href="css/preview-img.css">
@endsection

@section('content')
    <h3><i class="bi bi-hospital-fill"></i> ห้องพัก</h3>

    <div class="d-flex flex-column gap-3">
        <!-- Rooms section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between ">
                    <h5 class="card-title m-0 mb-4">
                        #ห้องทั้งหมด
                    </h5>
                    <button type="button" class="btn btn-dark shadow-none btn-md" data-bs-toggle="modal"
                        data-bs-target="#room-s">
                        <i class="bi bi-plus-square"> </i> เพิ่มห้อง
                    </button>
                </div>

                <table id="rooms" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อ</th>
                            <th>ราคา</th>
                            <th>จำนวนผู้ใหญ่</th>
                            <th>จำนวนเด็ก</th>
                            <th>พื้นที่ห้อง (ตร.ม)</th>
                            <th>สถานะการเปิดใช้งาน</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td style="width: 100px;">{{ $room->id }}</td>
                                <td style="width: 200px;">{{ $room->name }}</td>
                                <td style="width: 200px;">{{ $room->price }}</td>
                                <td style="width: 200px;">{{ $room->adult }}</td>
                                <td style="width: 200px;">{{ $room->children }}</td>
                                <td style="width: 200px;">{{ $room->area }}</td>
                                <td style="width: 200px;">
                                    <div class="form-check form-switch">
                                        <input onchange="upd_room_display({{ $room->id }}, this.checked)"
                                            isChecked="{{ $room->display }}"
                                            class="form-check-input room-checked shadow-none" type="checkbox"
                                            id="room-toggle" style="cursor: pointer;">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn-modal btn btn-warning shadow-none" data-bs-toggle="modal"
                                            onclick="getRoom('{{ $room->id }}')" data-bs-target="#roomedit-s"><i
                                                class="bi bi-pencil-square"></i></button>
                                        <button onclick="getGallery('{{ $room->id }}')"
                                            class="btn-modal btn btn-info shadow-none" data-bs-toggle="modal"
                                            data-bs-target="#images-s"><i class="bi bi-images"></i></button>


                                        @if ($shareUser->admin_role === 'แอดมินสูงสุด')
                                            <button class="btn btn-danger shadow-none"
                                                onclick="deleteRoom({{ $room->id }})"><i
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

    <!-- Create room Modal -->
    <div class="modal fade" id="room-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog d-flex justify-content-center">
            <form onsubmit="return createRoom(event)">
                <div class="modal-content" style="width: 663px;">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่มห้องพัก</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">ชื่อห้อง</label>
                                    <input name="name" type="text"
                                        class="form-control form-room text-center shadow-none" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">ราคา/คืน</label>
                                    <input name="price" type="number"
                                        class="form-control form-room text-center shadow-none"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=8) return false;" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">จำนวนผู้ใหญ่</label>
                                    <input name="adult" type="number"
                                        class="form-control form-room shadow-none text-center"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=8) return false;" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">จำนวนเด็ก</label>
                                    <input name="children" type="number"
                                        class="form-control form-room shadow-none text-center"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=8) return false;" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">พื้นที่ห้อง (ตร.ม)</label>
                                    <input name="area" type="text"
                                        class="form-control form-room shadow-none text-center"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=8) return false;" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">คุณสมบัติห้อง</label>
                            <div class="row select-feature">
                                @foreach ($features as $feature)
                                    <div class="col-md-3 mb-2">
                                        <label>
                                            <input class="form-check-input feature-checked shadow-none" type="checkbox"
                                                value="{{ $feature->id }}">
                                            {{ $feature->name }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">สิ่งอำนวยความสะดวก</label>
                            <div class="row select-fac">
                                @foreach ($facilities as $fac)
                                    <div class="col-md-3 mb-2">
                                        <label>
                                            <input class="form-check-input fac-checked shadow-none" type="checkbox"
                                                value="{{ $fac->id }}">
                                            {{ $fac->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">รายละเอียดห้อง</label>
                            <textarea name="description" class="form-control form-room shadow-none" rows="5" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeModal()" type="button"
                            class="btn-close-modal btn btn-secondary shadow-none" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit room Modal -->
    <div class="modal fade" id="roomedit-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog d-flex justify-content-center">
            <form onsubmit="return updateRoom(event)">
                <div class="modal-content" style="width: 665px;">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่มห้องพัก</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">ชื่อห้อง</label>
                                    <input name="name" id="room-name" type="text"
                                        class="form-control form-room text-center shadow-none" required>
                                    <input name="room_id" id="room-id" type="hidden">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">ราคา/คืน</label>
                                    <input name="price" id="room-price" type="number"
                                        class="form-control form-room text-center shadow-none"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=8) return false;" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">จำนวนผู้ใหญ่</label>
                                    <input name="adult" type="number" id="room-adult"
                                        class="form-control form-room shadow-none text-center"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=8) return false;" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">จำนวนเด็ก</label>
                                    <input name="children" type="number" id="room-children"
                                        class="form-control form-room shadow-none text-center"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=8) return false;" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mt-3">
                                    <label class="form-label" style="font-weight: 500;">พื้นที่ห้อง (ตร.ม)</label>
                                    <input name="area" type="text" id="room-area"
                                        class="form-control form-room shadow-none text-center"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=8) return false;" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">คุณสมบัติห้อง</label>
                            <div class="row select-feature">
                                @foreach ($features as $feature)
                                    <div class="col-md-3 mb-2">
                                        <label>
                                            <input class="form-check-input featureedit-checked shadow-none"
                                                type="checkbox" value="{{ $feature->id }}">
                                            {{ $feature->name }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">สิ่งอำนวยความสะดวก</label>
                            <div class="row select-fac">
                                @foreach ($facilities as $fac)
                                    <div class="col-md-3 mb-2">
                                        <label>
                                            <input class="form-check-input facedit-checked shadow-none" type="checkbox"
                                                value="{{ $fac->id }}">
                                            {{ $fac->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">รายละเอียดห้อง</label>
                            <textarea name="description" id="room-des" class="form-control form-room shadow-none" rows="5"
                                style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeModal()" type="button"
                            class="btn-close-modal btn btn-secondary shadow-none" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Room image Modal -->
    <div class="modal fade" id="images-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return addImage(event)">
                <div class="modal-content" style="min-height: 665px; ">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title m-title" id="m-title"></h5>
                    </div>
                    <div class="modal-body">



                        <div class="row d-flex justify-content-center">
                            <div class="col-6 d-flex flex-column justify-content-center">
                                <div class="group-image mb-3">
                                    <figure class="image-upload shadow bg-white">
                                        <input onchange="previewImg(0)" class="img-input" id="file1" type="file"
                                            name="image" id="image" accept="image/jpeg, image/png, image/jpg"
                                            required>
                                        <img class="" src="/images/rooms/thumbnail.jpg" id="preview-img"
                                            alt="" style="width: 100%;">
                                    </figure>
                                </div>
                                <input id="room-id-edit" type="hidden" name="room_id" value="">
                                <button type="submit" class="btn custom-bg text-white shadow-none mb-3"
                                    style="">เพิ่มรูปภาพ</button>
                            </div>
                        </div>



                        <div class="" style="max-height: 500px; overflow: auto;">
                            <table class="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">รูปภาพ</th>
                                        <th scope="col">รูปภาพเริ่มต้น</th>
                                        <th scope="col">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal()"
                            class="btn-close-modal btn btn-secondary shadow-none" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/backoffice/rooms.js"></script>
    <script src="/js/preview-img.js"></script>
@endsection

@extends('backoffice.layouts.main-layout')

@section('style')
@endsection

@section('content')
    <h3><i class="bi bi-gear-fill"></i> การตั้งค่า</h3>

    <div class="d-flex flex-column gap-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 mb-4">
                        ตั้งค่าทั่วไป
                    </h5>
                    <button onclick="initData()" type="button" class="btn btn-dark shadow-none btn-sm"
                        data-bs-toggle="modal" data-bs-target="#general-s">
                        <i class="bi bi-pencil-square"> </i> แก้ไข
                    </button>
                </div>
                <h6 class="card-subtitle mb-2 fw-bold">ชื่อเว็บไซต์</h6>
                <p class="card-text">{{ $site->site_title }}</p>
                <h6 class="card-subtitle mb-2 fw-bold">เกี่ยวกับเว็บไซต์</h6>
                <p class="card-text">{{ $site->site_about }}</p>
            </div>
            <input type="hidden" id="title" value="{{ $site->site_title }}">
            <input type="hidden" id="about" value="{{ $site->site_about }}">
        </div>

        <!-- shutdown -->
        {{-- <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 mb-4">
                        ปิดเว็บไซต์
                    </h5>
                    <div class="form-check form-switch">
                        <input onchange="upd_shutdown(this.checked)" isChecked="{{ $site->shutdown }}" class="form-check-input shadow-none" type="checkbox" id="shutdown-toggle">
                    </div>
                </div>
                <p class="card-text">เมื่อปิดการใช้งานเว็บไซต์ จะไม่สามารถใช้งานเว็บไซต์ได้</p>
            </div>
        </div> --}}

        <!-- Contact details section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 mb-4">
                        ตั้งค่าข้อมูลการติดต่อ
                    </h5>
                    <button onclick="initContactData()" type="button" class="btn btn-dark shadow-none btn-sm"
                        data-bs-toggle="modal" data-bs-target="#contacts-s">
                        <i class="bi bi-pencil-square"> </i> แก้ไข
                    </button>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <h6 class="card-subtitle mb-2 fw-bold">ที่อยู่</h6>
                            <p class="card-text" id="address">{{ $contact->address }}</p>
                        </div>
                        <div class="mb-4">
                            <h6 class="card-subtitle mb-2 fw-bold">Google Map</h6>
                            <p class="card-text" id="gmap">{{ $contact->gmap }}</p>
                        </div>
                        <div class="mb-4">
                            <h6 class="card-subtitle mb-2 fw-bold">เบอร์โทร</h6>
                            <p class="card-text mb-1">
                                <i class="bi bi-telephone-fill me-1"></i>
                                <span id="tel1">{{ $contact->phone1 }}</span>
                            </p>
                            <p class="card-text">
                                <i class="bi bi-telephone-fill me-1"></i>
                                <span id="tel2">{{ $contact->phone2 }}</span>
                            </p>
                        </div>
                        <div class="mb-4">
                            <h6 class="card-subtitle mb-2 fw-bold">E-mail</h6>
                            <p class="card-text" id="email">{{ $contact->email }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <h6 class="card-subtitle mb-2 fw-bold">Social Links</h6>
                            <p class="card-text mb-1">
                                <i class="bi bi-line me-1"></i>
                                <span id="line">{{ $contact->line }}</span>
                            </p>
                            <p class="card-text mb-1">
                                <i class="bi bi-facebook me-1"></i>
                                <span id="facebook">{{ $contact->fb }}</span>
                            </p>
                            <p class="card-text mb-1">
                                <i class="bi bi-instagram me-1"></i>
                                <span id="ig">{{ $contact->ig }}</span>
                            </p>
                        </div>
                        <div class="mb-4">
                            <h6 class="card-subtitle mb-2 fw-bold">iFrame</h6>
                            <iframe src="{{ $contact->iframe }}" class="border p-2 w-100" height="250" loading="lazy" id="iframe"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- General settins Modal -->
    <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return onUpdateSite(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ตั้งค่าทั่วไป</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">ชื่อเว็บไซต์ :</label>
                            <input type="text" name="site_title" class="form-title form-control shadow-none"
                                value="{{ $site->site_title }}" required>
                            <input id="site_id" type="hidden" name="site_id" class="form-control shadow-none"
                                value="{{ $site->id }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">เกี่ยวกับเว็บไซต์ :</label>
                            <textarea name="site_about" class="form-about form-control shadow-none" rows="6" required>{{ $site->site_about }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-close-modal btn btn-secondary shadow-none"
                            data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Contact settins Modal -->
    <div class="modal fade" id="contacts-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 1000px">
            <form onsubmit="return onUpdateContact(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ตั้งค่าข้อมูลการติดต่อ</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">ที่อยู่ :</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-address"><i class="bi bi-geo-fill"></i></span>
                                        <input id="form-contact" type="text" name="address" class="form-title form-control shadow-none" aria-describedby="basic-address"
                                            value="{{ $contact->address }}" required>
                                        <input id="contact_id" type="hidden" name="contact_id" class="form-control shadow-none"
                                            value="{{ $contact->id }}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Google Map :</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-gmap"><i class="bi bi-geo-alt-fill"></i></span>
                                        <input id="form-contact" type="text" name="gmap" class="form-title form-control shadow-none" aria-describedby="basic-gmap"
                                            value="{{ $contact->gmap }}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">เบอร์โทร 1 :</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-phone1"><i class="bi bi-telephone-fill"></i></span>
                                        <input id="form-contact" type="text" name="phone1" class="form-title form-control shadow-none" aria-describedby="basic-phone1"
                                            value="{{ $contact->phone1 }}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">เบอร์โทร 2 :</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-phone2"><i class="bi bi-telephone-fill"></i></span>
                                        <input id="form-contact" type="text" name="phone2" class="form-title form-control shadow-none" aria-describedby="basic-phone2"
                                            value="{{ $contact->phone2 }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">อีเมล์ :</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-email"><i class="bi bi-envelope-at-fill"></i></span>
                                        <input id="form-contact" type="email" name="email" class="form-title form-control shadow-none" aria-describedby="basic-email"
                                            value="{{ $contact->email }}">

                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Social Links :</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-line"><i class="bi bi-line"></i></span>
                                        <input id="form-contact" type="text" name="line" class="form-title form-control shadow-none" aria-describedby="basic-line"
                                            value="{{ $contact->line }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-fb"><i class="bi bi-facebook"></i></span>
                                        <input id="form-contact" type="text" name="fb" class="form-title form-control shadow-none" aria-describedby="basic-fb"
                                            value="{{ $contact->fb }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-ig"><i class="bi bi-instagram"></i></span>
                                        <input id="form-contact" type="text" name="ig" class="form-title form-control shadow-none" aria-describedby="basic-ig"
                                            value="{{ $contact->ig }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">iFrame(src) :</label>
                                    <textarea id="form-contact" name="iframe" class="form-contact form-control shadow-none" rows="10" required>{{ $contact->iframe }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-close-modal btn btn-secondary shadow-none"
                            data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('script')
    <script src="/js/backoffice/settings.js"></script>
@endsection

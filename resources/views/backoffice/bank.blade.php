@extends('backoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/backoffice/bank.css">
@endsection

@section('content')
    <h3><i class="bi bi-bank"></i> บัญชีธนาคาร</h3>
    <div class="d-flex flex-column gap-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="mt-5">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 mb-4">
                            #บัญชีธนาคารทั้งหมด
                        </h5>
                        <button type="button" class="btn btn-dark shadow-none btn-md" data-bs-toggle="modal"
                            data-bs-target="#bank-s">
                            <i class="bi bi-plus-square"> </i> เพิ่มบัญชีธนาคาร
                        </button>
                    </div>
                    <table id="bank" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 200px;">ลำดับความสำคัญ</th>
                                <th>QR code</th>
                                <th>ชื่อธนาคาร</th>
                                <th>ชื่อบัญชี</th>
                                <th>เลขบัญชี</th>
                                <th>การแสดงผล</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banks as $bank)
                                <tr>
                                    <td>{{ $bank->priority }}</td>
                                    <td>
                                        <figure style="width: 70px; height: 70px; cursor: pointer;"
                                            onclick="previewBank('{{ $bank->bank_image }}')">
                                            <img src="{{ $bank->bank_image }}" width="100%">
                                        </figure>
                                    </td>
                                    <td>{{ $bank->bank_name }}</td>
                                    <td>{{ $bank->account_name }}</td>
                                    <td>{{ $bank->account_number }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input onchange="updBankDisplay({{ $bank->id }}, this.checked)"
                                                isChecked="{{ $bank->display }}"
                                                class="form-check-input bank-checked shadow-none" type="checkbox"
                                                id="feature-toggle" style="cursor: pointer;">
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn-modal btn btn-warning shadow-none" data-bs-toggle="modal"
                                            onclick="getBank({{ $bank->id }})" data-bs-target="#bankedit-s"><i
                                                class="bi bi-pen-fill"></i></button>
                                        <button class="btn btn-danger shadow-none"
                                            onclick="deleteBank(this, {{ $bank->id }})"><i
                                                class="bi bi-trash-fill"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Bank Modal -->
    <div class="modal fade" id="bank-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return createBank(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่มบัญชีธนาคาร</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <label class="form-label mb-2 text-center">ภาพพร้อมเพย์ธนาคาร <br> ( QR code )</label>
                            <div class="col-6">
                                <div class="group-image mb-3">
                                    <figure class="image-upload shadow bg-white">
                                        <input onchange="previewImg()" class="img-input" id="file1" type="file"
                                            name="image" id="image" accept="image/jpeg, image/png, image/jpg"
                                            required>
                                        <img class="" src="/images/istockphoto.jpg" id="preview-img" alt=""
                                            style="width: 100%;">
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <select class="form-select shadow-none pointer text-center" id="select-bankname"
                                        name="bankname" required>
                                        <option value="">-- เลือกธนาคาร --</option>
                                        <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                                        <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                                        <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                                        <option value="ธนาคารทหารไทย">ธนาคารทหารไทย</option>
                                        <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                                        <option value="ธนาคารกรุงศรีอยุธยา">ธนาคารกรุงศรีอยุธยา</option>
                                        <option value="ธนาคารเกียรตินาคิน">ธนาคารเกียรตินาคิน</option>
                                        <option value="ธนาคารออมสิน">ธนาคารออมสิน</option>
                                        <option value="ธนาคารซีไอเอ็มบีไทย">ธนาคารซีไอเอ็มบีไทย</option>
                                        <option value="ธนาคารธนชาต">ธนาคารธนชาต</option>
                                        <option value="ธนาคารอาคารสงเคราะห์">ธนาคารอาคารสงเคราะห์</option>
                                        <option value="ธนาคารยูโอบี">ธนาคารยูโอบี</option>
                                        <option value="ธนาคารทิสโก้">ธนาคารทิสโก้</option>
                                        <option value="ธนาคารสแตนดาร์ดชาร์เตอร์ด(ไทย)">ธนาคารสแตนดาร์ดชาร์เตอร์ด(ไทย)
                                        </option>
                                        <option value="ธนาคารไทยเครดิตเพื่อรายย่อย">ธนาคารไทยเครดิตเพื่อรายย่อย</option>
                                        <option value="ธนาคารแลนด์แอนด์เฮาส์">ธนาคารแลนด์ แอนด์ เฮาส์</option>
                                        <option value="ธนาคารไอซีบีซี(ไทย)">ธนาคารไอซีบีซี (ไทย)</option>
                                        <option value="ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย">
                                            ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย</option>
                                        <option value="ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร">
                                            ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร</option>
                                        <option value="ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย">
                                            ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย</option>
                                        <option value="ธนาคารอิสลามแห่งประเทศไทย">ธนาคารอิสลามแห่งประเทศไทย</option>
                                        <option value="ธนาคารแห่งประเทศจีน">ธนาคารแห่งประเทศจีน</option>
                                        <option value="ธนาคารซูมิโตโมมิตซุยทรัสต์(ไทย)">ธนาคารซูมิโตโม มิตซุย ทรัสต์ (ไทย)
                                        </option>
                                        <option value="ธนาคารฮ่องกงและเซี้ยงไฮ้แบงกิ้งคอร์ปอเรชั่นจำกัด">
                                            ธนาคารฮ่องกงและเซี้ยงไฮ้แบงกิ้งคอร์ปอเรชั่น จำกัด</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">ชื่อบัญชีธนาคาร</label>
                                <input type="text" name="account_name" id="account-name"
                                    class="form-title form-control shadow-none text-center" required>
                            </div>
                            <div class="col-7 mb-3">
                                <label class="form-label">เลขที่บัญชี</label>
                                <input type="text" name="account_number" id="account-number"
                                    placeholder="123-4-56789-0" class="form-title form-control shadow-none text-center"
                                    required>
                            </div>
                            <div class="col-5 mb-3">
                                <label class="form-label">ลำดับความสำคัญ</label>
                                <input type="number" name="priority" id="priority"
                                    class="form-title form-control shadow-none text-center"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    onKeyPress="if(this.value.length>=10) return false;" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal()"
                            class="btn-close-modal btn btn-secondary shadow-none" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Bank Modal -->
    <div class="modal fade" id="bankedit-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return updateBank(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">แก้ไขบัญชีธนาคาร</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <label class="form-label mb-2 text-center">ภาพพร้อมเพย์ธนาคาร <br> ( QR code )</label>
                            <div class="col-6">
                                <div class="group-image mb-3">
                                    <figure class="image-upload shadow bg-white">
                                        <input onchange="previewImg(1)" class="img-input" id="file1" type="file"
                                            name="image" id="image" accept="image/jpeg, image/png, image/jpg">
                                        <img class="" src="/images/istockphoto.jpg" id="preview-img"
                                            alt="" style="width: 100%;">
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <select class="form-select shadow-none pointer text-center" id="select-bankname"
                                        name="bankname" required>
                                        <option value="">-- เลือกธนาคาร --</option>
                                        <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                                        <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                                        <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                                        <option value="ธนาคารทหารไทย">ธนาคารทหารไทย</option>
                                        <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                                        <option value="ธนาคารกรุงศรีอยุธยา">ธนาคารกรุงศรีอยุธยา</option>
                                        <option value="ธนาคารเกียรตินาคิน">ธนาคารเกียรตินาคิน</option>
                                        <option value="ธนาคารออมสิน">ธนาคารออมสิน</option>
                                        <option value="ธนาคารซีไอเอ็มบีไทย">ธนาคารซีไอเอ็มบีไทย</option>
                                        <option value="ธนาคารธนชาต">ธนาคารธนชาต</option>
                                        <option value="ธนาคารอาคารสงเคราะห์">ธนาคารอาคารสงเคราะห์</option>
                                        <option value="ธนาคารยูโอบี">ธนาคารยูโอบี</option>
                                        <option value="ธนาคารทิสโก้">ธนาคารทิสโก้</option>
                                        <option value="ธนาคารสแตนดาร์ดชาร์เตอร์ด(ไทย)">ธนาคารสแตนดาร์ดชาร์เตอร์ด(ไทย)
                                        </option>
                                        <option value="ธนาคารไทยเครดิตเพื่อรายย่อย">ธนาคารไทยเครดิตเพื่อรายย่อย</option>
                                        <option value="ธนาคารแลนด์แอนด์เฮาส์">ธนาคารแลนด์ แอนด์ เฮาส์</option>
                                        <option value="ธนาคารไอซีบีซี(ไทย)">ธนาคารไอซีบีซี (ไทย)</option>
                                        <option value="ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย">
                                            ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย</option>
                                        <option value="ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร">
                                            ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร</option>
                                        <option value="ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย">
                                            ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย</option>
                                        <option value="ธนาคารอิสลามแห่งประเทศไทย">ธนาคารอิสลามแห่งประเทศไทย</option>
                                        <option value="ธนาคารแห่งประเทศจีน">ธนาคารแห่งประเทศจีน</option>
                                        <option value="ธนาคารซูมิโตโมมิตซุยทรัสต์(ไทย)">ธนาคารซูมิโตโม มิตซุย ทรัสต์ (ไทย)
                                        </option>
                                        <option value="ธนาคารฮ่องกงและเซี้ยงไฮ้แบงกิ้งคอร์ปอเรชั่นจำกัด">
                                            ธนาคารฮ่องกงและเซี้ยงไฮ้แบงกิ้งคอร์ปอเรชั่น จำกัด</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">ชื่อบัญชีธนาคาร</label>
                                <input type="text" name="account_name" id="account-name"
                                    class="form-title form-control shadow-none text-center" required>
                            </div>
                            <div class="col-7 mb-3">
                                <label class="form-label">เลขที่บัญชี</label>
                                <input type="text" name="account_number" id="account-number"
                                    placeholder="123-4-56789-0" class="form-title form-control shadow-none text-center"
                                    required>
                            </div>
                            <div class="col-5 mb-3">
                                <label class="form-label">ลำดับความสำคัญ</label>
                                <input type="number" name="priority" id="priority"
                                    class="form-title form-control shadow-none text-center"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    onKeyPress="if(this.value.length>=10) return false;" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal()"
                            class="btn-close-modal btn btn-secondary shadow-none" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">บันทึก</button>
                    </div>
                </div>
                <input type="hidden" name="bank_id" id="bank-id">
                <input type="hidden" name="image_path" id="image-path">
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/backoffice/bank.js"></script>
@endsection

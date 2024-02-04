@extends('backoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/backoffice/feature-fac.css">
@endsection

@section('content')
    <h3><i class="bi bi-ui-checks"></i> Features & Facilities</h3>

    <!-- Feature & Facilities section -->
    <div class="d-flex flex-column gap-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 mb-4">
                        #Features ( คุณสมบัติห้องพัก )
                    </h5>
                    <button type="button" class="btn btn-dark shadow-none btn-md" data-bs-toggle="modal"
                        data-bs-target="#feature-s">
                        <i class="bi bi-plus-square"> </i> เพิ่ม Feature
                    </button>
                </div>
                <table id="features" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 390px;">ลำดับความสำคัญ</th>
                            <th>ชื่อ</th>
                            <th>การแสดงผล</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($features as $feature)
                            <tr>
                                <td>{{ $feature->priority }}</td>
                                <td>{{ $feature->name }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input onchange="upd_feature_display({{ $feature->id }}, this.checked)"
                                            isChecked="{{ $feature->display }}"
                                            class="form-check-input feature-checked shadow-none" type="checkbox"
                                            id="feature-toggle" style="cursor: pointer;">
                                    </div>
                                </td>
                                <td>
                                    <button class="btn-modal btn btn-warning shadow-none" data-bs-toggle="modal"
                                        onclick="getFeature({{ $feature->id }})" data-bs-target="#featureedit-s"><i
                                            class="bi bi-pen-fill"></i></button>
                                    <button class="btn btn-danger shadow-none"
                                        onclick="deleteFeature(this, {{ $feature->id }})"><i
                                            class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-5">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 mb-4">
                            #Facilities ( สิ่งอำนวยความสะดวก )
                        </h5>
                        <button type="button" class="btn btn-dark shadow-none btn-md" data-bs-toggle="modal"
                            data-bs-target="#faci-s">
                            <i class="bi bi-plus-square"> </i> เพิ่ม Facility
                        </button>
                    </div>
                    <table id="facilities" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 200px;">ลำดับความสำคัญ</th>
                                <th>icon</th>
                                <th>ชื่อ</th>
                                <th>การแสดงผล</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facilities as $fac)
                                <tr>
                                    <td>{{ $fac->priority }}</td>
                                    <td>
                                        <figure style="width: 70px; height: 70px; cursor: pointer;"
                                            onclick="previewFac('{{ $fac->icon }}')">
                                            <img src="{{ $fac->icon }}" width="100%">
                                        </figure>
                                    </td>
                                    <td>{{ $fac->name }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input onchange="upd_fac_display({{ $fac->id }}, this.checked)"
                                                isChecked="{{ $fac->display }}"
                                                class="form-check-input fac-checked shadow-none" type="checkbox"
                                                id="feature-toggle" style="cursor: pointer;">
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn-modal btn btn-warning shadow-none" data-bs-toggle="modal"
                                            onclick="getFac({{ $fac->id }})" data-bs-target="#facedit-s"><i
                                                class="bi bi-pen-fill"></i></button>
                                        <button class="btn btn-danger shadow-none"
                                            onclick="deleteFac(this, {{ $fac->id }})"><i
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


    <!-- Create Feature Modal -->
    <div class="modal fade" id="feature-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return createFeature(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่ม Feature</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-1">
                                <label class="form-label" style="font-weight: 500;">ชื่อ</label>
                                <input name="name" type="text" class="form-control text-center shadow-none" required>
                            </div>
                            <div class="col-lg-6 col-1">
                                <label class="form-label" style="font-weight: 500;">ลำดับความสำคัญ</label>
                                <input name="priority" type="number" class="form-control text-center shadow-none"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    onKeyPress="if(this.value.length>=10) return false;" required>
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

    <!-- Edit Feature Modal -->
    <div class="modal fade" id="featureedit-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return updateFeature(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">แก้ไข Feature</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-1">
                                <label class="form-label" style="font-weight: 500;">ชื่อ</label>
                                <input id="feature-name" name="name" type="text"
                                    class="form-control text-center shadow-none" required>
                                <input id="feature-id" name="id" type="hidden"
                                    class="form-control text-center shadow-none" required>
                            </div>
                            <div class="col-lg-6 col-1">
                                <label class="form-label" style="font-weight: 500;">ลำดับความสำคัญ</label>
                                <input id="feature-priority" name="priority" type="number"
                                    class="form-control text-center shadow-none"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    onKeyPress="if(this.value.length>=10) return false;" required>
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

    <!-- Facilities Create Modal -->
    <div class="modal fade" id="faci-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return createFac(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่ม Facilities</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="group-image mb-3">
                                    <figure class="image-upload shadow bg-white">
                                        <input onchange="previewImg()" class="img-input" id="file1" type="file"
                                            name="image" id="image" accept="image/jpeg, image/png, image/jpg"
                                            required>
                                        <img class="" src="/images/rooms/thumbnail.jpg" id="preview-img"
                                            alt="" style="width: 100%;">
                                    </figure>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">ชื่อ</label>
                                    <input type="text" name="name" id="faci-name"
                                        class="form-title form-control text-center shadow-none" required>
                                </div>
                                <div class="">
                                    <label class="form-label">เรียงลำดับความสำคัญ</label>
                                    <input type="number" name="priority" id="faci-priority"
                                        class="form-title form-control text-center shadow-none"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=10) return false;" required>
                                </div>
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

    <!-- Facilities Edit Modal -->
    <div class="modal fade" id="facedit-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return updateFac(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">แก้ไข Facilities</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="group-image mb-3">
                                    <figure class="image-upload shadow bg-white">
                                        <input onchange="previewEditFac()" class="img-input" id="file1" type="file"
                                            name="image" id="image" accept="image/jpeg, image/png, image/jpg">
                                        <img class="" src="/images/rooms/thumbnail.jpg" id="preview-img"
                                            alt="" style="width: 100%;">
                                    </figure>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">ชื่อ</label>
                                    <input type="text" name="name" id="faci-name"
                                        class="form-title form-control text-center shadow-none" required>
                                    <input type="hidden" id="faci-id" name="fac_id">
                                </div>
                                <div class="">
                                    <label class="form-label">เรียงลำดับความสำคัญ</label>
                                    <input type="number" name="priority" id="faci-priority"
                                        class="form-title form-control text-center shadow-none"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        onKeyPress="if(this.value.length>=10) return false;" required>
                                </div>
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
@endsection

@section('script')
    <script src="/js/backoffice/feature-fac.js"></script>
@endsection

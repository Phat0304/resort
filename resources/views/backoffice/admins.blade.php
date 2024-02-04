@extends('backoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/backoffice/bank.css">
@endsection

@section('content')
    <h3><i class="bi bi-person-fill-lock"></i> ผู้ดูแลระบบ</h3>
    <div class="d-flex flex-column gap-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="mt-5">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 mb-4">
                            #ผู้ดูแลระบบทั้งหมด
                        </h5>
                        <button type="button" class="btn btn-dark shadow-none btn-md" data-bs-toggle="modal"
                            data-bs-target="#admin-s">
                            <i class="bi bi-plus-square"> </i> เพิ่มผู้ดูแลระบบ
                        </button>
                    </div>
                    <table id="admin" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="">#</th>
                                <th>ชื่อ</th>
                                <th>อีเมล</th>
                                <th>สิทธิ์แอดมิน</th>
                                <th>สถานะแอดมิน</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $key => $admin)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $admin->username }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->admin_role }}</td>
                                    <td><span
                                            class="badge rounded-pill text-light bg-{{ $admin->status === 'เปิดใช้งาน' ? 'success' : 'secondary' }}">{{ $admin->status }}</span>
                                    </td>
                                    <td>
                                        <button class="btn-modal btn btn-warning shadow-none" data-bs-toggle="modal"
                                            onclick="getAdmin({{ $admin->id }})" data-bs-target="#adminedit-s"><i
                                                class="bi bi-pen-fill"></i></button>
                                        <button class="btn btn-danger shadow-none"
                                            onclick="deleteAdmin(this, {{ $admin->id }})"><i
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

    <!-- Create Admin Modal -->
    <div class="modal fade" id="admin-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return createAdmin(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่มผู้ดูแลระบบ</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12 mb-3">
                                <label class="form-label">ชื่อ</label>
                                <input type="text" name="username" id="username"
                                    class="form-title form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">อีเมล</label>
                                <input type="email" name="email" id="email"
                                    class="form-title form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">รหัสผ่าน <span
                                        class="password-valid text-secondary">(รหัสผ่านอย่างน้อย 8 ตัว)</span></label>
                                <input type="password" name="password" id="password"
                                    class="form-title form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">ยืนยันรหัสผ่าน <span class="cpassword-valid text-danger d-none"> :
                                        รหัสผ่านกับยืนยันรหัสผ่านต้องตรงกัน</span></label>
                                <input type="password" name="c_password" id="c_password"
                                    class="form-title form-control shadow-none" required>
                            </div>
                            <div class="col-6 mb-3">
                                <select class="form-select shadow-none pointer" id="admin-role" name="admin_role" required>
                                    <option value="">-- เลือกสิทธิ์แอดมิน --</option>
                                    <option value="แอดมินสูงสุด">แอดมินสูงสุด</option>
                                    <option value="แอดมิน">แอดมิน</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <select class="form-select shadow-none pointer" id="admin-status" name="admin_status"
                                    required>
                                    <option value="">-- เลือกสถานะแอดมิน --</option>
                                    <option value="เปิดใช้งาน">เปิดใช้งาน</option>
                                    <option value="ปิดใช้งาน">ปิดใช้งาน</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal()" class="btn-close-modal btn btn-secondary shadow-none"
                            data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">เพิ่ม</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Admin Modal -->
    <div class="modal fade" id="adminedit-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="return updateAdmin(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">แก้ไขผู้ดูแลระบบ</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12 mb-3">
                                <label class="form-label">ชื่อ</label>
                                <input type="text" name="username" id="username"
                                    class="form-title form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">อีเมล</label>
                                <input type="email" name="email" id="email"
                                    class="form-title form-control shadow-none" required readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <select class="form-select shadow-none pointer" id="admin-role" name="admin_role"
                                    required>
                                    <option value="">-- เลือกสิทธิ์แอดมิน --</option>
                                    <option value="แอดมินสูงสุด">แอดมินสูงสุด</option>
                                    <option value="แอดมิน">แอดมิน</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <select class="form-select shadow-none pointer" id="admin-status" name="admin_status"
                                    required>
                                    <option value="">-- เลือกสถานะแอดมิน --</option>
                                    <option value="เปิดใช้งาน">เปิดใช้งาน</option>
                                    <option value="ปิดใช้งาน">ปิดใช้งาน</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal()"
                            class="btn-close-modal btn btn-secondary shadow-none" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">บันทึก</button>
                    </div>
                </div>
                <input type="hidden" name="admin_id" id="admin-id">
            </form>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script src="/js/backoffice/bank.js"></script> --}}

    <script>
        new DataTable("#admin");

        const modals = document.querySelectorAll(".modal");
        const admin_id = document.querySelector("#admin-id");
        const username = document.querySelectorAll("#username");
        const email = document.querySelectorAll("#email");
        const admin_role = document.querySelectorAll("#admin-role");
        const admin_status = document.querySelectorAll("#admin-status");
        const password = document.querySelectorAll("#password");
        const c_password = document.querySelectorAll("#c_password");
        const cpassword_valid = document.querySelectorAll(".cpassword-valid");
        const password_valid = document.querySelectorAll(".password-valid");

        const close_modal = document.querySelectorAll(".btn-close-modal");

        function closeModal() {
            for (let i = 0; i < modals.length; i++) {
                admin_role[i].value = "";
                admin_status[i].value = "";
                password[0].value = "";
                c_password[0].value = "";
                username[i].value = "";
                email[i].value = "";
            }
        }


        function createAdmin(event) {
            event.preventDefault();

            if (password[0].value.trim().length < 8) {
                password[0].focus();
                password_valid[0].classList.remove('text-secondary')
                password_valid[0].classList.add('text-danger')
                return false;
            } else {
                password_valid[0].classList.remove('text-danger')
                password_valid[0].classList.add('text-secondary')
            }

            if (c_password[0].value !== password[0].value) {
                c_password[0].focus();
                cpassword_valid[0].classList.remove('d-none');
                return false;
            } else {
                cpassword_valid[0].classList.add('d-none');
            }

            const form = event.target;
            const formData = new FormData(form);

            axios
                .post("/admin/admincreate", formData)
                .then(({
                    data
                }) => {
                    if (data.status) {
                        close_modal.forEach((btn) => btn.click());
                        toastr.success("เพิ่มผู้ดูแลระบบสำเร็จ");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                })
                .catch(({
                    response
                }) => {
                    close_modal.forEach((btn) => btn.click());
                    if (response.status === 422) {
                        toastr.error("Email นี้มีผู้ใช้งานอยู่แล้ว");
                    } else {
                        toastr.error("error");
                    }
                });
        }

        function getAdmin(_id) {
            axios
                .get(`/admin/adminone/${_id}`)
                .then(({
                    data
                }) => {
                    if (data.status) {
                        const admin = data.data;
                        admin_id.value = admin.id;
                        username[1].value = admin.username;
                        email[1].value = admin.email;
                        admin_role[1].value = admin.admin_role;
                        admin_status[1].value = admin.status;

                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        }

        function updateAdmin(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            axios
                .post(`/admin/adminupdate`, formData)
                .then(({


                    data
                }) => {
                    if (data.status) {
                        close_modal.forEach((btn) => btn.click());
                        toastr.success("Update Admin สำเร็จ");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                })
                .catch((err) => {
                    close_modal.forEach((btn) => btn.click());
                    if (err.response.status === 403) {
                        toastr.error(err.response.data.description);
                    } else {
                        toastr.error("Error");
                    }

                });
        }

        function deleteAdmin(_el, _id) {
            const url = `/admin/deleteadmin/`;
            onDelete(_el, _id, url);
        }

        function onDelete(_el, _id, _url) {
            Swal.fire({
                text: "คุณต้องการลบใช่หรือไม่",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`${_url}${_id}`)
                        .then(({
                            data
                        }) => {
                            if (data.status) {
                                const row = _el.closest("tr");
                                toastr.success("ลบสำเร็จ");
                                if (row) {
                                    // Get the table to which the row belongs
                                    const table = row.closest("table");
                                    // Delete the row from the table
                                    table.deleteRow(row.rowIndex);
                                }
                            }
                        })
                        .catch((err) => {
                            if (err.response.status === 403) {
                                toastr.error(err.response.data.description);
                            } else {
                                toastr.error('Error');
                            }
                        });
                }
            });
        }
    </script>
@endsection

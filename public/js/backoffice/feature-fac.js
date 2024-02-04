new DataTable("#features");
new DataTable("#facilities");

const feature_name = document.querySelector("#feature-name");
const feature_priority = document.querySelector("#feature-priority");
const feature_id = document.querySelector("#feature-id");

const faci_id = document.querySelector("#faci-id");
const faci_name = document.querySelectorAll("#faci-name");
const faci_priority = document.querySelectorAll("#faci-priority");

const fac_checked = document.querySelectorAll(".fac-checked");
const feature_checked = document.querySelectorAll(".feature-checked");

const img = document.querySelectorAll("#preview-img");
const file = document.querySelectorAll("#file1");
const priority = document.querySelectorAll("#priority");
const fac_id = document.querySelector("#fac_id");

const close_modal = document.querySelectorAll(".btn-close-modal");

fac_checked.forEach((fac) => {
    const isChecked = fac.getAttribute("isChecked");
    if (isChecked == 1) {
        fac.checked = true;
    } else {
        fac.checked = false;
    }
});

feature_checked.forEach((feature) => {
    const isChecked = feature.getAttribute("isChecked");
    if (isChecked == 1) {
        feature.checked = true;
    } else {
        feature.checked = false;
    }
});

function createFeature(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    axios
        .post("/admin/feature/create", formData)
        .then(({ data }) => {
            if (data.status) {
                close_modal.forEach((btn) => btn.click());
                toastr.success("เพิ่ม Feature สำเร็จ");
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        })
        .catch((err) => {
            close_modal.forEach((btn) => btn.click());
            toastr.error("Error");
        });
}

function getFeature(_id) {
    axios
        .get(`/admin/featureone/${_id}`)
        .then(({ data }) => {
            feature_name.value = data.data.name;
            feature_priority.value = data.data.priority;
            feature_id.value = data.data.id;
        })
        .catch((err) => {
            console.log(err);
        });
}

function updateFeature(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    axios
        .post(`/admin/feature/update`, formData)
        .then(({ data }) => {
            if (data.status) {
                close_modal.forEach((btn) => btn.click());
                toastr.success("Update Feature สำเร็จ");
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        })
        .catch((err) => {
            close_modal.forEach((btn) => btn.click());
            toastr.error("Error");
        });
}

function createFac(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    axios
        .post("/admin/fac/create", formData)
        .then(({ data }) => {
            if (data.status) {
                close_modal.forEach((btn) => btn.click());
                toastr.success("เพิ่ม Facilities สำเร็จ");
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        })
        .catch((err) => {
            close_modal.forEach((btn) => btn.click());
            toastr.error("Error");
        });
}

function getFac(_id) {
    axios
        .get(`/admin/facone/${_id}`)
        .then(({ data }) => {
            if (data.status) {
                const fac = data.data;
                faci_id.value = fac.id;
                img[1].src = fac.icon;
                faci_name[1].value = fac.name;
                faci_priority[1].value = fac.priority;
            }
        })
        .catch((err) => {
            console.log(err);
        });
}

function updateFac(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    axios
        .post(`/admin/fac/update`, formData)
        .then(({ data }) => {
            if (data.status) {
                close_modal.forEach((btn) => btn.click());
                toastr.success("Update Facilities สำเร็จ");
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        })
        .catch((err) => {
            close_modal.forEach((btn) => btn.click());
            toastr.error("Error");
        });
}

function upd_fac_display(_id, _checked) {
    axios
        .patch(`/admin/updatefacdisplay/${_id}`, {
            display: _checked,
        })
        .then(({ data }) => {
            console.log(data);
        })
        .catch((err) => console.log(err));
}

function upd_feature_display(_id, _checked) {
    axios
        .patch(`/admin/updatefeaturedisplay/${_id}`, {
            display: _checked,
        })
        .then(({ data }) => {
            console.log(data);
        })
        .catch((err) => console.log(err));
}

function deleteFeature(_el, _id) {
    const url = `/admin/deletefeature/`;
    onDelete(_el, _id, url);
}

function deleteFac(_el, _id) {
    const url = `/admin/deletefac/`;
    onDelete(_el, _id, url);
}

function previewFac(_src) {
    Swal.fire({
        imageUrl: `${_src}`,
        imageWidth: 100,
        imageClass: "slide-img",
        showConfirmButton: false,
        animation: false,
        width: "350px",
    });
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
                .then(({ data }) => {
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
                    toastr.error("Error");
                });
        }
    });
}

function previewImg() {
    const image = file[0].files[0];
    let reader = new FileReader();
    reader.onloadend = () => {
        img[0].src = reader.result;
    };
    reader.readAsDataURL(image);
}

function previewEditFac() {
    const image = file[1].files[0];
    let reader = new FileReader();
    reader.onloadend = () => {
        img[1].src = reader.result;
    };
    reader.readAsDataURL(image);
}

function closeModal() {
    file[0].value = "";
    img[0].src = "/images/rooms/thumbnail.jpg";
    faci_name[0].value = "";
    faci_priority[0].value = "";
}

new DataTable("#rooms");

const features = document.querySelectorAll(".feature-checked");
const features_edit = document.querySelectorAll(".featureedit-checked");
const facs = document.querySelectorAll(".fac-checked");
const facs_edit = document.querySelectorAll(".facedit-checked");

const select_feature = document.querySelectorAll(".select-feature");
const select_fac = document.querySelectorAll(".select-fac");

const close_modal = document.querySelectorAll(".btn-close-modal");
const room_checked = document.querySelectorAll(".room-checked");

const room_id = document.querySelector("#room-id");
const room_name = document.querySelector("#room-name");
const room_price = document.querySelector("#room-price");
const room_adult = document.querySelector("#room-adult");
const room_children = document.querySelector("#room-children");
const room_area = document.querySelector("#room-area");
const room_des = document.querySelector("#room-des");

const room_id_edit = document.querySelector("#room-id-edit");
const preview_img = document.querySelector("#preview-img");
const img_input = document.querySelector(".img-input");
const tbody = document.querySelector("#tbody");
const modal_title = document.querySelector("#m-title");

room_checked.forEach((room) => {
    const isChecked = room.getAttribute("isChecked");
    if (parseInt(isChecked) === 1) {
        room.checked = true;
    }
});

function validateRoom(fea_length, fac_length, ind = 0) {
    if (fea_length === 0 || fac_length === 0) {
        if (fea_length === 0) {
            select_feature[ind].classList.add("border", "border-danger", "p-2");
        } else {
            select_feature[ind].classList.remove(
                "border",
                "border-danger",
                "p-2"
            );
        }

        if (fac_length === 0) {
            select_fac[ind].classList.add("border", "border-danger", "p-2");
        } else {
            select_fac[ind].classList.remove("border", "border-danger", "p-2");
        }

        return false;
    } else {
        return true;
    }
}

function upd_room_display(_id, _checked) {
    axios
        .patch(`/admin/updateroomdisplay/${_id}`, {
            display: _checked,
        })
        .then(({ data }) => {
            console.log(data);
        })
        .catch((err) => console.log(err));
}

function createRoom(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    features.forEach((feature) => {
        if (feature.checked) {
            formData.append("feature_ids[]", feature.value);
        }
    });

    facs.forEach((fac) => {
        if (fac.checked) {
            formData.append("fac_ids[]", fac.value);
        }
    });

    const feature_length = formData.getAll("feature_ids[]").length;
    const fac_length = formData.getAll("fac_ids[]").length;

    const validator = validateRoom(feature_length, fac_length);

    if (validator) {
        axios
            .post("admin/room/create", formData)
            .then(({ data }) => {
                if (data.status) {
                    close_modal.forEach((btn) => btn.click());
                    toastr.success("เพิ่มห้องพักสำเร็จ");
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            })
            .catch((err) => {
                close_modal.forEach((btn) => btn.click());
                toastr.error("Error");
            });
    } else {
        return validator;
    }
}

function getRoom(_id) {
    axios
        .get(`/admin/roomone/${_id}`)
        .then(({ data }) => {
            const room = data.data;
            room_name.value = room.name;
            room_price.value = room.price;
            room_adult.value = room.adult;
            room_children.value = room.children;
            room_area.value = room.area;
            room_id.value = room.id;
            room_des.value = room.description;

            features_edit.forEach((fea) => {
                room.feature_ids.forEach((fea_id) => {
                    if (parseInt(fea_id) === parseInt(fea.value)) {
                        fea.checked = true;
                    }
                });
            });

            facs_edit.forEach((fac) => {
                room.fac_ids.forEach((fac_id) => {
                    if (parseInt(fac_id) === parseInt(fac.value)) {
                        fac.checked = true;
                    }
                });
            });
        })
        .catch((err) => {
            console.log(err);
        });
}

function updateRoom(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    features_edit.forEach((feature) => {
        if (feature.checked) {
            formData.append("feature_ids[]", feature.value);
        }
    });

    facs_edit.forEach((fac) => {
        if (fac.checked) {
            formData.append("fac_ids[]", fac.value);
        }
    });

    const feature_length = formData.getAll("feature_ids[]").length;
    const fac_length = formData.getAll("fac_ids[]").length;

    const validator = validateRoom(feature_length, fac_length, 1);

    if (validator) {
        axios
            .post(`/admin/room/update`, formData)
            .then(({ data }) => {
                if (data.status) {
                    close_modal.forEach((btn) => btn.click());
                    toastr.success("Update Room สำเร็จ");
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            })
            .catch((err) => {
                close_modal.forEach((btn) => btn.click());
                toastr.error("Error");
            });
    } else {
        return validator;
    }
}

function deleteRoom(_id) {


    axios.delete(`/admin/deleteroom/${_id}`).then((response) => {
        if (response.status === 200) {
            Swal.fire({
                icon: "success",
                title: "ลบห้องสำเร็จ",
            }).then(() => window.location.reload());
        } else {
            Swal.fire({
                icon: "error",
                title: "ลบห้องไม่สำเร็จ",
            }).then(() => window.location.reload());
        }
    });
}


async function getGallery(_id) {
    const response = await axios.get(`admin/gallery/${_id}`)
    const room = response.data.data.room;
    const gallery = response.data.data.gallery;

    modal_title.innerText = room.name;
    room_id_edit.value = room.id;

    let html = "";
    gallery.forEach(gal => {
        html += `<tr id="gal-image">
                    <td style="width:250px;">
                        <img src="${gal.image}" width=200 height=115 >
                    </td>
                    <td class="text-center align-middle">
                        <div class="form-check form-switch d-flex align-items-center justify-content-center">
                            <input onchange="updateGalDefault(${gal.id}, this.checked, this)" galid="${gal.id}" class="form-check-input image-checked shadow-none" ${gal.default?"checked":""}
                                type="checkbox"id="image-toggle" style="cursor: pointer;">
                        </div>
                    </td>
                    <td class="text-center align-middle">
                        <button type="button" onclick="deleteGal(this, ${gal.id})" class="btn btn-danger shadow-none"><i
                            class="bi bi-trash-fill"></i></button>
                    </td>
                </tr> `;
    })

    tbody.innerHTML = html;

}

function addImage(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    axios
        .post("/admin/room/addimage", formData)
        .then(({ data }) => {
            toastr.success("เพิ่มรูปภาพสำเร็จ");
            preview_img.src = '/images/rooms/thumbnail.jpg';
            img_input.value = "";
            const gal = data.data;
            let html = `
                        <tr id="gal-image">
                            <td style="width:250px;">
                                <img src="${gal.image}" width=200 height=115 >
                            </td>
                            <td class="text-center align-middle">
                                <div class="form-check form-switch d-flex align-items-center justify-content-center">
                                    <input onchange="updateGalDefault(${gal.id}, this.checked, this)" galid="${gal.id}" class="form-check-input image-checked shadow-none" ${gal.default?"checked":""}
                                        type="checkbox"id="image-toggle" style="cursor: pointer;">
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <button type="button" onclick="deleteGal(this, ${gal.id})" class="btn btn-danger shadow-none"><i
                                    class="bi bi-trash-fill"></i></button>
                            </td>
                        </tr>
            `;

            tbody.insertAdjacentHTML("beforeend", html);
        })
        .catch((err) => {
            preview_img.src = '/images/rooms/thumbnail.jpg';
            img_input.value = "";
            close_modal.forEach((btn) => btn.click());
            toastr.error("Error");
        });
}

function deleteGal(_el, _id) {
    const url = `/admin/deletegal/`;
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

function updateGalDefault(_id, _checked, _el) {
    const gal = document.querySelectorAll('#gal-image');
    const galList = document.querySelectorAll('#image-toggle')
    const room_id = room_id_edit.value;
    if (_checked) {
        axios
            .patch(`/admin/updategaldefault/${_id}`, {
                default: true,
                room_id: room_id,
            })
            .then(({ data }) => {
                if (data.status) {
                    galList.forEach(g => {
                        if (parseInt(g.getAttribute('galid')) === parseInt(_id)) {
                            g.checked = true;
                        } else {
                            g.checked = false;
                        }
                    })
                }
        })
        .catch((err) => console.log(err));
    } else {
        axios
            .patch(`/admin/updategaldefault/${_id}`, {
                default: false,
                room_id: room_id,
            })
            .then(({ data }) => {
                if (data.status) {
                    //
                }
        })
        .catch((err) => console.log(err));
    }
}

function closeModal() {
    facs.forEach((fac) => (fac.checked = false));
    features.forEach((fea) => (fea.checked = false));

    facs_edit.forEach((fac) => (fac.checked = false));
    features_edit.forEach((fea) => (fea.checked = false));

    select_fac.forEach((fac) =>
        fac.classList.remove("border", "border-danger", "p-2")
    );
    select_feature.forEach((feature) =>
        feature.classList.remove("border", "border-danger", "p-2")
    );

    preview_img.src = '/images/rooms/thumbnail.jpg';
    img_input.value = "";
}

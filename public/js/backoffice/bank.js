new DataTable("#bank");

const select_bank_name = document.querySelectorAll("#select-bankname");
const bank_id = document.querySelector("#bank-id");
const image_path = document.querySelector("#image-path");
const account_name = document.querySelectorAll("#account-name");
const account_number = document.querySelectorAll("#account-number");
const priority = document.querySelectorAll("#priority");
const img = document.querySelectorAll("#preview-img");
const file = document.querySelectorAll("#file1");
const bank_checked = document.querySelectorAll(".bank-checked");

const close_modal = document.querySelectorAll(".btn-close-modal");

function closeModal() {
    for (let i = 0; i <= 1; i++) {
        account_name[i].value = "";
        account_number[i].value = "";
        select_bank_name[i].value = "";
        file[i].value = "";
        img[i].src = "/images/istockphoto.jpg";
        priority[i].value = "";
    }
}

bank_checked.forEach((bank) => {
    const isChecked = bank.getAttribute("isChecked");
    if (isChecked == 1) {
        bank.checked = true;
    } else {
        bank.checked = false;
    }
});

function createBank(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    axios
        .post("/admin/bank/create", formData)
        .then(({ data }) => {
            if (data.status) {
                close_modal.forEach((btn) => btn.click());
                toastr.success("เพิ่มธนาคารสำเร็จ");
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

function getBank(_id) {
    axios
        .get(`/admin/bankone/${_id}`)
        .then(({ data }) => {
            if (data.status) {
                const bank = data.data;
                bank_id.value = bank.id;
                img[1].src = bank.bank_image;
                select_bank_name[1].value = bank.bank_name;
                account_name[1].value = bank.account_name;
                account_number[1].value = bank.account_number;
                priority[1].value = bank.priority;
                image_path.value = bank.bank_image;
            }
        })
        .catch((err) => {
            console.log(err);
        });
}

function updateBank(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    axios
        .post(`/admin/bank/update`, formData)
        .then(({ data }) => {
            if (data.status) {
                close_modal.forEach((btn) => btn.click());
                toastr.success("Update Bank สำเร็จ");
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

function updBankDisplay(_id, _checked) {
    axios
        .patch(`/admin/updatebankdisplay/${_id}`, {
            display: _checked,
        })
        .then(({ data }) => {
            console.log(data);
        })
        .catch((err) => console.log(err));
}

function deleteBank(_el, _id) {
    const url = `/admin/deletebank/`;
    onDelete(_el, _id, url);
}

function previewBank(_src) {
    Swal.fire({
        imageUrl: `${_src}`,
        imageWidth: 350,
        imageHeight: 400,
        imageClass: "slide-img",
        showConfirmButton: false,
        animation: false,
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
                    console.log(err.response);
                    toastr.error(err.response.data.description);
                });
        }
    });
}

function previewImg(ind = 0) {
    const image = file[ind].files[0];
    let reader = new FileReader();
    reader.onloadend = () => {
        img[ind].src = reader.result;
    };
    reader.readAsDataURL(image);
}

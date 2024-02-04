const btn_close = document.querySelector(".btn-close-modal");
const site_title = document.getElementById("title").value;
const site_about = document.getElementById("about").value;
const site_id = document.getElementById("site_id").value;

const formContact = document.querySelectorAll("#form-contact");

let form_title = document.querySelector(".form-title");
let form_about = document.querySelector(".form-about");

function onUpdateSite(event) {
    event.preventDefault();

    const form = event.target;

    const formData = new FormData(form);

    axios
        .post("/admin/updatesite", formData)
        .then(({ data }) => {
            if (data.status) {
                btn_close.click();
                Swal.fire({
                    icon: "success",
                    title: "อัพเดทสำเร็จ",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    window.location.href = "/admin?page=settings";
                });
            }
        })
        .catch((err) => {
            btn_close.click();
            Swal.fire({
                icon: "error",
                title: "Someting went wrong!",
                showConfirmButton: false,
                timer: 1500,
            });
        });
}

function onUpdateContact(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    axios
        .post("/admin/updatecontact", formData)
        .then(({ data }) => {
            if (data.status) {
                btn_close.click();
                Swal.fire({
                    icon: "success",
                    title: "อัพเดทสำเร็จ",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    window.location.reload();
                });
            }
        })
        .catch((err) => {
            btn_close.click();
            Swal.fire({
                icon: "error",
                title: "Someting went wrong!",
                showConfirmButton: false,
                timer: 1500,
            });
        });
}

function initData() {
    form_title.value = site_title;
    form_about.value = site_about;
}

function initContactData() {
    axios
        .get("/admin/getcontact")
        .then(({ data }) => {
            const contact = data.data;
            formContact.forEach((el, ind) => {
                el.value = contact[ind];
            });
        })
        .catch((err) => console.log(err));
}

function upd_shutdown(_checked) {
    axios
        .post("/admin/updateshutdown", {
            isChecked: _checked,
            site_id: site_id,
        })
        .then(({ data }) => {
            toastr.success(data.description);
        });
}

const shutdown = document.getElementById("shutdown-toggle");
if (parseInt(shutdown.getAttribute("isChecked")) === 1) {
    shutdown.checked = true;
} else {
    shutdown.checked = false;
}

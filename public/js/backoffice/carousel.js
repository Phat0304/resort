const img = document.querySelectorAll("#preview-img");
const file = document.querySelectorAll("#file1");
const priority = document.querySelectorAll("#priority");
const display = document.querySelectorAll("#check-display");
const carousel_id = document.querySelector("#carousel_id");

function onCreate(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    formData.append("display", display[0].checked ? 1 : 0);

    axios
        .post(`/admin/carousel/create`, formData)
        .then(({ data }) => {
            if (data.status) {
                Swal.fire({
                    icon: "success",
                    title: "เพิ่มสำเร็จ",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    window.location.reload();
                });
            }
        })
        .catch((err) => {
            Swal.fire({
                icon: "error",
                title: "Someting went wrong!",
                showConfirmButton: false,
                timer: 1500,
            });
        });
}

function onUpdate(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    formData.append("display", display[1].checked ? 1 : 0);

    axios
        .post(`/admin/carousel/update`, formData)
        .then(({ data }) => {
            if (data.status) {
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
            Swal.fire({
                icon: "error",
                title: "Someting went wrong!",
                showConfirmButton: false,
                timer: 1500,
            });
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

function closeModal() {
    file[0].value = "";
    img[0].src = "/images/carousel/no-image.png";
}

function previewSlid(_src) {
    Swal.fire({
        imageUrl: `${_src}`,
        imageWidth: 900,
        imageClass: "slide-img",
        showConfirmButton: false,
        animation: false,
        width: "950px",
    });
}

function onDelete(_id) {
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
                .delete(`/admin/carousel/delete?id=${_id}`)
                .then(({ data }) => {
                    if (data.status) {
                        Swal.fire({
                            icon: "success",
                            title: "ลบสำเร็จ",
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch((err) => {
                    Swal.fire({
                        icon: "error",
                        title: "Someting went wrong!",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                });
        }
    });
}

function getById(_id) {
    axios
        .get(`/admin/carousel/${_id}`)
        .then(({ data }) => {
            if (data.status) {
                const details = data.data;
                if (details.image) {
                    img[1].src = details.image;
                }
                carousel_id.value = details.id;
                priority[1].value = details.priority;
                display[1].checked = details.display;
            }
        })
        .catch((err) => console.log(err));
}

function previewUpdate() {
    const image = file[1].files[0];
    let reader = new FileReader();
    reader.onloadend = () => {
        img[1].src = reader.result;
    };
    reader.readAsDataURL(image);
}

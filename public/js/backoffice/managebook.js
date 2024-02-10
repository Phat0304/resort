// new DataTable("#bookings");
$(document).ready(function () {
    $("#booking-all").DataTable({
        order: [], // กำหนด order เป็นรายการว่าง
    });

    $("#booking-online").DataTable({
        order: [], // กำหนด order เป็นรายการว่าง
    });

    $("#booking-walkin").DataTable({
        order: [], // กำหนด order เป็นรายการว่าง
    });

    $("#booking-all_wrapper").removeClass("d-none");
    $("#booking-online_wrapper").addClass("d-none");
    $("#booking-walkin_wrapper").addClass("d-none");

    $(".select-booking-type").change(function () {
        const type = this.value; //เอาค่าใน value
        if (type === "all") {
            $("#booking-all_wrapper").removeClass("d-none");
            $("#booking-online_wrapper").addClass("d-none");
            $("#booking-walkin_wrapper").addClass("d-none");
        } else if (type === "online") {
            $("#booking-all_wrapper").addClass("d-none");
            $("#booking-online_wrapper").removeClass("d-none");
            $("#booking-walkin_wrapper").addClass("d-none");
        } else {
            $("#booking-all_wrapper").addClass("d-none");
            $("#booking-online_wrapper").addClass("d-none");
            $("#booking-walkin_wrapper").removeClass("d-none");
        }
    });
});

//-----------------------------------------------------------//

//วันเช็คอินเช็คเอาท์
//รายการ checkin หลายรายการ แสดงวันที่ในทุกๆ รายการ
const checkdeteElements = document.querySelectorAll(".checkdete");
const createAtElemants = document.querySelectorAll(".createAt");

// วนลูปผ่านทุก checkdete element เพื่อแปลงวันที่ในทั้งสอง <p> เป็นภาษาไทย
checkdeteElements.forEach((checkdeteElement) => {
    // ดึงข้อความที่มีอยู่ใน <p> เพื่อให้ได้วันที่
    const checkinText =
        checkdeteElement.querySelector("p:first-child").innerText;
    const checkoutText =
        checkdeteElement.querySelector("p:last-child").innerText;

    // แปลงข้อความวันที่เป็น Date object
    const checkinDate = new Date(checkinText);
    const checkoutDate = new Date(checkoutText);

    // กำหนดรูปแบบและภาษาที่ต้องการให้แสดง
    const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    const formattedCheckinDate = checkinDate.toLocaleDateString(
        "th-TH",
        options
    );
    const formattedCheckoutDate = checkoutDate.toLocaleDateString(
        "th-TH",
        options
    );

    // แสดงวันที่ในรูปแบบภาษาไทย
    checkdeteElement.querySelector(
        "p:first-child"
    ).innerText = `เช็คอิน : ${formattedCheckinDate}`;
    checkdeteElement.querySelector(
        "p:last-child"
    ).innerText = `เช็คเอาท์ : ${formattedCheckoutDate}`;
});

// วันที่จอง
createAtElemants.forEach((createAtElement) => {
    // ดึงข้อความที่มีอยู่ใน <p> เพื่อให้ได้วันที่
    const createAtText =
        createAtElement.querySelector("p:first-child").innerText;

    // แปลงข้อความวันที่เป็น Date object
    const createAtDate = new Date(createAtText);

    // กำหนดรูปแบบและภาษาที่ต้องการให้แสดง
    const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    const formattedcreateAtDate = createAtDate.toLocaleDateString(
        "th-TH",
        options
    );

    // แสดงวันที่ในรูปแบบภาษาไทย
    createAtElement.querySelector(
        "p:last-child"
    ).innerText = `${formattedcreateAtDate}`;
});

//---------------------------------------------------------------//

const formBooking = document.querySelectorAll(".form-booking");
const btn_modal = document.querySelector(".btn-modal");

function updateBookStatus(_el, _id) {
    const badge = _el.closest("td").querySelector(".badge");
    const badge_bg = [
        "bg-warning",
        "bg-primary",
        "bg-info",
        "bg-success",
        "bg-danger",
    ];

    axios
        .post(`/admin/updatebookstatus`, {
            booking_id: parseInt(_id),
            status_id: parseInt(_el.value),
        })
        .then(({ data }) => {
            if (data.status) {
                toastr.success("อัพเดทสถานะสำเร็จ");
                badge_bg.forEach((bg) => {
                    badge.classList.remove(bg);
                });
                badge.classList.add(`bg-${data.booking_status.bg_color}`);
                badge.innerHTML = `${data.booking_status.name} <span><i class="bi bi-caret-down-fill"></i></span>`;

                setTimeout(() => {
                    window.location.reload();
                    // ถ้าสถานะเช็คเอาท์ หรือ ยกเลิก
                    // if ([4, 5].includes(parseInt(data.booking_status.id))) {
                    //     window.location.reload();
                    // }
                }, 2000);
            }
        })
        .catch((err) => console.log(err));
}

function previewSlip(_src) {
    Swal.fire({
        imageUrl: `${_src}`,
        imageWidth: 350,
        // imageHeight: 400,
        imageClass: "slide-img",
        showConfirmButton: false,
        animation: false,
    });
}

function getBooking(_el, _id) {
    // console.log('el' , _el);
    // console.log('id' , _id);
    // return;
    axios
        .get(`/admin/bookingone/${_id}`)
        .then(({ data }) => {
            const formData = data.data["formData"];
            formBooking.forEach((form, ind) => {
                form.value = formData[ind];
            });
        })
        .catch((err) => console.log(err));
}

function deleteBooking(_el, _id) {
    console.log("id", _id);
    console.log("el", _el);

    axios
        .delete(`/admin/deletebooking/${_id}`)
        .then(({ data }) => {
            if (data.status) {
                console.log("data", data.status);

                const row = _el.closest("tr");
                toastr.success("ลบประวัติการจองสำเร็จ");

                if (row) {
                    // Get the table to which the row belongs
                    const table = row.closest("table");
                    // Delete the row from the table
                    table.deleteRow(row.rowIndex);
                }
            }
        })
        .catch((err) => console.log(err));
}

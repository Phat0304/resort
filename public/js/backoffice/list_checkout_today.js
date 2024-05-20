$(document).ready(function () {
    $("#booking-today").DataTable({
        pageLength: -1,
        order: [], // กำหนด order เป็นรายการว่าง
    });

    $("#booking-date").DataTable({
        pageLength: -1,
        order: [], // กำหนด order เป็นรายการว่าง
    });

    $("#booking-today_wrapper").removeClass("d-none");
    $("#booking-date_wrapper").addClass("d-none");

    $(".filterDate").change(function () {
        const type = this.value; //เอาค่าใน value

        if (type === null) {
            $("#booking-today_wrapper").removeClass("d-none");
            $("#booking-date_wrapper").addClass("d-none");
        } else {
            $("#booking-today_wrapper").addClass("d-none");
            $("#booking-date_wrapper").removeClass("d-none");
        }
    });
});

// เลือกวันที่เช็คอิน
function filterBookings() {
    const filterDateInput = document.getElementById("filterDate");
    const selectedDate = filterDateInput.value;
    const options1 = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    }; // เพิ่ม minute };
    const formattedSelectedDate = new Date(selectedDate).toLocaleDateString(
        "th-TH",
        options1
    );

    const bookings = document.querySelectorAll(".table-booking-date tbody tr");

    bookings.forEach((booking) => {
        const checkoutText = booking.querySelector(
            ".checkout p:first-child"
        ).innerText;

        if (checkoutText === formattedSelectedDate) {
            booking.style.display = "table-row";
        } else {
            booking.style.display = "none";
        }
    });
}

const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
};
const today = new Date().toLocaleDateString("th-TH", options);
document.getElementById("currentDate").innerText = today;

//-----------------------------------------------------------//

// วันเช็คอิน
// รายการ checkin หลายรายการ แสดงวันที่ในทุกๆ รายการ
const checkdeteElements = document.querySelectorAll(".checkdete");

// วนลูปผ่านทุก checkdete element เพื่อแปลงวันที่ในทั้งสอง <p> เป็นภาษาไทย
checkdeteElements.forEach((checkdeteElement) => {
    // ดึงข้อความที่มีอยู่ใน <p> เพื่อให้ได้วันที่
    const checkinText1 =
        checkdeteElement.querySelector("p:first-child").innerText;

    // แปลงข้อความวันที่เป็น Date object
    const checkinDate1 = new Date(checkinText1);

    // กำหนดรูปแบบและภาษาที่ต้องการให้แสดง
    const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    const formattedCheckinDate1 = checkinDate1.toLocaleDateString(
        "th-TH",
        options
    );

    // แสดงวันที่ในรูปแบบภาษาไทย
    checkdeteElement.querySelector(
        "p:first-child"
    ).innerText = `${formattedCheckinDate1}`;
});

// วันเช็คเอาท์
// รายการ checkin หลายรายการ แสดงวันที่ในทุกๆ รายการ
const checkoutElements1 = document.querySelectorAll(".checkout");

// วนลูปผ่านทุก checkdete element เพื่อแปลงวันที่ในทั้งสอง <p> เป็นภาษาไทย
checkoutElements1.forEach((checkoutElement) => {
    // ดึงข้อความที่มีอยู่ใน <p> เพื่อให้ได้วันที่
    const checkoutText1 =
        checkoutElement.querySelector("p:first-child").innerText;

    // แปลงข้อความวันที่เป็น Date object
    const checkoutDate1 = new Date(checkoutText1);

    // กำหนดรูปแบบและภาษาที่ต้องการให้แสดง
    const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    const formattedCheckoutDate1 = checkoutDate1.toLocaleDateString(
        "th-TH",
        options
    );

    // แสดงวันที่ในรูปแบบภาษาไทย
    checkoutElement.querySelector(
        "p:first-child"
    ).innerText = `${formattedCheckoutDate1}`;
});

//----แปลวันทีร่วันเข้าพัก
const createAtElemants = document.querySelectorAll(".createAt");
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

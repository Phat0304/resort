const urlParams = new URLSearchParams(window.location.search);
const date_checkin = document.getElementById("date-checkin");
const date_checkout = document.getElementById("date-checkout");
const select_adult = document.getElementById("select-adult");
const select_children = document.getElementById("select-children");
const form_search = document.getElementById("form-search");
const btn_search = document.querySelector(".btn-search");
const btn_scrolltop = document.querySelector(".btn-scrolltop");
const selects = document.querySelectorAll(".select");

let detailsURL = "";

function setDateSelected(date_checkin) {
    const checkin = dayjs(date_checkin);
    const tomorrow = checkin.add(1, "day");
    const formatted = tomorrow.format("YYYY-MM-DD");

    date_checkout.setAttribute("min", formatted);
    date_checkout.removeAttribute("disabled");
}

const urls = {
    checkin: urlParams.get("checkin"),
    checkout: urlParams.get("checkout"),
    adult: urlParams.get("adult"),
    children: urlParams.get("children"),
};

const someNullParam = Object.values(urls).some((value) => value === null);

if (someNullParam) {
    date_checkin.value = "";
    date_checkout.setAttribute("disabled", "");
    select_adult.value = "2";
    select_children.value = "1";
    detailsURL = "/roomdetails?id=";
} else {
    date_checkin.value = urls.checkin;
    date_checkout.value = urls.checkout;
    select_adult.value = urls.adult;
    select_children.value = urls.children;
    detailsURL = `/roomdetails?checkin=${urls.checkin}&checkout=${urls.checkout}&id=`;
    bookingDetailsURL = `/bookingdetails?checkin=${urls.checkin}&checkout=${urls.checkout}&id=`;

    setDateSelected(urls.checkin);
}

date_checkin.addEventListener("change", function () {
    if (date_checkout.value) {
        date_checkout.value = "";
    }
    setDateSelected(date_checkin.value);
});

function searchrooms(event) {
    event.preventDefault();

    const form = event.target;

    const formData = new FormData(form);

    const data = {
        checkin: formData.get("checkin"),
        checkout: formData.get("checkout"),
        adult: formData.get("adult"),
        children: formData.get("children"),
    };

    window.location.href = `/rooms?checkin=${data.checkin}&checkout=${data.checkout}&adult=${data.adult}&children=${data.children}`;
}

date_checkout.addEventListener("input", function (event) {
    btn_search.click();
});

selects.forEach((select) => {
    select.addEventListener("input", function () {
        if (date_checkout.value) {
            btn_search.click();
        } else {
            return false;
        }
    });
});

function roomDetails(room_id) {
    window.location.href = `${detailsURL}${room_id}`;
}

function book(room_id) {
    const btnModalReCap = document.getElementById("recap-modal");
    // const originalScrollPosition = window.scrollY;
    const isNullParams = someNullParam;
    if (isNullParams || !date_checkout.value || !date_checkin.value) {
        Swal.fire({
            icon: "info",
            text: "กรุณาเลือกวัน เช็คอิน - เช็คเอ้าท์",
        });
    } else {
        btnModalReCap.click();
        document.querySelector(".bookingURL").value = room_id;
    }
}

function closeModal() {
    window.location.reload();
}

function confirmreCaptcha(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    console.log("event", event);
    console.log("form", form);
    console.log("formData", formData);

    axios
        .post(`/confirmrecaptcha`, formData)
        .then(({ data }) => {
            const room_id = data.room_id;
            console.log("data", data);
            console.log("room_id", room_id);

            window.location.href = `${bookingDetailsURL}${room_id}`;
        })
        .catch((err) => {
            const message = document.querySelector(".invalid");
            if (err.response.status === 404) {
                message.innerText = "กรุณาตรวจสอบ reCaptcha";
            }
        });
}

function scrollToTop(_position) {
    window.scrollTo(0, 0);
}

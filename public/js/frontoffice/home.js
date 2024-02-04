const date_checkin = document.getElementById("date-checkin");
const date_checkout = document.getElementById("date-checkout");

date_checkin.addEventListener("change", function () {
    const checkin = dayjs(date_checkin.value);
    const tomorrow = checkin.add(1, "day"); //บวกอีก1วัน
    const formatted = tomorrow.format("YYYY-MM-DD");

    if (date_checkout.value) {
        date_checkout.value = "";
    }

    date_checkout.setAttribute('min', formatted)

    date_checkout.removeAttribute("disabled"); //สามารถเลือกวันที่ได้
});


function searchrooms(event) {
    event.preventDefault();

    const form = event.target;

    const formData = new FormData(form);

    const data = {
        checkin: formData.get('checkin'),
        checkout: formData.get('checkout'),
        adult: formData.get('adult'),
        children: formData.get('children'),
    }

    window.location.href = `/rooms?checkin=${data.checkin}&checkout=${data.checkout}&adult=${data.adult}&children=${data.children}`;
}

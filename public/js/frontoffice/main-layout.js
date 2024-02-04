const menus = document.querySelectorAll('a.nav-link')
const pathURL = window.location.pathname;

menus.forEach(menu => {
    if (menu.getAttribute('data-slug') === pathURL) {
        menu.classList.add('nav-active', 'active')
    }

});


/* เมื่อผู้ใช้งานปิดเบราเซอร์หรือแท็บ */
// window.addEventListener("beforeunload", function (e) {
//     // ทำบางอย่างก่อนที่ผู้ใช้จะออกจากเว็บไซต์
//     // เช่น บันทึกข้อมูลหรือแสดงข้อความต้อนรับ
//     // หรือทำการยืนยันก่อนออกจากเว็บไซต์

//     // ตัวอย่าง: แสดงข้อความต้อนรับ
//     e.returnValue = "คุณกำลังออกจากเว็บไซต์ของเรา";
// });

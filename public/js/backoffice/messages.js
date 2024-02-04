// new DataTable("#messages");
$(document).ready(function() {
    $('#messages').DataTable({
        "order": [] // กำหนด order เป็นรายการว่าง
    });
});

const formMsg = document.querySelectorAll(".form-msg");
const btn_modal = document.querySelector(".btn-modal");

function getMessage(_el, _id) {
    const badge = _el.closest("tr").querySelector(".badge");
    axios
        .get(`/admin/messageone/${_id}`)
        .then(({ data }) => {
            const formData = data.data["formData"];
            formMsg.forEach((form, ind) => {
                form.value = formData[ind];
            });
            badge.classList.remove("bg-warning", "text-dark");
            badge.classList.add("bg-secondary");
            badge.innerText = "อ่านแล้ว";
        })
        .catch((err) => console.log(err));
}

function deleteMessage(_el, _id) {
    axios
        .delete(`/admin/message/delete/${_id}`)
        .then(({ data }) => {
            if (data.status) {
                const row = _el.closest("tr");
                toastr.success("ลบข้อความสำเร็จ");

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

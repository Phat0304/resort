// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = "Kanit";
Chart.defaults.global.defaultFontColor = "#858796";

function number_format(number, decimals, dec_point, thousands_sep) {
    //ไม่ได้เขียน
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + "").replace(",", "").replace(" ", "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}

const roomsData = JSON.parse(
    document.getElementById("data").getAttribute("roomsData")
);
const bookingsData = JSON.parse(
    document.getElementById("data").getAttribute("bookingsData")
);
const bookingCompleteAll = JSON.parse(
    document.getElementById("data").getAttribute("bookingCompleteAll")
);
console.log("booking", bookingCompleteAll);
const mouthNumbers = [
    "01",
    "02",
    "03",
    "04",
    "05",
    "06",
    "07",
    "08",
    "09",
    "10",
    "11",
    "12",
];

let bar1 = document.getElementById("barChartDate");
let bar2 = document.getElementById("barChartMonth");
let pie1 = document.getElementById("pieChartDate");
let pie2 = document.getElementById("pieChartMonth");

let roomSet1 = new Array(),
    roomSet2 = new Array();

//id ห้อง
roomsData.forEach((room, ind) => {
    roomSet1[room.id] = 0;
    roomSet2[room.id] = 0;
});

//จำนวนการเข้าพักแต่ละห้อง
roomSet1.forEach((room, room_ind) => {
    bookingCompleteAll.forEach((book, book_ind) => {
        if (book.room_id === room_ind) {
            roomSet1[room_ind] += 1;
        }
    });
});

//รวมราคาเข้าพักของห้องนั้นๆ
roomSet2.forEach((room, room_ind) => {
    bookingCompleteAll.forEach((book, book_ind) => {
        if (book.room_id === room_ind) {
            roomSet2[room_ind] += book.price;
        }
    });
});

let barDatasets1 = roomsData.map((room) => {
    return {
        label: `${room.name}`,
        data: mouthNumbers.map((month, ind) => {
            let tt = 0;

            for (let book of bookingsData) {
                if (
                    room.id === book.room_id &&
                    month === book.month.toString()
                ) {
                    tt += 1;
                }
            }
            return tt;
        }),
        backgroundColor: `${room.color_code}`,
        borderWidth: 1,
        borderRadius: 10,
    };
});

let barDatasets2 = roomsData.map((room) => {
    return {
        label: `${room.name}`,
        data: mouthNumbers.map((month, ind) => {
            let tt = 0;
            console.log("tt", tt);
            for (let book of bookingsData) {
                if (
                    room.id === book.room_id &&
                    month === book.month.toString()
                ) {
                    tt += book.price;
                }
            }
            return tt;
        }),
        backgroundColor: `${room.color_code}`,
        borderWidth: 1,
        borderRadius: 10,
    };
});

let labelMonths = mouthNumbers.map((item) => {
    return dayjs(`${item}`, { locale: "th" }).format("MMMM");
});

let labelRooms = roomsData.map((item) => {
    return item.name;
});

let pieBgColor = roomsData.map((item) => {
    return item.color_code;
});

const pieDatasets1 = Object.values(roomSet1); // แปลง array object เป็น array
const pieDatasets2 = Object.values(roomSet2); // แปลง array object เป็น array

/* Chart Area */
let barChart1 = new Chart(bar1, {
    type: "bar",
    data: {
        labels: labelMonths,
        datasets: barDatasets1,
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0,
            },
        },
        scales: {
            xAxes: [
                {
                    time: {
                        unit: "date",
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        // maxTicksLimit: 12, //max labels
                    },
                },
            ],
            yAxes: [
                {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                            return number_format(value) + " ครั้ง";
                        },
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2],
                    },
                },
            ],
        },
        legend: {
            display: true,
            position: "bottom",
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: "#6e707e",
            titleFontSize: 14,
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: "index",
            caretPadding: 10,
            callbacks: {
                label: function (tooltipItem, chart) {
                    let datasetLabel =
                        chart.datasets[tooltipItem.datasetIndex].label || "";
                    return (
                        datasetLabel +
                        " : " +
                        number_format(tooltipItem.yLabel) +
                        " ครั้ง"
                    );
                },
            },
        },
    },
});

console.log("bar2 ", bar2);

let barChart2 = new Chart(bar2, {
    type: "bar",
    data: {
        labels: labelMonths,
        datasets: barDatasets2,
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0,
            },
        },
        scales: {
            xAxes: [
                {
                    time: {
                        unit: "date",
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        // maxTicksLimit: 12, //max labels
                    },
                },
            ],
            yAxes: [
                {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                            return number_format(value) + " บาท";
                        },
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2],
                    },
                },
            ],
        },
        legend: {
            display: true,
            position: "bottom",
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: "#6e707e",
            titleFontSize: 14,
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: "index",
            caretPadding: 10,
            callbacks: {
                label: function (tooltipItem, chart) {
                    var datasetLabel =
                        chart.datasets[tooltipItem.datasetIndex].label || "";
                    return (
                        datasetLabel +
                        " : " +
                        number_format(tooltipItem.yLabel) +
                        " บาท"
                    );
                },
            },
        },
    },
});
console.log("barChart2 ", barChart2);
pieChartArea(pie1, labelRooms, pieDatasets1, pieBgColor, " ครั้ง");
pieChartArea(pie2, labelRooms, pieDatasets2, pieBgColor, " บาท");

function pieChartArea(pieId, labelRooms, pieDatasets, pieBgColor, unit) {
    new Chart(pieId, {
        type: "pie",
        data: {
            labels: labelRooms,
            datasets: [
                {
                    data: pieDatasets,
                    backgroundColor: pieBgColor,
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                },
            ],
        },
        options: {
            maintainAspectRatio: true,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: "#dddfeb",
                borderWidth: 10,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function (tooltipItem, data) {
                        let dataset = data.datasets[tooltipItem.datasetIndex];
                        let total = dataset.data.reduce(function (
                            previousValue,
                            currentValue
                        ) {
                            return previousValue + currentValue;
                        });
                        let value = dataset.data[tooltipItem.index];
                        let percentage = ((value / total) * 100).toFixed(2);
                        return (
                            data.labels[tooltipItem.index] +
                            " : " +
                            value +
                            unit +
                            " (" +
                            percentage +
                            "%)"
                        );
                    },
                },
            },
            legend: {
                display: false,
            },
            cutoutPercentage: 0,
        },
    });
}

const img = document.querySelectorAll("#preview-img");
const file = document.querySelectorAll("#file1");

function previewImg(_ind = 0) {
    const image = file[_ind].files[0];
    let reader = new FileReader();
    reader.onloadend = () => {
        img[_ind].src = reader.result;
    };
    reader.readAsDataURL(image);
}


function previewEdit(_ind) {
    const image = file[_ind].files[0];
    let reader = new FileReader();
    reader.onloadend = () => {
        img[_ind].src = reader.result;
    };
    reader.readAsDataURL(image);
}

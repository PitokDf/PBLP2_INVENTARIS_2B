
//fungsi preview gambar//
function previewImage() {
    const image = document.getElementById('file_image');
    const imgPreview = document.getElementById('img-preview');

    // imgPreview.style.display = 'block';

    const ofReader = new FileReader();
    ofReader.readAsDataURL(image.files[0]);
    ofReader.onload = function (oFREvent) {
        imgPreview.src = oFREvent.target.result;
    }
}

window.previewImage = previewImage;
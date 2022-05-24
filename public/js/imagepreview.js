document.addEventListener('DOMContentLoaded', function () {
  const imageInput = document.querySelector("input.input_foto");
  const imagePreviewer = document.querySelector('img.preview_foto');
  // const imageOrigSrc = imagePreviewer.getAttribute('data-src-orig');

  imageInput.addEventListener('change', function (e) {
    const imgFile = e.target.files[0];
    previewFoto(imgFile);
  });

  function previewFoto(file) {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (readerEvent) {
      imagePreviewer.src = readerEvent.target.result;
    }
  }
});
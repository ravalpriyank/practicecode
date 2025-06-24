<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

<input type="file" id="pdfUpload" accept="application/pdf">
<canvas id="pdfCanvas" style="display: none;"></canvas>
<img id="pdfImage" />

<script>
document.getElementById('pdfUpload').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file.type !== 'application/pdf') return;

    const reader = new FileReader();
    reader.onload = function () {
        const typedarray = new Uint8Array(this.result);
        pdfjsLib.getDocument(typedarray).promise.then(pdf => {
            pdf.getPage(1).then(page => {
                const scale = 1.5;
                const viewport = page.getViewport({ scale });
                const canvas = document.getElementById('pdfCanvas');
                const context = canvas.getContext('2d');

                canvas.width = viewport.width;
                canvas.height = viewport.height;

                page.render({ canvasContext: context, viewport }).promise.then(() => {
                    const imgData = canvas.toDataURL("image/png");
                    document.getElementById('pdfImage').src = imgData;
                });
            });
        });
    };
    reader.readAsArrayBuffer(file);
});
</script>

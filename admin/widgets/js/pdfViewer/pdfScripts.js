function touhid_bricks_pdfViewer() {
    let workerScript = pdfViewerData['workerUrl'];
    let canvas = document.getElementById('pdf-viewer');

        console.log(canvas.dataset.url)
        let url = canvas.dataset.url;
        let width = canvas.dataset.width;
        let height = canvas.dataset.height;


// Loaded via <script> tag, create shortcut to access PDF.js exports.
        let { pdfjsLib } = globalThis;

// The workerSrc property shall be specified.

        pdfjsLib.GlobalWorkerOptions.workerSrc = workerScript

// Asynchronous download of PDF
        let loadingTask = pdfjsLib.getDocument(url);
        loadingTask.promise.then(function(pdf) {
            console.log('PDF loaded');

            // Fetch the first page
            let pageNumber = 1;
            pdf.getPage(pageNumber).then(function(page) {
                console.log('Page loaded');

                let scale = 1.5;
                let viewport = page.getViewport({scale: scale});

                // Prepare canvas using PDF page dimensions

                let context = canvas.getContext('2d');
                canvas.height = height;
                canvas.width = width;

                // Render PDF page into canvas context
                let renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                let renderTask = page.render(renderContext);
                renderTask.promise.then(function () {
                    console.log('Page rendered');
                });
            });
        }, function (reason) {
            // PDF loading error
            console.error(reason);
        });


}

document.addEventListener("DOMContentLoaded", (event) => {
    touhid_bricks_pdfViewer();
});

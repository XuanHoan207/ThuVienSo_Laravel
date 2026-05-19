<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - Thư Viện Số</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .preview-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .header-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.9);
            color: white;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }
        .header-title {
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .btn-close-preview {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .btn-close-preview:hover {
            background: rgba(255,255,255,0.3);
        }
        .content-area {
            margin-top: 70px;
            padding-bottom: 100px;
        }
        .pdf-page {
            background: white;
            padding: 30px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        canvas {
            max-width: 100%;
            height: auto !important;
        }
        .preview-overlay {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(237,85,59,0.98) 0%, rgba(237,85,59,0.95) 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
            z-index: 1000;
        }
        .preview-overlay h4 {
            margin: 0 0 8px 0;
            font-weight: 700;
        }
        .preview-overlay p {
            margin: 0 0 15px 0;
            opacity: 0.9;
        }
        .preview-overlay .btn {
            background: white;
            color: #ED553B;
            font-weight: 600;
            padding: 10px 30px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .preview-overlay .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .loading {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 60vh;
            color: white;
        }
        .text-preview {
            background: white;
            padding: 50px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            line-height: 2;
            font-size: 16px;
        }
        .text-preview h3 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .text-preview p {
            text-indent: 2em;
            margin-bottom: 1.5em;
            text-align: justify;
        }
        .text-preview .page-break {
            page-break-after: always;
            margin: 30px 0;
            border-bottom: 1px dashed #ddd;
            padding-bottom: 30px;
        }
        .badge-preview {
            background: #ffc107;
            color: #000;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-bar">
        <div class="header-title">
            <i class="bi bi-book"></i>
            <span>{{ $book->title }}</span>
            @if(!$isFullAccess)
                <span class="badge-preview">XEM THỬ</span>
            @endif
        </div>
        <div class="header-actions">
            <button class="btn-close-preview" onclick="window.close()">
                <i class="bi bi-x-lg"></i> Đóng
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="preview-container">
        <div class="content-area" id="contentArea">
            <div class="loading" id="loading">
                <div class="spinner-border text-light mb-3" role="status"></div>
                <p>Đang tải nội dung...</p>
            </div>
        </div>
    </div>

    <!-- Preview Limit Overlay -->
    @if(!$isFullAccess)
    <div class="preview-overlay" id="previewOverlay">
        <h4><i class="bi bi-info-circle me-2"></i>Hết giới hạn xem thử</h4>
        <p>Bạn đã xem miễn phí {{ $previewPages }} trang đầu tiên</p>
        <a href="{{ route('books.show', $book->slug) }}" class="btn">
            <i class="bi bi-cart-plus me-2"></i>Mua sách để đọc tiếp
        </a>
    </div>
    @endif

    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        const bookId = {{ $book->id }};
        const totalPages = {{ $book->pages ?? 1 }};
        const maxAllowedPages = {{ $isFullAccess ? ($book->pages ?? 999) : $previewPages }};
        const isPreview = {{ !$isFullAccess ? 'true' : 'false' }};
        const bookTitle = "{{ addslashes($book->title) }}";
        const bookFilePath = "{{ $book->file_path }}";

        let pdfDoc = null;
        const scale = 1.3;

        const previewTexts = [
            `<p style="text-indent: 2em;">Chào mừng bạn đến với cuốn sách "<strong>${bookTitle}</strong>". Đây là những dòng đầu tiên của tác phẩm, nơi chúng tôi sẽ dẫn dắt bạn vào một thế giới đầy mê hoặc của tri thức và kinh nghiệm.</p><p>Qua những trang sách, bạn sẽ khám phá những điều kỳ diệu và bài học quý giá từ cuộc sống. Trong những chương đầu tiên, chúng ta sẽ cùng nhau tìm hiểu về những nền tảng cơ bản nhất.</p>`,
            `<p style="text-indent: 2em;">Trong chương này, chúng ta sẽ tìm hiểu về những khái niệm cơ bản và cách áp dụng chúng vào thực tế. Những kiến thức được trình bày một cách logic và dễ hiểu, giúp bạn tiếp thu nhanh chóng.</p><p>Hãy cùng chúng tôi khám phá sâu hơn về chủ đề này. Chúng ta sẽ đi từ những điều đơn giản nhất, từng bước một xây dựng nền tảng vững chắc.</p>`,
            `<p style="text-indent: 2em;">Tiếp tục với những nội dung sâu hơn, phần này sẽ giúp bạn nắm vững kiến thức đã học. Các ví dụ thực tế được đưa ra để bạn có thể liên hệ và hiểu rõ hơn về cách áp dụng.</p><p>Đây là những bước quan trọng trong quá trình học tập của bạn. Hãy chắc chắn rằng bạn đã nắm vững từng phần trước khi tiếp tục với những nội dung phức tạp hơn.</p>`,
            `<p style="text-indent: 2em;">Ở phần tiếp theo, chúng ta sẽ đi sâu vào những chi tiết phức tạp hơn. Đây là nơi bạn sẽ tìm thấy những thông tin chuyên sâu và hữu ích, những kiến thức mà không phải ai cũng biết.</p><p>Hãy đầu tư thời gian để nghiên cứu kỹ lưỡng từng phần. Đừng vội vàng, hãy tận hưởng quá trình khám phá và học hỏi này.</p>`,
            `<p style="text-indent: 2em;">Đây là trang miễn phí cuối cùng. Chúng tôi hy vọng những gì bạn đã đọc sẽ truyền cảm hứng cho bạn mua và đọc toàn bộ cuốn sách "<strong>${bookTitle}</strong>".</p><p style="text-align: center; margin-top: 40px; color: #888;"><em>✦ Hết phần xem thử miễn phí ✦</em></p><p style="text-align: center; color: #666;">Để tiếp tục đọc những nội dung tiếp theo, xin vui lòng mua sách. Cảm ơn bạn đã dành thời gian xem thử!</p>`
        ];

        async function loadContent() {
            try {
                const pdfUrl = `/books/${bookId}/preview-pdf?t={{ $isFullAccess ? 'full' : 'preview' }}`;
                const loadingTask = pdfjsLib.getDocument({
                    url: pdfUrl,
                    cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
                    cMapPacked: true,
                });
                pdfDoc = await loadingTask.promise;
                await renderAllPages();
            } catch (error) {
                console.log('PDF load error, using text preview:', error);
                renderTextPreview();
            }
        }

        async function renderAllPages() {
            const container = document.getElementById('contentArea');
            const loading = document.getElementById('loading');
            loading.style.display = 'none';

            const pagesToShow = Math.min(pdfDoc.numPages, maxAllowedPages);

            for (let i = 1; i <= pagesToShow; i++) {
                const page = await pdfDoc.getPage(i);
                const viewport = page.getViewport({ scale: scale });

                const pageDiv = document.createElement('div');
                pageDiv.className = 'pdf-page';
                pageDiv.id = `page-${i}`;

                const canvas = document.createElement('canvas');
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                const ctx = canvas.getContext('2d');
                await page.render({
                    canvasContext: ctx,
                    viewport: viewport
                }).promise;

                pageDiv.appendChild(canvas);
                container.appendChild(pageDiv);
            }

            // Add text preview pages if PDF loaded but we need more content
            if (!isPreview) {
                // Load all PDF pages - done
            } else if (pdfDoc.numPages < maxAllowedPages) {
                // PDF has fewer pages than preview limit, add text
                for (let i = pdfDoc.numPages + 1; i <= maxAllowedPages; i++) {
                    const pageDiv = document.createElement('div');
                    pageDiv.className = 'pdf-page';
                    pageDiv.innerHTML = `<div class="text-preview"><h3>${bookTitle} - Trang ${i}</h3>${previewTexts[i - 1] || previewTexts[0]}</div>`;
                    container.appendChild(pageDiv);
                }
            }
        }

        function renderTextPreview() {
            const container = document.getElementById('contentArea');
            const loading = document.getElementById('loading');
            loading.style.display = 'none';

            for (let i = 1; i <= maxAllowedPages; i++) {
                const pageDiv = document.createElement('div');
                pageDiv.className = 'pdf-page';
                pageDiv.innerHTML = `<div class="text-preview"><h3>${bookTitle}</h3>${previewTexts[i - 1] || previewTexts[0]}</div>`;
                container.appendChild(pageDiv);
            }
        }

        // Initialize
        loadContent();
    </script>
@include('user.Chatbot.chatbot')
</body>
</html>

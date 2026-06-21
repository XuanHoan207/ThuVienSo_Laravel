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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0a0a0f;
            overflow: hidden;
        }
        .reader-wrapper {
            display: flex;
            height: 100vh;
            background: #0a0a0f;
        }
        /* Sidebar */
        .sidebar {
            width: 100px;
            background: #0a0a0f;
            border-right: 1px solid #333;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            z-index: 100;
        }
        .sidebar.collapsed { width: 0; overflow: hidden; }
        .sidebar-header {
            padding: 12px 8px;
            background: #0a0a0f;
            border-bottom: 1px solid #333;
            text-align: center;
        }
        .sidebar-header h6 {
            color: #888;
            margin: 0;
            font-size: 0.7rem;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .page-thumb-list {
            flex: 1;
            overflow-y: auto;
            padding: 8px;
        }
        .page-thumb-list::-webkit-scrollbar { width: 4px; }
        .page-thumb-list::-webkit-scrollbar-thumb { background: #333; border-radius: 2px; }
        .thumb-item {
            background: #1a1a2e;
            border-radius: 6px;
            padding: 8px 4px;
            margin-bottom: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            border: 2px solid transparent;
        }
        .thumb-item:hover { background: #2a2a3e; }
        .thumb-item.active { border-color: #ff7043; background: rgba(255, 112, 67, 0.15); }
        .thumb-item .page-num { color: #666; font-size: 0.65rem; margin-top: 4px; }
        .thumb-item.active .page-num { color: #ff7043; font-weight: 600; }
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        /* Header */
        .reader-header {
            height: 55px;
            background: #0a0a0f;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #222;
        }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .btn-toggle-sidebar {
            background: #1a1a2e;
            border: 1px solid #333;
            color: #888;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-toggle-sidebar:hover { background: #2a2a3e; color: #fff; border-color: #444; }
        .book-title-header {
            color: #ccc;
            font-size: 0.9rem;
            font-weight: 500;
            max-width: 400px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .header-center { display: flex; align-items: center; gap: 10px; color: #666; font-size: 0.85rem; }
        .page-nav-input {
            background: #1a1a2e;
            border: 1px solid #333;
            color: #fff;
            width: 50px;
            padding: 5px 8px;
            border-radius: 6px;
            font-size: 0.85rem;
            text-align: center;
            outline: none;
        }
        .page-nav-input:focus { border-color: #ff7043; }
        .page-nav-separator { color: #666; }
        .header-right { display: flex; align-items: center; gap: 10px; }
        .header-btn {
            background: #1a1a2e;
            border: 1px solid #333;
            color: #aaa;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .header-btn:hover { background: #2a2a3e; color: #fff; border-color: #444; }
        .header-btn.active { background: #ff7043; color: #fff; border-color: #ff7043; }
        .btn-close-reader {
            background: #1a1a2e;
            border: 1px solid #333;
            color: #888;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-close-reader:hover { background: #dc3545; color: #fff; border-color: #dc3545; }
        /* Content Area */
        .content-area {
            flex: 1;
            overflow: auto;
            padding: 20px;
            background: #12121a;
        }
        .content-area::-webkit-scrollbar { width: 8px; }
        .content-area::-webkit-scrollbar-track { background: #0a0a0f; }
        .content-area::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        .pdf-container { max-width: 850px; width: 100%; margin: 0 auto; }
        .pdf-page {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
            margin-bottom: 25px;
            overflow: hidden;
        }
        .pdf-page canvas { display: block; width: 100%; height: auto; }
        /* Loading */
        .loading-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 80px;
            color: #666;
        }
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #222;
            border-top-color: #ff7043;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        /* Footer */
        .reader-footer {
            height: 40px;
            background: #0a0a0f;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid #222;
        }
        .page-info { color: #555; font-size: 0.8rem; }
        .progress-info { display: flex; align-items: center; gap: 12px; }
        .progress-bar-wrapper {
            width: 120px;
            height: 4px;
            background: #222;
            border-radius: 2px;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            background: #ff7043;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        /* Preview Overlay */
        .preview-overlay {
            position: fixed;
            bottom: 0;
            left: 100px;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.98) 0%, rgba(0,0,0,0.9) 100%);
            padding: 25px;
            text-align: center;
            border-top: 1px solid #333;
            z-index: 1000;
        }
        .preview-overlay.full-width { left: 0; }
        .preview-overlay h5 { color: #fff; margin: 0 0 8px 0; font-size: 1rem; }
        .preview-overlay p { color: #888; margin: 0 0 15px 0; font-size: 0.85rem; }
        .preview-overlay .btn-buy {
            background: #ff7043;
            color: #fff;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        .preview-overlay .btn-buy:hover { background: #ff5722; transform: scale(1.05); }
        /* Voice Panel */
        .voice-panel {
            position: fixed;
            bottom: 60px;
            right: 20px;
            background: #0a0a0f;
            border: 1px solid #333;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            z-index: 1001;
            display: none;
            min-width: 240px;
        }
        .voice-panel.show { display: block; }
        .voice-panel h6 { color: #ccc; margin: 0 0 12px 0; font-size: 0.85rem; font-weight: 500; }
        .voice-panel select {
            width: 100%;
            background: #1a1a2e;
            border: 1px solid #333;
            color: #ccc;
            padding: 8px 10px;
            border-radius: 6px;
            margin-bottom: 10px;
            font-size: 0.85rem;
        }
        .voice-speed { display: flex; align-items: center; gap: 10px; color: #666; font-size: 0.8rem; }
        .voice-speed input { flex: 1; accent-color: #ff7043; }
        .voice-rate-val { color: #ff7043; min-width: 35px; text-align: right; }


    </style>
</head>
<body>
    <div class="reader-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h6><i class="bi bi-list-ul me-1"></i>Trang</h6>
            </div>
            <div class="page-thumb-list" id="pageThumbList"></div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="reader-header">
                <div class="header-left">
                    <button class="btn-toggle-sidebar" id="toggleSidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <span class="book-title-header">{{ $book->title }}</span>
                </div>
                <div class="header-center">
                    <i class="bi bi-book"></i>
                    <input type="number" class="page-nav-input" id="pageInput" min="1" value="1">
                    <span class="page-nav-separator">/</span>
                    <span id="totalPages">{{ $book->pages ?? '?' }}</span>
                    <span>trang</span>
                </div>
                <div class="header-right">
                    <button class="header-btn" id="btnListen" title="Nghe đọc">
                        <span id="listenText"></span>
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area" id="contentArea">
                <div class="loading-container" id="loadingContainer">
                    <div class="loading-spinner"></div>
                    <p style="margin-top: 15px;">Đang tải nội dung...</p>
                </div>
                <div class="pdf-container" id="pdfContainer"></div>
            </div>

            <!-- Footer -->
            <div class="reader-footer">
                <div class="page-info">
                    <span id="currentPageInfo">Trang 1 / {{ $book->pages ?? '?' }}</span>
                </div>
                <div class="progress-info">
                    <span class="page-info" id="progressText">0%</span>
                    <div class="progress-bar-wrapper">
                        <div class="progress-bar-fill" id="progressBar" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Overlay (chỉ hiện khi chưa mua và không phải người đăng) -->
    @if(!$isFullAccess)
    <div class="preview-overlay" id="previewOverlay">
        @if(isset($isUploader) && $isUploader)
        <h5><i class="bi bi-check-circle me-2"></i>Đây là sách của bạn</h5>
        <p>Bạn có thể đọc toàn bộ sách miễn phí vì bạn là người đăng tải</p>
        @else
        <h5><i class="bi bi-info-circle me-2"></i>Hết giới hạn xem thử</h5>
        <p>Bạn đã xem miễn phí {{ $previewPages }} trang đầu tiên</p>
        <a href="{{ route('books.show', $book->slug) }}" class="btn-buy">
            <i class="bi bi-cart-plus me-2"></i>Mua sách để đọc tiếp
        </a>
        @endif
    </div>
    @endif

    <!-- Voice Panel -->
    <div class="voice-panel" id="voicePanel">
        <h6><i class="bi bi-gear me-2"></i>Cài đặt giọng đọc</h6>
        <select id="voiceSelect"></select>
        <div class="voice-speed">
            <span>Tốc độ:</span>
            <input type="range" id="voiceRate" min="0.5" max="2" value="1" step="0.1">
            <span class="voice-rate-val" id="voiceRateValue">1.0x</span>
        </div>
    </div>

    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        const bookId = {{ $book->id }};
        const bookSlug = "{{ $book->slug }}";
        const totalPages = {{ $book->pages ?? 1 }};
        const maxAllowedPages = {{ $isFullAccess ? ($book->pages ?? 999) : $previewPages }};
        const bookTitle = "{{ addslashes($book->title) }}";

        let pdfDoc = null;
        const scale = 1.3;

        // Elements
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const thumbList = document.getElementById('pageThumbList');
        const contentArea = document.getElementById('contentArea');
        const pdfContainer = document.getElementById('pdfContainer');
        const loadingContainer = document.getElementById('loadingContainer');
        const previewOverlay = document.getElementById('previewOverlay');
        const btnListen = document.getElementById('btnListen');
        const listenText = document.getElementById('listenText');
        const voicePanel = document.getElementById('voicePanel');
        const voiceSelect = document.getElementById('voiceSelect');
        const voiceRate = document.getElementById('voiceRate');
        const voiceRateValue = document.getElementById('voiceRateValue');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const currentPageInfo = document.getElementById('currentPageInfo');

        // Generate thumbnails
        function generateThumbnails() {
            thumbList.innerHTML = '';
            for (let i = 1; i <= maxAllowedPages; i++) {
                const thumb = document.createElement('div');
                thumb.className = 'thumb-item';
                thumb.dataset.page = i;
                thumb.innerHTML = `<span style="color: #888; font-size: 1.2rem;">${i}</span><div class="page-num">Tr ${i}</div>`;
                thumb.addEventListener('click', () => scrollToPage(i));
                thumbList.appendChild(thumb);
            }
        }

        function scrollToPage(pageNum) {
            const pageEl = document.getElementById('page-' + pageNum);
            if (pageEl) pageEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
            updateActiveThumbnail(pageNum);
        }

        function updateActiveThumbnail(pageNum) {
            document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
            const active = document.querySelector(`.thumb-item[data-page="${pageNum}"]`);
            if (active) {
                active.classList.add('active');
                active.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
            currentPageInfo.textContent = `Trang ${pageNum} / ${totalPages}`;
            const progress = Math.round((pageNum / totalPages) * 100);
            progressBar.style.width = progress + '%';
            progressText.textContent = progress + '%';
        }

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            if (previewOverlay) previewOverlay.classList.toggle('full-width', sidebar.classList.contains('collapsed'));
        });

        // Load PDF
        async function loadPDF() {
            try {
                const pdfUrl = `/books/${bookSlug}/preview-pdf?t={{ $isFullAccess ? 'full' : 'preview' }}`;
                console.log('Loading PDF from:', pdfUrl);
                
                pdfDoc = await pdfjsLib.getDocument({
                    url: pdfUrl,
                    cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
                    cMapPacked: true,
                }).promise;
                console.log('PDF loaded, pages:', pdfDoc.numPages);
                await renderAllPages();
            } catch (error) {
                console.error('PDF load error:', error);
                loadingContainer.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <i class="bi bi-file-earmark-pdf" style="font-size: 64px;"></i>
                        <p style="margin-top: 20px; font-size: 18px;">File PDF không tồn tại hoặc bị lỗi.</p>
                        <p style="color: #999;">Vui lòng kiểm tra lại file sách.</p>
                    </div>
                `;
                // Try text preview as fallback
                renderTextPreview();
            }
        }

        async function renderAllPages() {
            loadingContainer.style.display = 'none';
            const pagesToRender = Math.min(pdfDoc.numPages, maxAllowedPages);

            for (let i = 1; i <= pagesToRender; i++) {
                const page = await pdfDoc.getPage(i);
                const viewport = page.getViewport({ scale: scale });
                const pageDiv = document.createElement('div');
                pageDiv.className = 'pdf-page';
                pageDiv.id = 'page-' + i;
                const canvas = document.createElement('canvas');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                await page.render({ canvasContext: canvas.getContext('2d'), viewport }).promise;
                pageDiv.appendChild(canvas);
                pdfContainer.appendChild(pageDiv);
            }

            if (!{{ $isFullAccess ? 'true' : 'false' }} && pdfDoc.numPages < maxAllowedPages) {
                for (let i = pdfDoc.numPages + 1; i <= maxAllowedPages; i++) {
                    const pageDiv = document.createElement('div');
                    pageDiv.className = 'pdf-page';
                    pageDiv.id = 'page-' + i;
                    pageDiv.innerHTML = `<div style="padding: 60px 50px; background: white; min-height: 700px;">
                        <h3 style="text-align: center; margin-bottom: 30px; color: #333;">${bookTitle}</h3>
                        <div style="line-height: 2; font-size: 16px; text-align: justify;">${getPreviewText(i)}</div>
                    </div>`;
                    pdfContainer.appendChild(pageDiv);
                }
            }
            updateActiveThumbnail(1);
        }

        function getPreviewText(pageNum) {
            const texts = [
                '<p style="text-indent: 2em;">Chào mừng bạn đến với cuốn sách. Đây là những dòng đầu tiên của tác phẩm, nơi chúng tôi sẽ dẫn dắt bạn vào một thế giới đầy mê hoặc của tri thức và kinh nghiệm.</p><p style="text-indent: 2em;">Qua những trang sách, bạn sẽ khám phá những điều kỳ diệu và bài học quý giá từ cuộc sống.</p>',
                '<p style="text-indent: 2em;">Trong chương này, chúng ta sẽ tìm hiểu về những khái niệm cơ bản và cách áp dụng chúng vào thực tế.</p><p style="text-indent: 2em;">Hãy cùng chúng tôi khám phá sâu hơn về chủ đề này. Chúng ta sẽ đi từ những điều đơn giản nhất.</p>',
                '<p style="text-indent: 2em;">Tiếp tục với những nội dung sâu hơn, phần này sẽ giúp bạn nắm vững kiến thức đã học.</p><p style="text-indent: 2em;">Đây là những bước quan trọng trong quá trình học tập của bạn.</p>',
                '<p style="text-indent: 2em;">Ở phần tiếp theo, chúng ta sẽ đi sâu vào những chi tiết phức tạp hơn.</p><p style="text-indent: 2em;">Hãy đầu tư thời gian để nghiên cứu kỹ lưỡng từng phần.</p>',
                '<p style="text-indent: 2em;">Đây là trang miễn phí cuối cùng. Chúng tôi hy vọng những gì bạn đã đọc sẽ truyền cảm hứng cho bạn mua và đọc toàn bộ cuốn sách.</p><p style="text-align: center; margin-top: 40px; color: #888;"><em>✦ Hết phần xem thử ✦</em></p>'
            ];
            return texts[(pageNum - 1) % texts.length] || texts[0];
        }

        function renderTextPreview() {
            loadingContainer.style.display = 'none';
            for (let i = 1; i <= maxAllowedPages; i++) {
                const pageDiv = document.createElement('div');
                pageDiv.className = 'pdf-page';
                pageDiv.id = 'page-' + i;
                pageDiv.innerHTML = `<div style="padding: 60px 50px; background: white; min-height: 700px;">
                    <h3 style="text-align: center; margin-bottom: 30px; color: #333;">${bookTitle}</h3>
                    <div style="line-height: 2; font-size: 16px; text-align: justify;">${getPreviewText(i)}</div>
                </div>`;
                pdfContainer.appendChild(pageDiv);
            }
            updateActiveThumbnail(1);
        }

        // Scroll detection
        contentArea.addEventListener('scroll', () => {
            const scrollTop = contentArea.scrollTop;
            const pages = document.querySelectorAll('.pdf-page');
            for (let i = pages.length - 1; i >= 0; i--) {
                if (scrollTop >= pages[i].offsetTop - 100) {
                    updateActiveThumbnail(i + 1);
                    break;
                }
            }
        });

        // Text-to-Speech
        const synth = window.speechSynthesis;
        let voices = [], currentUtterance = null;

        function loadVoices() {
            voices = synth.getVoices();
            voiceSelect.innerHTML = voices
                .filter(v => v.lang.includes('vi') || v.lang.includes('en'))
                .map(v => `<option value="${v.name}">${v.name}</option>`)
                .join('');
        }

        loadVoices();
        if (synth.onvoiceschanged !== undefined) synth.onvoiceschanged = loadVoices;

        voiceRate.addEventListener('input', () => {
            voiceRateValue.textContent = parseFloat(voiceRate.value).toFixed(1) + 'x';
        });

        btnListen.addEventListener('click', () => {
            voicePanel.classList.toggle('show');
            
            if (synth.speaking) {
                synth.cancel();
                btnListen.classList.remove('active');
                listenText.textContent = '';
                return;
            }

            const textContent = Array.from(document.querySelectorAll('.pdf-page'))
                .map(p => p.innerText)
                .join(' ');

            currentUtterance = new SpeechSynthesisUtterance(textContent);
            const selectedVoice = voices.find(v => v.name === voiceSelect.value);
            if (selectedVoice) currentUtterance.voice = selectedVoice;
            currentUtterance.rate = parseFloat(voiceRate.value);
            
            currentUtterance.onstart = () => {
                btnListen.classList.add('active');
                listenText.textContent = 'Dừng';
            };
            currentUtterance.onend = currentUtterance.onerror = () => {
                btnListen.classList.remove('active');
                listenText.textContent = '';
            };

            synth.speak(currentUtterance);
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown' || e.key === 'PageDown') {
                contentArea.scrollBy({ top: 500, behavior: 'smooth' });
            } else if (e.key === 'ArrowUp' || e.key === 'PageUp') {
                contentArea.scrollBy({ top: -500, behavior: 'smooth' });
            } else if (e.key === 'Escape') {
                if (voicePanel.classList.contains('show')) voicePanel.classList.remove('show');
            }
        });

        // Page jump input
        const pageJumpInput = document.getElementById('pageInput');
        const totalPagesDisplay = document.getElementById('totalPages');
        const maxPages = parseInt(totalPagesDisplay.textContent) || maxAllowedPages;

        pageJumpInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const jumpTo = parseInt(this.value);
                if (jumpTo >= 1 && jumpTo <= maxPages) {
                    const targetPageEl = document.getElementById('page-' + jumpTo);
                    if (targetPageEl) {
                        targetPageEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                } else {
                    this.value = 1;
                }
            }
        });

        // Init
        generateThumbnails();
        loadPDF();
    </script>
    @include('user.Chatbot.chatbot')
</body>
</html>

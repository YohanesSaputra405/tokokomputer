<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Tambah Produk</title>
    <style>
        /* Styles singkat untuk upload UI */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fa;
            padding: 30px
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .06)
        }

        h2 {
            margin: 0 0 12px
        }

        .form-row {
            margin-bottom: 12px
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600
        }

        input[type=text],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d0d7de;
            border-radius: 6px;
            box-sizing: border-box
        }

        textarea {
            min-height: 120px
        }

        .btn {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 6px;
            border: 0;
            background: #2563eb;
            color: #fff;
            cursor: pointer
        }

        .btn.secondary {
            background: #6b7280
        }

        .error {
            color: #b91c1c;
            font-size: 13px;
            margin-top: 6px
        }

        /* upload area */
        .upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            padding: 18px;
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
            background: #fbfdff;
            position: relative
        }

        .upload-placeholder {
            flex: 1;
            min-width: 200px;
            color: #64748b
        }

        .upload-actions {
            display: flex;
            gap: 8px
        }

        .upload-input {
            display: none
        }

        /* preview grid */
        .preview-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 12px
        }

        .preview-card {
            width: 140px;
            height: 140px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            border: 1px solid #e6edf3;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .preview-card img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .remove-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #ef4444;
            color: white;
            border: 0;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700
        }

        .drag-hint {
            position: absolute;
            left: 8px;
            top: 8px;
            background: rgba(0, 0, 0, 0.45);
            color: #fff;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 12px
        }

        .progress-wrap {
            width: 100%;
            background: #f1f5f9;
            border-radius: 8px;
            margin-top: 12px;
            overflow: hidden
        }

        .progress-bar {
            height: 8px;
            background: #10b981;
            width: 0%
        }

        .small {
            font-size: 13px;
            color: #475569
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        <h2>Tambah Produk</h2>

        <form id="productForm" method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" required value="{{ old('nama_produk') }}">
                @error('nama_produk')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <label>Kategori</label>
                <select name="id_kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" @if (old('id_kategori') == $item->id) selected @endif>
                            {{ $item->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('id_kategori')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-row">
                <label>Deskripsi</label>
                <textarea name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- <div class="form-row">
                <label>Gambar Produk (max <span id="maxCount">6</span> gambar, tiap file max 4MB)</label>

                <div class="upload-area" id="uploadArea">
                    <div class="upload-placeholder">
                        <div class="small">Tarik & lepas gambar di sini atau klik "Pilih Gambar"</div>
                        <div class="small" style="margin-top:8px">Gambar akan di-resize ke max 1080×1080 sebelum
                            upload.</div>
                    </div>

                    <div class="upload-actions">
                        <label class="btn secondary">Pilih Gambar
                            <input type="file" id="fileInput" name="images[]"class="upload-input" accept="image/*"
                                multiple>
                        </label>
                        <button type="button" class="btn" id="clearAll">Hapus Semua</button>
                    </div>

                    <div style="width:100%"></div>
                    <div class="preview-grid" id="previewGrid" aria-live="polite"></div>
                </div>

                <div class="progress-wrap" id="progressWrap" style="display:none">
                    <div class="progress-bar" id="progressBar"></div>
                </div>
                <div class="small" id="uploadInfo"></div>

                <div id="inputError" class="error">
                    @error('images.*')
                        {{ $message }}
                    @enderror
                </div>
            </div> --}}
            <div style="margin-top:16px">
                <button type="submit" class="btn" id="submitBtn">Simpan Produk</button>
            </div>
        </form>
        <div>
            <a href="{{ route('admin.produk.index') }}">Kembali</a>
        </div>
    </div>

    {{-- <script>
        // CONFIG
        const MAX_FILES = 6;
        const MAX_FILE_SIZE_KB = 4096; // 4MB
        const MAX_IMAGE_DIM = 1080;

        let filesArr = []; // {file, name, previewUrl}
        const previewGrid = document.getElementById('previewGrid');
        const fileInput = document.getElementById('fileInput');
        const uploadArea = document.getElementById('uploadArea');
        const submitBtn = document.getElementById('submitBtn');
        const progressWrap = document.getElementById('progressWrap');
        const progressBar = document.getElementById('progressBar');
        const uploadInfo = document.getElementById('uploadInfo');
        const maxCountEl = document.getElementById('maxCount');
        maxCountEl.innerText = MAX_FILES;

        // helper resize using canvas => returns File
        function resizeImage(file, maxDim = MAX_IMAGE_DIM, quality = 0.82) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                const reader = new FileReader();
                reader.onload = e => {
                    img.onload = () => {
                        let w = img.width,
                            h = img.height;
                        const scale = Math.min(1, maxDim / Math.max(w, h));
                        const cw = Math.round(w * scale),
                            ch = Math.round(h * scale);
                        const canvas = document.createElement('canvas');
                        canvas.width = cw;
                        canvas.height = ch;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, cw, ch);
                        canvas.toBlob(blob => {
                            if (!blob) return reject(new Error('convert failed'));
                            const ext = 'jpg';
                            const name = Date.now() + '-' + Math.random().toString(36).slice(2, 8) +
                                '.' + ext;
                            const newFile = new File([blob], name, {
                                type: 'image/jpeg'
                            });
                            resolve(newFile);
                        }, 'image/jpeg', quality);
                    };
                    img.onerror = reject;
                    img.src = e.target.result;
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }

        async function handleFiles(list) {
            const arr = Array.from(list);
            for (let f of arr) {
                if (filesArr.length >= MAX_FILES) {
                    alert('Maksimum ' + MAX_FILES + ' gambar.');
                    break;
                }
                if (!f.type.startsWith('image/')) {
                    alert('Hanya file gambar.');
                    continue;
                }
                try {
                    const resized = await resizeImage(f, MAX_IMAGE_DIM);
                    if (resized.size > MAX_FILE_SIZE_KB * 1024) {
                        alert('File ' + f.name + ' masih terlalu besar setelah compress. Maks ' + (MAX_FILE_SIZE_KB /
                            1024) + 'MB.');
                        continue;
                    }
                    const previewUrl = URL.createObjectURL(resized);
                    filesArr.push({
                        file: resized,
                        name: resized.name,
                        previewUrl
                    });
                    renderPreviews();
                } catch (err) {
                    console.error(err);
                    alert('Gagal memproses ' + f.name);
                }
            }
        }

        function renderPreviews() {
            previewGrid.innerHTML = '';
            filesArr.forEach((item, idx) => {
                const card = document.createElement('div');
                card.className = 'preview-card';
                card.draggable = true;
                card.dataset.index = idx;

                const img = document.createElement('img');
                img.src = item.previewUrl;
                const remove = document.createElement('button');
                remove.className = 'remove-btn';
                remove.innerText = '×';
                remove.onclick = () => {
                    URL.revokeObjectURL(item.previewUrl);
                    filesArr.splice(idx, 1);
                    renderPreviews();
                };

                const dragHint = document.createElement('div');
                dragHint.className = 'drag-hint';
                dragHint.innerText = 'Seret';

                card.appendChild(img);
                card.appendChild(remove);
                card.appendChild(dragHint);
                previewGrid.appendChild(card);

                card.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', idx);
                    card.style.opacity = '0.4';
                });
                card.addEventListener('dragend', () => card.style.opacity = '1');
                card.addEventListener('dragover', (e) => e.preventDefault());
                card.addEventListener('drop', (e) => {
                    e.preventDefault();
                    const from = parseInt(e.dataTransfer.getData('text/plain'), 10);
                    const to = parseInt(card.dataset.index, 10);
                    if (from === to) return;
                    const it = filesArr.splice(from, 1)[0];
                    filesArr.splice(to, 0, it);
                    renderPreviews();
                });
            });
        }

        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
            e.target.value = '';
        });

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = '#3b82f6';
        });
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.style.borderColor = '#cbd5e1';
        });
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = '#cbd5e1';
            handleFiles(e.dataTransfer.files);
        });

        document.getElementById('clearAll').addEventListener('click', () => {
            filesArr.forEach(f => URL.revokeObjectURL(f.previewUrl));
            filesArr = [];
            renderPreviews();
        });

        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitBtn.disabled = true;
            const form = e.target;
            if (!form.nama_produk.value.trim()) {
                alert('Nama produk wajib');
                submitBtn.disabled = false;
                return;
            }
            if (!form.id_kategori.value) {
                alert('Pilih kategori');
                submitBtn.disabled = false;
                return;
            }

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('nama_produk', form.nama_produk.value);
            formData.append('id_kategori', form.id_kategori.value);
            formData.append('deskripsi', form.deskripsi.value);

            filesArr.forEach((it) => formData.append('images[]', it.file, it.name));

            progressWrap.style.display = 'block';
            progressBar.style.width = '0%';
            uploadInfo.innerText = 'Mengunggah...';

            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action, true);
            xhr.setRequestHeader(
                'X-CSRF-TOKEN',
                document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            );
            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    const pct = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = pct + '%';
                    uploadInfo.innerText = pct + '%';
                }
            };
            xhr.onload = function() {
                submitBtn.disabled = false;
                if (xhr.status >= 200 && xhr.status < 300) {
                    window.location.href = "{{ route('produk.index') }}";
                } else {
                    alert('Upload gagal.');
                    progressWrap.style.display = 'none';
                }
            };
            xhr.onerror = function() {
                alert('Gagal mengupload.');
                submitBtn.disabled = false;
            };
            xhr.send(formData);
        });
    </script> --}}
</body>

</html>

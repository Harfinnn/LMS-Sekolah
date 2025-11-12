// public/js/gallery-upload.js
(function () {
    // pastikan script dieksekusi setelah DOM siap (defer pada tag <script> juga membantu)
    function init() {
        const input = document.getElementById("images");
        const preview = document.getElementById("preview");
        const dropzone = document.getElementById("dropzone");
        const clearBtn = document.getElementById("clearBtn");
        const MAX_SIZE = 5 * 1024 * 1024; // 5MB

        if (!input || !preview || !dropzone || !clearBtn) {
            // elemen tidak ada => nada to do
            return;
        }

        function humanFileSize(size) {
            if (size < 1024) return size + " B";
            const i = Math.floor(Math.log(size) / Math.log(1024));
            return (
                (size / Math.pow(1024, i)).toFixed(1) +
                " " +
                ["B", "KB", "MB", "GB"][i]
            );
        }

        function clearPreview() {
            preview.innerHTML = "";
        }

        function showPreview(files) {
            clearPreview();
            Array.from(files).forEach((file) => {
                const card = document.createElement("div");
                card.className =
                    "relative rounded-lg overflow-hidden border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 p-1";

                if (!file.type.startsWith("image/")) {
                    card.innerHTML = `<div class="p-3 text-xs text-red-600">File bukan gambar</div>`;
                    preview.appendChild(card);
                    return;
                }

                if (file.size > MAX_SIZE) {
                    card.innerHTML = `<div class="p-3 text-xs text-red-600">${escapeHtml(
                        file.name
                    )} — Terlalu besar (${humanFileSize(file.size)})</div>`;
                    preview.appendChild(card);
                    return;
                }

                const img = document.createElement("img");
                img.className = "w-full h-28 object-cover rounded";
                img.alt = file.name;

                const info = document.createElement("div");
                info.className = "mt-1 text-xs text-gray-500 text-center";
                info.textContent = `${file.name} • ${humanFileSize(file.size)}`;

                card.appendChild(img);
                card.appendChild(info);
                preview.appendChild(card);

                const reader = new FileReader();
                reader.onload = (e) => (img.src = e.target.result);
                reader.readAsDataURL(file);
            });
        }

        // simple escape helper for filenames inserted into HTML
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        input.addEventListener("change", (e) => {
            showPreview(e.target.files);
        });

        // Drag & drop UX
        ["dragenter", "dragover"].forEach((evt) =>
            dropzone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add(
                    "ring-2",
                    "ring-green-300",
                    "ring-offset-2"
                );
            })
        );

        ["dragleave", "drop"].forEach((evt) =>
            dropzone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove(
                    "ring-2",
                    "ring-green-300",
                    "ring-offset-2"
                );
            })
        );

        dropzone.addEventListener("drop", (e) => {
            const dt = e.dataTransfer;
            if (!dt) return;
            // Note: assigning files langsung ke input hanya bekerja di beberapa browser.
            // Kita set input.files = dt.files supaya form submission bekerja jika didukung.
            try {
                input.files = dt.files;
            } catch (err) {
                // ignore jika tidak diizinkan oleh browser
            }
            showPreview(dt.files);
        });

        clearBtn.addEventListener("click", () => {
            // reset input file
            input.value = "";
            clearPreview();
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();

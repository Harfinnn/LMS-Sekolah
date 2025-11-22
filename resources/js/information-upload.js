// information-upload.js
(function () {
    "use strict";

    const MAX_SIZE = 2 * 1024 * 1024; // 2MB

    function humanFileSize(size) {
        if (size < 1024) return size + " B";
        const i = Math.floor(Math.log(size) / Math.log(1024));
        return (
            (size / Math.pow(1024, i)).toFixed(1) +
            " " +
            ["B", "KB", "MB", "GB"][i]
        );
    }

    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function clearPreview(previewImg, placeholder) {
        previewImg.src = "";
        previewImg.classList.add("hidden");
        if (placeholder) placeholder.classList.remove("hidden");
        const info = document.getElementById("previewInfo");
        if (info) info.remove();
    }

    function showPreview(files, previewImg, placeholder) {
        // Only handle first file (single image upload)
        clearPreview(previewImg, placeholder);
        const file = files[0];
        if (!file) return;

        if (!file.type.startsWith("image/")) {
            alert("File bukan gambar");
            return;
        }

        if (file.size > MAX_SIZE) {
            alert(
                `${escapeHtml(file.name)} — Terlalu besar (${humanFileSize(
                    file.size
                )}). Maks: ${humanFileSize(MAX_SIZE)}`
            );
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove("hidden");
            if (placeholder) placeholder.classList.add("hidden");

            // add info under image
            const info = document.createElement("div");
            info.id = "previewInfo";
            info.className = "mt-2 text-xs text-slate-400 text-center";
            info.textContent = `${file.name} • ${humanFileSize(file.size)}`;

            previewImg.insertAdjacentElement("afterend", info);
        };
        reader.readAsDataURL(file);
    }

    function init() {
        const input = document.getElementById("gambar");
        const previewImg = document.getElementById("preview");
        const placeholder = document.getElementById("placeholder");

        if (!input || !previewImg || !placeholder) return;

        input.addEventListener("change", (e) => {
            showPreview(e.target.files, previewImg, placeholder);
        });

        // drag & drop on the closest label (dropzone)
        const dropzone = input.closest("label");
        if (!dropzone) return;

        ["dragenter", "dragover"].forEach((evt) =>
            dropzone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add(
                    "ring-2",
                    "ring-green-300",
                    "ring-offset-2"
                );
                dropzone.classList.add("bg-slate-700");
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
                dropzone.classList.remove("bg-slate-700");
            })
        );

        dropzone.addEventListener("drop", (e) => {
            const dt = e.dataTransfer;
            if (!dt) return;
            const files = dt.files;
            try {
                input.files = files;
            } catch (err) {
                // some browsers disallow setting files programmatically; fall back to manual handling
            }
            showPreview(files, previewImg, placeholder);
        });

        // Optional keyboard: clear preview when Escape is pressed while file input is focused
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape" && document.activeElement === input) {
                input.value = "";
                clearPreview(previewImg, placeholder);
            }
        });

        // expose for inline use if needed
        window.previewImage = function (event) {
            showPreview(event.target.files, previewImg, placeholder);
        };
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();

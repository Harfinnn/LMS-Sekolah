(function () {
    function initMaterialForm() {
        const categorySelect = document.getElementById('category-select');
        const videoFields = document.getElementById('video-fields');
        const textFields = document.getElementById('text-fields');

        if (!categorySelect || !videoFields || !textFields) {
            return; // kalau bukan halaman form materi, langsung keluar
        }

        function updateVisibility() {
            const val = categorySelect.value;

            videoFields.classList.add('hidden');
            textFields.classList.add('hidden');

            if (val === 'video') {
                videoFields.classList.remove('hidden');
            } else if (val === 'text') {
                textFields.classList.remove('hidden');
            }
        }

        categorySelect.addEventListener('change', updateVisibility);
        updateVisibility(); // initial (untuk nilai awal / old() / data edit)
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMaterialForm);
    } else {
        initMaterialForm();
    }
})();

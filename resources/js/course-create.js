(function () {
    const categorySelect = document.getElementById("category-select");
    const videoFields = document.getElementById("video-fields");
    const textFields = document.getElementById("text-fields");

    function updateVisibility() {
        const val = categorySelect.value;
        videoFields.classList.add("hidden");
        textFields.classList.add("hidden");

        if (val === "video") {
            videoFields.classList.remove("hidden");
        } else if (val === "text") {
            textFields.classList.remove("hidden");
        }
    }

    if (categorySelect) {
        categorySelect.addEventListener("change", updateVisibility);
        // initial
        updateVisibility();
    }
})();

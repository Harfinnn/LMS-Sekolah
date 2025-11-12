// resources/js/partners.js
// Enhancements for partners marquee/track
// - duplicates items for seamless looping
// - auto-calculates animation duration based on content width
// - pauses animation when element is offscreen
// - adjusts on resize
(function () {
    const DEFAULT_SPEED = 25; // baseline seconds (can be overridden via data-speed attribute on parent)

    function debounce(fn, wait = 150) {
        let t;
        return function (...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function ensureDuplicated(track) {
        // ensure the track has at least two sets of items (so translateX(-50%) works)
        const items = Array.from(track.children);
        if (items.length === 0) return;

        // If items already duplicated (we detect by checking if first child's data-duplicated flag present), skip
        const first = track.children[0];
        if (first && first.dataset && first.dataset.original === "true") return;

        // mark originals
        items.forEach((it) => (it.dataset.original = "true"));

        // duplicate once (we expect CSS keyframes use -50% translate)
        const clone = track.innerHTML;
        track.insertAdjacentHTML("beforeend", clone);
    }

    function calculateDuration(track, baseSpeedSeconds = DEFAULT_SPEED) {
        // aim: longer content => longer duration. We'll scale duration by track scrollWidth
        // Normalize: duration = baseSpeedSeconds * (track.scrollWidth / containerWidth) / 2
        const container = track.parentElement;
        const containerWidth = container ? container.clientWidth || 1 : 1;
        const contentWidth = track.scrollWidth || containerWidth;
        const ratio = contentWidth / containerWidth;
        // keep ratio at least 1
        const clampedRatio = Math.max(1, ratio);
        const duration = Math.max(
            8,
            Math.round(baseSpeedSeconds * clampedRatio)
        ); // min 8s
        return duration;
    }

    function applyDuration(track, seconds) {
        // set as inline style so CSS picks it up: animation-duration on track element
        track.style.animationDuration = `${seconds}s`;
    }

    function observeVisibility(track) {
        // Pause animation when offscreen
        if (!("IntersectionObserver" in window)) return;
        const io = new IntersectionObserver(
            (entries) => {
                entries.forEach((e) => {
                    if (e.intersectionRatio > 0) {
                        // resume
                        track.style.animationPlayState = "running";
                    } else {
                        // pause
                        track.style.animationPlayState = "paused";
                    }
                });
            },
            { threshold: 0.01 }
        );
        io.observe(track);
        // store reference for potential disconnect later
        track._partners_io = io;
    }

    function initTrack(track) {
        if (!track) return;
        // If already init, skip (but still recalc duration)
        if (!track.dataset.partnersInit) {
            ensureDuplicated(track);
            track.dataset.partnersInit = "1";
            observeVisibility(track);
        }
        const parent = track.parentElement;
        let baseSpeed = DEFAULT_SPEED;
        // allow overriding via data attribute on parent (e.g. <div data-speed="30">)
        if (parent && parent.dataset && parent.dataset.speed) {
            const v = parseFloat(parent.dataset.speed);
            if (!isNaN(v) && v > 0) baseSpeed = v;
        }
        const duration = calculateDuration(track, baseSpeed);
        applyDuration(track, duration);
    }

    function initAll() {
        const tracks = document.querySelectorAll(".partners-track");
        tracks.forEach(initTrack);
    }

    // run on DOM ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initAll);
    } else {
        initAll();
    }

    // re-init on resize with debounce
    window.addEventListener("resize", debounce(initAll, 200));
})();

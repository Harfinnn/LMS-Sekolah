import L from "leaflet";
import iconUrl from "leaflet/dist/images/marker-icon.png";
import iconRetinaUrl from "leaflet/dist/images/marker-icon-2x.png";
import shadowUrl from "leaflet/dist/images/marker-shadow.png";

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl,
    iconUrl,
    shadowUrl,
});

function escapeHtml(str) {
    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

export default function initMaps() {
    const containers = document.querySelectorAll('[id^="map-location-"]');

    containers.forEach((el) => {
        const lat = parseFloat(el.dataset.lat) || -6.2;
        const lng = parseFloat(el.dataset.lng) || 106.816666;
        const placeName = el.dataset.place || "Lokasi";
        const address = el.dataset.address || "";

        if (el._leaflet_map) {
            const map = el._leaflet_map;

            map.setView([lat, lng], 15);

            const existingMarker = Object.values(map._layers).find(
                (l) => l instanceof L.Marker
            );

            if (existingMarker) {
                existingMarker.setLatLng([lat, lng]);
                existingMarker
                    .getPopup()
                    .setContent(
                        `<strong>${escapeHtml(placeName)}</strong>${
                            address ? `<br>${escapeHtml(address)}` : ""
                        }`
                    );
            } else {
                const newMarker = L.marker([lat, lng]).addTo(map);
                newMarker.bindPopup(
                    `<strong>${escapeHtml(placeName)}</strong>${
                        address ? `<br>${escapeHtml(address)}` : ""
                    }`
                );
            }

            setTimeout(() => map.invalidateSize(), 200);
            return; 
        }

        const map = L.map(el.id, {
            center: [lat, lng],
            zoom: 15,
            scrollWheelZoom: false,
            dragging: true,
            tap: false,
        });

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
            attribution: "&copy; OpenStreetMap contributors",
        }).addTo(map);

        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup(
            `<strong>${escapeHtml(placeName)}</strong>${
                address ? `<br>${escapeHtml(address)}` : ""
            }`
        );

        el.setAttribute("tabindex", "0");
        el.addEventListener("keydown", (ev) => {
            if (ev.key === "Enter" || ev.key === " ") {
                marker.openPopup();
            }
        });

        setTimeout(() => map.invalidateSize(), 200);

        el._leaflet_map = map;
    });
}

function autoInit() {
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initMaps, { once: true });
    } else {
        initMaps();
    }

    document.addEventListener("turbo:load", initMaps);
    document.addEventListener("turbolinks:load", initMaps);
    document.addEventListener("pjax:success", initMaps);
}

autoInit();

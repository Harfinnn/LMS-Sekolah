function safeParse(id) {
    const el = document.getElementById(id);
    if (!el) return {};
    const raw = el.textContent || "";
    try {
        return JSON.parse(raw);
    } catch (err) {
        console.error("JSON parse error for #" + id, err, raw.slice(0, 200));
        return {};
    }
}

// data jadwal per hari (semua kelas)
const schedulesByDay = safeParse("schedules-data");

(function () {
    const daySelect = document.getElementById("day-select");
    const existingContainer = document.getElementById("existing-slots");
    const startInput = document.getElementById("start-time");
    const endInput = document.getElementById("end-time");
    const form = document.getElementById("create-schedule-form");

    const gradeSelect = document.querySelector('select[name="grade_level"]');
    const classSelect = document.querySelector('select[name="class_group"]');

    const SCHOOL_START = "08:00";
    const SCHOOL_END = "15:40";

    function formatSlot(s) {
        return `${s.subject} — ${s.start_time} - ${s.end_time}`;
    }

    function toMinutes(hhmm) {
        if (!hhmm) return 0;
        const [h, m] = hhmm.split(":").map(Number);
        return h * 60 + m;
    }

    function toHHMM(minutes) {
        const h = Math.floor(minutes / 60);
        const m = minutes % 60;
        return String(h).padStart(2, "0") + ":" + String(m).padStart(2, "0");
    }

    // ambil slot sesuai hari + kelas + sub kelas
    function getFilteredSlots(day) {
        const grade = gradeSelect ? gradeSelect.value : "";
        const group = classSelect ? classSelect.value : "";

        // kalau tingkat / sub kelas belum dipilih → kosong
        if (!grade || !group) return [];

        const slots = schedulesByDay[day] || [];
        return slots.filter(
            (s) => s.grade_level === grade && s.class_group === group
        );
    }

    function renderExisting(day) {
        if (!existingContainer) return;
        existingContainer.innerHTML = "";

        const grade = gradeSelect ? gradeSelect.value : "";
        const group = classSelect ? classSelect.value : "";

        // belum pilih tingkat / sub kelas → jangan tampilkan apa-apa
        if (!grade || !group) {
            // kalau mau, bisa kasih hint kecil:
            // existingContainer.innerHTML = '<div class="text-slate-400 text-xs">Pilih tingkat dan sub kelas terlebih dahulu.</div>';
            return;
        }

        const slots = getFilteredSlots(day);
        if (!slots.length) {
            existingContainer.innerHTML = `<div class="text-slate-400 text-xs">Belum ada slot pada hari ini untuk kelas ${grade} ${group}.</div>`;
            return;
        }

        slots.sort((a, b) => a.start_time.localeCompare(b.start_time));
        const ul = document.createElement("ul");
        ul.className = "list-disc pl-5 text-xs";
        slots.forEach((s) => {
            const li = document.createElement("li");
            li.textContent = formatSlot(s);
            ul.appendChild(li);
        });
        existingContainer.appendChild(ul);
    }

    function suggestNextStart(day) {
        const slots = getFilteredSlots(day);
        if (!slots.length) return SCHOOL_START;
        let latest = SCHOOL_START;
        slots.forEach((s) => {
            if (toMinutes(s.end_time) > toMinutes(latest)) latest = s.end_time;
        });
        const suggestedMin = toMinutes(latest) + 5;
        if (suggestedMin > toMinutes(SCHOOL_END)) return null;
        return toHHMM(suggestedMin);
    }

    function updateMinMax(day) {
        if (!startInput || !endInput) return;

        const grade = gradeSelect ? gradeSelect.value : "";
        const group = classSelect ? classSelect.value : "";

        startInput.min = SCHOOL_START;
        startInput.max = SCHOOL_END;
        endInput.min = "08:05";
        endInput.max = SCHOOL_END;

        // belum pilih kelas → jangan auto-suggest apa-apa
        if (!grade || !group) {
            startInput.value = "";
            endInput.value = "";
            return;
        }

        const suggested = suggestNextStart(day);
        if (suggested === null) {
            existingContainer.innerHTML =
                '<div class="text-red-400 text-xs">Tidak ada slot tersisa hari ini (batas jam sekolah tercapai).</div>';
            startInput.value = "";
            endInput.value = "";
            startInput.disabled = true;
            endInput.disabled = true;
        } else {
            startInput.disabled = false;
            endInput.disabled = false;
            if (!startInput.value) startInput.value = suggested;

            const minEndMinutes = toMinutes(startInput.value) + 5;
            endInput.min = toHHMM(minEndMinutes);

            if (!endInput.value) {
                const defaultEnd = toMinutes(startInput.value) + 45;
                endInput.value = toHHMM(
                    Math.min(defaultEnd, toMinutes(SCHOOL_END))
                );
            }
        }
    }

    if (daySelect) {
        daySelect.addEventListener("change", function () {
            const day = this.value;
            renderExisting(day);
            updateMinMax(day);
        });
    }

    if (gradeSelect) {
        gradeSelect.addEventListener("change", function () {
            if (daySelect) {
                renderExisting(daySelect.value);
                updateMinMax(daySelect.value);
            }
        });
    }

    if (classSelect) {
        classSelect.addEventListener("change", function () {
            if (daySelect) {
                renderExisting(daySelect.value);
                updateMinMax(daySelect.value);
            }
        });
    }

    if (startInput) {
        startInput.addEventListener("input", function () {
            const startMin = toMinutes(this.value) + 5;
            if (endInput) {
                endInput.min = toHHMM(startMin);
                if (toMinutes(endInput.value) < startMin) {
                    endInput.value = toHHMM(startMin);
                }
            }
        });
    }

    // initial render: akan kosong kalau tingkat/sub kelas belum dipilih
    if (daySelect) {
        renderExisting(daySelect.value);
        updateMinMax(daySelect.value);
    }

    if (form) {
        form.addEventListener("submit", function (e) {
            const day = daySelect.value;
            const start = startInput.value;
            const end = endInput.value;
            const grade = gradeSelect ? gradeSelect.value : "";
            const group = classSelect ? classSelect.value : "";

            if (!grade || !group) {
                e.preventDefault();
                alert("Pilih tingkat dan sub kelas terlebih dahulu.");
                return;
            }

            if (!start || !end) {
                e.preventDefault();
                alert("Isi jam mulai dan selesai.");
                return;
            }

            const startMin = toMinutes(start);
            const endMin = toMinutes(end);

            if (
                startMin < toMinutes(SCHOOL_START) ||
                endMin > toMinutes(SCHOOL_END)
            ) {
                e.preventDefault();
                alert("Jam harus berada dalam rentang 08:00 - 15:40.");
                return;
            }

            const slots = getFilteredSlots(day);
            for (let i = 0; i < slots.length; i++) {
                const s = slots[i];
                const sStart = toMinutes(s.start_time);
                const sEnd = toMinutes(s.end_time);
                if (startMin < sEnd && endMin > sStart) {
                    e.preventDefault();
                    alert(
                        "Waktu bentrok dengan " +
                            s.subject +
                            " (" +
                            s.start_time +
                            " - " +
                            s.end_time +
                            ")"
                    );
                    return;
                }
            }
        });
    }
})();

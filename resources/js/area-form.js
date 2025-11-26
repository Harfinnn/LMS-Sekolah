document.addEventListener("DOMContentLoaded", async () => {
    const provSelect = document.getElementById("provinsi");
    const kabSelect = document.getElementById("kabupaten");
    const kecSelect = document.getElementById("kecamatan");
    const kelSelect = document.getElementById("kelurahan");

    if (!provSelect || !kabSelect || !kecSelect || !kelSelect) return;

    const selected = {
        provinsi: provSelect.dataset.selected || "",
        kabupaten: kabSelect.dataset.selected || "",
        kecamatan: kecSelect.dataset.selected || "",
        kelurahan: kelSelect.dataset.selected || "",
    };

    const cache = {
        regencies: {},
        districts: {},
        villages: {},
    };

    function makeOption(name) {
        const opt = document.createElement("option");
        opt.value = name;
        opt.text = name;
        return opt;
    }

    const provinces = await fetch("/api/provinces").then((res) => res.json());

    provSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
    provinces.forEach((p) => {
        const opt = makeOption(p.name);
        provSelect.add(opt);
    });

    if (selected.provinsi) {
        provSelect.value = selected.provinsi;
        provSelect.dispatchEvent(new Event("change"));
    }

    provSelect.addEventListener("change", async function () {
        kabSelect.innerHTML = '<option value="">Pilih Kabupaten</option>';
        kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kelSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';

        if (!this.value) return;

        const selectedProv = provinces.find((p) => p.name === this.value);
        if (!selectedProv) return;

        if (!cache.regencies[selectedProv.id]) {
            const regencies = await fetch(
                `/api/regencies/${selectedProv.id}`
            ).then((res) => res.json());
            cache.regencies[selectedProv.id] = regencies;
        }

        cache.regencies[selectedProv.id].forEach((k) => {
            const opt = makeOption(k.name);
            kabSelect.add(opt);
        });

        if (selected.kabupaten) {
            kabSelect.value = selected.kabupaten;
            kabSelect.dispatchEvent(new Event("change"));
        }
    });

    kabSelect.addEventListener("change", async function () {
        kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kelSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';

        if (!this.value) return;

        const selectedProv = provinces.find((p) => p.name === provSelect.value);
        if (!selectedProv) return;
        const regencies = cache.regencies[selectedProv.id] || [];
        const selectedKab = regencies.find((k) => k.name === this.value);
        if (!selectedKab) return;

        if (!cache.districts[selectedKab.id]) {
            const districts = await fetch(
                `/api/districts/${selectedKab.id}`
            ).then((res) => res.json());
            cache.districts[selectedKab.id] = districts;
        }

        cache.districts[selectedKab.id].forEach((d) => {
            const opt = makeOption(d.name);
            kecSelect.add(opt);
        });

        if (selected.kecamatan) {
            kecSelect.value = selected.kecamatan;
            kecSelect.dispatchEvent(new Event("change"));
        }
    });

    // Event Kecamatan → Kelurahan
    kecSelect.addEventListener("change", async function () {
        kelSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
        if (!this.value) return;

        const selectedProv = provinces.find((p) => p.name === provSelect.value);
        if (!selectedProv) return;
        const regencies = cache.regencies[selectedProv.id] || [];
        const selectedKab = regencies.find((k) => k.name === kabSelect.value);
        if (!selectedKab) return;
        const districts = cache.districts[selectedKab.id] || [];
        const selectedKec = districts.find((d) => d.name === this.value);
        if (!selectedKec) return;

        if (!cache.villages[selectedKec.id]) {
            const villages = await fetch(
                `/api/villages/${selectedKec.id}`
            ).then((res) => res.json());
            cache.villages[selectedKec.id] = villages;
        }

        cache.villages[selectedKec.id].forEach((v) => {
            const opt = makeOption(v.name);
            kelSelect.add(opt);
        });

        if (selected.kelurahan) {
            kelSelect.value = selected.kelurahan;
        }
    });
});

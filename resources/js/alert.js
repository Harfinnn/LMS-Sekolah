import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', () => {

    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.delete-form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    const successAlert = document.getElementById('alert-success');
    const errorAlert = document.getElementById('alert-error');

    [successAlert, errorAlert].forEach(alert => {
        if (alert) {
            setTimeout(() => {
                alert.classList.add('opacity-0', '-translate-y-10');
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        }
    });

});

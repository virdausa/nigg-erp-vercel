<script>
    function sweetSuccess(success) {
        Swal.fire({
            icon: 'success',
            title: 'BERHASIL',
            text: success,
            showConfirmButton: false,
            timer: 2000
        })
    }

    function sweetInfo(info) {
        Swal.fire({
            icon: 'info',
            title: 'INFORMASI',
            text: info,
            showConfirmButton: false,
            timer: 2000
        })
    }

    function sweetFailed(failed) {
        Swal.fire({
            icon: 'error',
            title: 'GAGAL',
            text: failed,
            showConfirmButton: false,
            timer: 2000
        })
    }

    function sweetWarning(warning) {
        Swal.fire({
            icon: 'warning',
            title: 'PERINGATAN',
            text: warning,
            showConfirmButton: false,
            timer: 2000
        })
    }

    function showLoader(text = '') {
        Swal.fire({
            icon: 'info',
            title: 'Mohon Tunggu',
            html: text ?? 'Sedang memproses data...',
            allowOutsideClick: false,
            showConfirmButton: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });
    }

    function hideLoader() {
        Swal.close();
    }
</script>

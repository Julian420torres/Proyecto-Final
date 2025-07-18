@if (session('success'))
    <script>
        let message = "{{ session('success') }}";
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: message
        })
    </script>
@endif

@if (session('login'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let message = "{{ session('login') }}";
            Swal.fire(message);
        });
    </script>
@endif

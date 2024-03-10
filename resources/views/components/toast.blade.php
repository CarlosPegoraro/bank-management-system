@if ($toasts = session('toast'))
    <div class="toast-container position-absolute p-3 bottom-0 end-0">
        @foreach ($toasts as $toast)
            <div class="toast align-items-center text-white bg-{{ $toast['type'] }} border-0" data-bs-autohide="true"
                role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $toast['message'] }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        $(document).ready(function () {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'))
            const toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl, {
                    animation: true,
                    autohide: true,
                    delay: 3600,
                })
            });
            toastList.map(toast => toast.show())
        })
    </script>

@endif

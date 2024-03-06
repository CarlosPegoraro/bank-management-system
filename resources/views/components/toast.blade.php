<div class="toast-container position-absolute p-3 bottom-0 end-0">
    @if ($toasts = session('toast'))
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
    @endif
</div>

<script>
    $(document).ready(function() {
        const toastElList = [].slice.call(document.querySelectorAll('.toast'));
        const toastList = toastElList.map(function(toastEl) {
            return new Toast(toastEl);
        });
        toastList.map(toast => toast.show());
    });
</script>

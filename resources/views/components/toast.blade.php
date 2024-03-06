<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Notificação</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Buscando notificação...
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {
            function fetchNotification() {
                var notificationUrl = "{{ route('notification.get-json') }}"; // Ajuste para o nome correto da rota

                $.get(notificationUrl, function(data) {
                    if (data && !$.isEmptyObject(data)) {
                        $('#liveToast .toast-body').text(data.data.message); // Ajuste de acordo com a estrutura de sua notificação
                        var toastElement = document.getElementById('liveToast');
                        var toast = new bootstrap.Toast(toastElement);
                        toast.show();
                    }
                }).fail(function() {
                    console.log("Erro ao buscar notificações.");
                });
            }

            // Buscar notificação imediatamente e depois a cada 1 minuto
            fetchNotification();
            setInterval(fetchNotification, 60000);
        });
    </script>

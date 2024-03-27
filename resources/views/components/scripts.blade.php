<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Load Bootstrap JS bundle-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/scripts.js?version=' . config('sentry.release')) }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    @livewireScripts

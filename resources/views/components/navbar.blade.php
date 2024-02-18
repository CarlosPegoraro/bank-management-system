<main class="d-flex justify-content-start align-items-center gap-5 mb-5">
    <a href="javascript:void(0);" onclick="goBack()" class="text-primary fs-3"><i class="bi bi-arrow-left"></i></a>
    <h1 class="text-secondary fs-4">{{ $title }}</h1>
</main>

<script>
    function goBack() {
        window.history.back();
    }
</script>

<div id="<?= $this->alertID ?>" class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi <?= $this->symbol->value ?>">
        <span><?= $this->msg ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <script>
            $(window).ready(() => {
                <?= $this->js ?>
            })
        </script>
</div>
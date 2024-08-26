<?php
$btn_id = 'btn-' . str_replace('.', '', microtime(true));
?>
<button id="<?=$btn_id?>" type="button" class="<?=$this->request['class']?>"><?=$this->request['text']?></button>
<?php if(array_key_exists('click', $this->request) ) : ?>
<script>
    $(document).ready((event) => {
        $('#<?=$btn_id?>').click(<?=$this->request['click']?>);
    });
</script>
<?php endif; ?>
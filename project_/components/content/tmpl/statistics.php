<h1>Statistik</h1>
<div class="statistics">
<?php
$this->getUserStatistics();
foreach($this->userStatistics as $item) {
    $classes = ['id_'.$item['id'], 'item'];
    array_push($classes, match($item['status']) {
        1, 2, 3, 6 => 'danger',
        4, 5    => 'success'
    });
    ?>
    <div class="<?=implode(' ', $classes)?>">
        <span class="msg"><?=MSG['protocol']['status'][$item['status']]?></span>
        <span class="date"><?=$item['date']?>, <?=$item['time']?></span>
        <span class="browser"><?=$item['browser']?></span>
        <span class="url"><?=$item['url']?></span>
        <span class="ip"><?=$item['ip']?></span>
    </div>
    <?php
}
?>
</div>
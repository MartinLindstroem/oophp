<?php
$filterArr = explode(",", $content->filter);
// var_dump($filterArr);
$content->data = $filter->parse($content->data, $filterArr);
?>
<article>
    <header>
        <h1><?= esc($content->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= esc($content->modified_iso8601) ?>" pubdate><?= esc($content->modified) ?></time></i></p>
    </header>
    <?= $content->data ?>
</article>

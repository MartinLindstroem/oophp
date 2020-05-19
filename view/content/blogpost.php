<?php
$arrFilter = explode(",", $content->filter);
$content->data = $filter->parse($content->data, $arrFilter);
?>

<article>
    <header>
        <h1><?= esc($content->title) ?></h1>
        <p><i>Published: <time datetime="<?= esc($content->published_iso8601) ?>" pubdate><?= esc($content->published) ?></time></i></p>
    </header>
    <?= $content->data ?>
</article>

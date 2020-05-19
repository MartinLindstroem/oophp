<?php
if (!$resultset) {
    return;
}

// foreach ($resultset as $row) {
//     $arrFilter = explode(",", $row->filter);
// }
?>

<article>

<?php foreach ($resultset as $row) : ?>
<?php
$arrFilter = explode(",", $row->filter);
$row->data = $filter->parse($row->data, $arrFilter);
?>

<section>
    <header>
        <h1><a href="?route=blog/<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h1>
        <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
    </header>
    <?= $row->data ?>
</section>
<?php endforeach; ?>

</article>

<?php
namespace Marty\TextFilter;

// $filter = new MyTextFilter();

$bbText = "[b]hej[/b]";
$bbres = $filter->bbcode2html($bbText);

$linkText = "https://dbwebb.se/";
$linkClickable = $filter->makeClickable($linkText);

$mdText = "* hej";
$mdConvert = $filter->markdown($mdText);

$textNewline = "hej\n på\n dig";
$nl2br = $filter->nl2br($textNewline);

$filters = ["bbcode", "link", "markdown", "nl2br"];
$text = "[b]BOLD[/b]\n https://dbwebb.se/\n * hej";
$new_text = $filter->parse($text, $filters);
?>

<h2>BBCODE</h2>
<h3>Before Filter</h3>
<p><?=$bbText?></p>
<h3>After Filter</h3>
<p><?=$bbres?></p>

<h2>Links</h2>
<p><?=$linkText?></p>
<p><?=$linkClickable?></p>

<h2>Markdown</h2>
<p><?=$mdText?></p>
<p><?=$mdConvert?></p>

<h2>nl2br</h2>
<p><?=$textNewline?></p>
<p><?=$nl2br?></p>

<h2>Parse with multiple filters</h2>
<p><?=$text?></p>
<p><?=$new_text?></p>

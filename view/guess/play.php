<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());




?><h1>Guess the number</h1>

<p>Guess a number between 1 and 100. You get 6 tries. Tries left: <?= $tries ?></p>

<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value=" <?= $number; ?> ">
    <input type="hidden" name="tries" value =" <?= $tries; ?> ">
    <input type="submit" name="doGuess" value="Make a guess">
    <input type="submit" name="doInit" value="Start over">
    <input type="submit" name="doCheat" value="Cheat">
</form>

<?php if ($res && $tries >= 0) : ?>
    <p>Your guess of <?=$guess?> is <?=$res?></p>
<?php elseif ($res && $tries == 0) : ?>
    <p>You have no more guesses</p>
<?php endif; ?>

<?php if ($cheat) : ?>
    <p>The right number is <?=$number?></p>
<?php endif; ?>

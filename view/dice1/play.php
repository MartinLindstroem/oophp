<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());




?><h1>Dice 100!!1</h1>

<p>Roll the dice. First to 100 points win.</p>
<p>Current player: <b><?= $activePlayer ?></b> </p>

<p>Player total: <?= $playerTotal ?></p>
<p>Computer total: <?= $computerTotal ?></p>

<p>Round score: <?= $playerCurrent ?></p>

<?php if ($activePlayer == "player") : ?>
<form method="post">
    <input type="submit" name="roll" value="Roll dice" style="background-color: #00cc00;">
    <input type="submit" name="hold" value="Hold" style="background-color: #e00">
</form>
<?php elseif ($activePlayer == "computer") : ?>
    <form method="post">
        <input type="submit" name="sim" value="Simulate computer" style="background-color: #39f">
    </form>
<?php endif; ?>

<?php if ($roll) : ?>
    <p>Player rolled a <?= $value ?></p>
<?php endif; ?>

<?php if ($sim) : ?>
    <p>Computer rolled <?= implode(", ", $_SESSION["DiceGame"]->computerRolls) ?></p>
<?php endif; ?>

<?php if ($playerTotal >= 100) : ?>
    <h2><b>PLAYER WON!!</b></h2>
    <form method="post">
        <input type="submit" name="restart" value="Play again">
    </form>
<?php elseif ($computerTotal >= 100) : ?>
    <h2><b>COMPUTER WON!!</b></h2>
    <form method="post">
        <input type="submit" name="restart" value="Play again">
    </form>
<?php endif; ?>

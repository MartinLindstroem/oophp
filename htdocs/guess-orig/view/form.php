<h1>Guess the number</h1>

<p>Guess a number between 1 and 100. You get 6 tries. Tries left: <?= $guessObj->tries(); ?></p>

<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value=" <?= $guessObj->number(); ?> ">
    <input type="hidden" name="tries" value =" <?= $guessObj->tries(); ?> ">
    <input type="submit" name="doGuess" value="Make a guess">
    <input type="submit" name="doInit" value="Start over">
    <input type="submit" name="doCheat" value="Cheat">
</form>

<?php
include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");

session_name("guessGame");
session_start();

if (!isset($_SESSION["guess"])) {
    $_SESSION["guess"] = new Guess();
}
$guessObj = $_SESSION["guess"];

$number = $_POST["number"] ?? null;
$tries = $_POST["tries"] ?? null;
$guess = $_POST["guess"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doInit = $_POST["doInit"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;



if ($number === null) {
    $guessObj->random();
} elseif ($doInit) {
    header("Location: destroy_session.php");
}

if ($doGuess && $tries > 0) {
     echo "<h2>Your guess of " . $guess . " is " . $guessObj->makeGuess($guess) . "</h2>";
} elseif ($doGuess && $tries == 0) {
    echo "<h2>You have no more guesses</h2>";
} elseif ($doCheat) {
    echo "<h2>The right number is " . $number . "</h2>";
}

include(__DIR__ . "/view/form.php");

<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Redovisning",
            "url" => "redovisning",
            "title" => "Redovisningstexter från kursmomenten.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Kmom01",
                        "url" => "redovisning/kmom01",
                        "title" => "Redovisning för kmom01.",
                    ],
                    [
                        "text" => "Kmom02",
                        "url" => "redovisning/kmom02",
                        "title" => "Redovisning för kmom02.",
                    ],
                ],
            ],
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Styleväljare",
            "url" => "style",
            "title" => "Välj stylesheet.",
        ],
        [
            "text" => "Docs",
            "url" => "dokumentation",
            "title" => "Dokumentation av ramverk och liknande.",
        ],
        [
            "text" => "Test &amp; Lek",
            "url" => "lek",
            "title" => "Testa och lek med test- och exempelprogram",
        ],
        [
            "text" => "Anax dev",
            "url" => "dev",
            "title" => "Anax development utilities",
        ],
        [
            "text" => "Gissa numret",
            "url" => "guess-game",
            "title" => "Spela gissa mitt nummer",
        ],
        [
            "text" => "Tärning 100",
            "url" => "dice-game",
            "title" => "Spela tärning 100",
        ],
        [
            "text" => "Tärning 100(v2)",
            "url" => "dice1/init",
            "title" => "Spela tärning 100",
        ],
        [
            "text" => "Movie database",
            "url" => "movie",
            "title" => "Movie database",
        ],
        [
            "text" => "Textfilter",
            "url" => "textfilter",
            "title" => "TextFilter",
        ],
        [
            "text" => "Blogg",
            "url" => "content",
            "title" => "Content",
        ],
    ],
];

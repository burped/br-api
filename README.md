# br-api
PHP Wrapper around the official Battlerite API

Currently, as there is no way to find players by name, the best alternative is to find them on battlerite-stats.com. The player ID is then located in the address bar.

There is much tweaking to do, and easier ways to present the data. 

Information that can currently be received:

### Player

* Name
* Title (converts title ID to actual title)
* Account level
* Win, loss and winrate values for 2v2, 3v3 (league and casual) and brawl
* Champion wins, loss and winrate values

### Match

* Match type
* Player ID's, names and champions played
* Damage done and received
* Healing done and received
* Ability use count (just general, no specific abilities)
* Deaths and Kills
* Energy gained and used
* Disables done and received
* Overall score
* Time Alive

The below is an ugly example of pulling player information from the Battlerite API, and getting all information about the player:

```
<?php
include_once ('api.php');

$api = new \Battlerite\api();
$player = $api->player('785479549898084352'); // my ID

echo "Name: " . $player->name . " [" . $player->id . "] - " . $player->title;
echo "<br/>Account Level: " . $player->acc_level;
echo "<br/><br/>Total Wins:";
echo "<br/>" . $player->wins() . " - " . $player->losses() . " [" . $player->winrate() . "%]";
echo "<br/><br/>Casual:";
echo "<br/>2v2: " . $player->wins('2v2', false) . " - " . $player->losses('2v2', false) . " [" . $player->winrate('2v2', false) . "%]";
echo "<br/>3v3: " . $player->wins('3v3', false) . " - " . $player->losses('3v3', false) . " [" . $player->winrate('3v3', false) . "%]";
echo "<br/><br/>League:";
echo "<br/>2v2: " . $player->wins('2v2', true) . " - " . $player->losses('2v2', true) . " [" . $player->winrate('2v2', true) . "%]";
echo "<br/>3v3: " . $player->wins('3v3', true) . " - " . $player->losses('3v3', true) . " [" . $player->winrate('3v3', true) . "%]";

echo "<br/><br/>Brawl: " . $player->wins('brawl') . " - " . $player->losses('brawl') . " [" . $player->winrate('brawl') . "%]";

$champions = [
    'jade',
    'freya',
    'shifu',
    'poloma',
    'rook',
    'taya',
    'bakko',
    'sirius',
    'lucie',
    'iva',
    'oldur',
    'pearl',
    'croak',
    'ashka',
    'varesh',
    'raigon',
    'blossom',
    'pestilus',
    'ruh kaan',
    'ezmo',
    'thorn',
    'destiny',
    'alysia'
];
try {
    echo "<br/>";
    foreach ($champions as $champion) {
        echo "<br/>" . ucfirst($champion) . ": ";
        echo $player->champion($champion)["wins"] . " - " . $player->champion($champion)["losses"] . " [" . $player->champion($champion)["winrate"] . "%]<br/>";
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>
```
# Further information

Raw data is below for anyone looking to make their own wrapper. Most of this information was gained from looking up players with relevant titles and finding their codes. Note that is not yet complete.

## Title ID's
```
500 - Alpha Tester
502 - Beta Tester
503 - Founder
504 - Contender
31001 - The Expelled Alchemist
31004 - The Lone Ranger
31006 - The Time Mender
31007 - The Molten Fury
31008 - The Eternal
31011 - The Psychopomp
31014 - The Beast Hunter
31015 - The Spear
31025 - The Twisted Terror
60015 - #1 S2 Grand Champion Solo
```
## Champion ID's
```
All the champion wins start with 12xxx, and their losses start with 13xxx. The missing ID is the same for both, so for Lucie, her wins are 12001, and her losses are 13001.

1 - Lucie
2 - Sirius
3 - Iva
4 - Jade
5 - Ruh Kaan
6 - Oldur
7 - Ashka
8 - Varesh
9 - Pearl
11 - Poloma
12 - Croak
13 - Freya
14 - Jumong
15 - Shifu
16 - Ezmo
17 - Bakko
18 - Rook
19 - Pestilus
20 - Destiny
21 - Raigon
22 - Blossom
25 - Thorn
41 - Alysia

```

## Authors
* **James Horton** - [More](https://github.com/burped)

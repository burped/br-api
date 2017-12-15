<?php
// My player ID: 785479549898084352
// Lee: 794289017641373696
include_once ('api.php');

$api = new \Battlerite\api();

$options = [
    'sort' => 'createdAt',
    'page[limit]' => 1
];

// Load player
//$player = $api->player('785479549898084352'); // Burped
$list = array(
    '776450744541908992'
);
/*
foreach($list as $player)
{
    $player = $api->player($player);
    echo "Name:" . $player->name . " [" . $player->id . "] - " . $player->title;
    echo "<br/>Account Level: " . $player->acc_level;
    echo "<br/><br/>Total Wins:";
    echo "<br/>" . $player->wins() . " - " . $player->losses() . " [" . $player->winrate() . "%]";
    echo "<br/><br/>Casual:";
    echo "<br/>2v2: " . $player->wins('2v2',false) . " - " . $player->losses('2v2',false) . " [" . $player->winrate('2v2',false) . "%]";
    echo "<br/>3v3: " . $player->wins('3v3',false) . " - " . $player->losses('3v3',false) . " [" . $player->winrate('3v3',false) . "%]";
    echo "<br/><br/>League:";
    echo "<br/>2v2: " . $player->wins('2v2',true) . " - " . $player->losses('2v2',true) . " [" . $player->winrate('2v2',true) . "%]";
    echo "<br/>3v3: " . $player->wins('3v3',true) . " - " . $player->losses('3v3',true) . " [" . $player->winrate('3v3',true) . "%]";

    echo "<br/><br/>Brawl: " . $player->wins('brawl') . " - " . $player->losses('brawl') . " [" . $player->winrate('brawl') . "%]";

    $champions = [
        'jade' => '4',
        'freya' => '13',
        'shifu' => '15',
        'poloma' => '11',
        'rook' => '18',
        'taya' => '10',
        'bakko' => '17',
        'sirius' => '14',
        'lucie' => '1',
        'iva' => '3',
        'oldur' => '6',
        'pearl' => '9',
        'croak' => '12',
        'ashka' => '7',
        'varesh' => '8',
        'raigon' => '21',
        'blossom' => '22',
        'pestilus' => '19',
        'ruh kaan' => '5',
        'ezmo' => '16',
        'thorn' => '25',
        'destiny' => '20',
        'alysia' => 41
    ];
    try {
        echo "<br/>";
        foreach ($champions as $champion => $id) {
            echo "<br/>" . ucfirst($champion) . ": ";
            echo $player->champion($champion)["wins"] . " - " . $player->champion($champion)["losses"] . " [" . $player->champion($champion)["winrate"] . "%]<br/>";
        }
    }
    catch ( \Exception $e )
    {
        echo $e->getMessage();
    }
}
*/

$api->match('AB9C81FABFD748C8A7EC545AA6AF97CC');

?>
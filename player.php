<?php

namespace Battlerite;

Class Player extends api
{
    public $id = null;
    public $acc_level = null;
    public $name = null;
    public $picture = null;
    public $title_id = null;
    public $title = null;
    public $play_stats = [];
    public $champion_stats = [];

    function __construct($id = false)
    {
        $result = api::get('players', $id);
        //$result = json_encode($result);
        $result = json_decode($result, true);

        $this->id = $result["data"]["id"];
        $this->acc_level = $result["data"]["attributes"]["stats"]["26"];
        $this->picture = $result["data"]["attributes"]["stats"]["picture"];
        $this->get_title($this->title = $result["data"]["attributes"]["stats"]["title"]);
        //$this->title = $result["data"]["attributes"]["stats"]["title"];
        $this->name = $result["data"]["attributes"]["name"];
        $this->play_stats["wins"]["casual"]["total"] = $result["data"]["attributes"]["stats"]["2"];
        $this->play_stats["losses"]["casual"]["total"] = $result["data"]["attributes"]["stats"]["3"];

        // 2v2:
        // 10 and 11 = casual win/loss
        // 14 and 15 = league win/loss
        // 3v3:
        // 12 and 13 = casual win/loss
        // 16 and 17 = league win/loss
        // CASUAL 2v2
        $this->play_stats["wins"]["casual"]["2v2"] = $result["data"]["attributes"]["stats"]["10"];
        $this->play_stats["losses"]["casual"]["2v2"] = $result["data"]["attributes"]["stats"]["11"];
        // LEAGUE 2v2
        $this->play_stats["wins"]["league"]["2v2"] = $result["data"]["attributes"]["stats"]["14"];
        $this->play_stats["losses"]["league"]["2v2"] = $result["data"]["attributes"]["stats"]["15"];

        // CASUAL 3v3
        $this->play_stats["wins"]["casual"]["3v3"] = $result["data"]["attributes"]["stats"]["12"];
        $this->play_stats["losses"]["casual"]["3v3"] = $result["data"]["attributes"]["stats"]["13"];
        // LEAGUE 3v3
        $this->play_stats["wins"]["league"]["3v3"] = $result["data"]["attributes"]["stats"]["16"];
        $this->play_stats["losses"]["league"]["3v3"] = $result["data"]["attributes"]["stats"]["17"];

        // Brawl is 18 and 19
        if (isset($result["data"]["attributes"]["stats"]["18"])) {
            $this->play_stats["wins"]["casual"]["brawl"] = $result["data"]["attributes"]["stats"]["18"];
        } else {
            $this->play_stats["wins"]["casual"]["brawl"] = 0;
        }
        if (isset($result["data"]["attributes"]["stats"]["19"])) {
            $this->play_stats["losses"]["casual"]["brawl"] = $result["data"]["attributes"]["stats"]["19"];
        } else {
            $this->play_stats["losses"]["casual"]["brawl"] = 0;
        }

        // CHAMPION STATS
        // Jade

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

        foreach ($champions as $name => $id) {
            if (isset($result["data"]["attributes"]["stats"][($id + 12000)])) {
                $this->champion_stats[$name]["wins"] = $result["data"]["attributes"]["stats"][($id + 12000)];
            } else {
                $this->champion_stats[$name]["wins"] = 0;
            }

            if (isset ($result["data"]["attributes"]["stats"][($id + 13000)])) {
                $this->champion_stats[$name]["losses"] = $result["data"]["attributes"]["stats"][($id + 13000)];
            } else {
                $this->champion_stats[$name]["losses"] = 0;
            }
        }
        /*
                $id = 12004;
                $this->champion_stats["jade"]["wins"] = $result["data"]["attributes"]["stats"][$id];
                $this->champion_stats["jade"]["losses"] = $result["data"]["attributes"]["stats"][$id+1000];
                // Freya
                $id = 12013;
                $this->champion_stats["freya"]["wins"] = $result["data"]["attributes"]["stats"][$id];
                $this->champion_stats["freya"]["losses"] = $result["data"]["attributes"]["stats"][$id+1000];
                // Shifu
                $id = 12015;
                $this->champion_stats["shifu"]["wins"] = $result["data"]["attributes"]["stats"][$id];
                $this->champion_stats["shifu"]["losses"] = $result["data"]["attributes"]["stats"][$id+1000];
        */
        //echo json_encode(print_r($result));
        return $result;
    }

    function champion($id)
    {
        if (isset($this->champion_stats[$id])) {
            if (($this->champion_stats[$id]["wins"] + $this->champion_stats[$id]["losses"]) != 0) {
                $this->champion_stats[$id]["winrate"] = number_format($this->champion_stats[$id]["wins"] / ($this->champion_stats[$id]["wins"] + $this->champion_stats[$id]["losses"]) * 100, 2);
            } else {
                $this->champion_stats[$id]["winrate"] = 0;
            }
            return $this->champion_stats[$id];
        }
        throw new \Exception('ERROR: Invalid champion or values set incorrectly.');
    }

    function wins($mode = 'total', $league = false)
    {
        if ($league) {
            $type = "league";
        } else {
            $type = "casual";
        }
        if (isset ($this->play_stats['wins'][$type][$mode])) {
            return $this->play_stats['wins'][$type][$mode];
        } else {
            return 0;
        }
    }

    function losses($mode = 'total', $league = false)
    {
        if ($league) {
            $type = "league";
        } else {
            $type = "casual";
        }
        if (isset ($this->play_stats['losses'][$type][$mode])) {
            return $this->play_stats['losses'][$type][$mode];
        } else {
            return 0;
        }
    }

    function winrate($mode = 'total', $league = false)
    {
        if ($league) {
            $type = "league";
        } else {
            $type = "casual";
        }
        if (($this->play_stats['wins'][$type][$mode] + $this->play_stats['losses'][$type][$mode]) == 0) {
            return 0;
        } else {
            return number_format($this->play_stats['wins'][$type][$mode] / ($this->play_stats['wins'][$type][$mode] + $this->play_stats['losses'][$type][$mode]) * 100, 2);
        }
    }

    function getjson($id = false)
    {
        if (!$id) {
            $id = $this->id;
        }
        return api::get('players', $id);

    }

    function get_title($title_id)
    {
        $this->title_id = $title_id;
        switch ($title_id) {
            case '500':
                $this->title = "Alpha Tester";
                break;
            case '502':
                $this->title = "Beta Tester";
                break;
            case '503':
                $this->title = "Founder";
                break;
            case '504':
                $this->title = "Contender";
                break;
            case '31001':
                $this->title = "The Expelled Alchemist";
                break;
            case '31004':
                $this->title = "The Lone Ranger";
                break;
            case '31006':
                $this->title = "The Time Mender";
                break;
            case '31007':
                $this->title = "The Molten Fury";
                break;
            case '31008':
                $this->title = "The Eternal";
                break;
            case '31011':
                $this->title = "The Psychopomp";
                break;
            case '31014':
                $this->title = "The Beast Hunter";
                break;
            case '31015':
                $this->title = "The Spear";
                break;
            case '31025':
                $this->title = "The Twisted Terror";
                break;
            case '60015':
                $this->title = "#1 S2 Grand Champion Solo";
                break;
            default:
                $this->title = "Unknown (" . $title_id . ")";
                break;
        }
    }
}

?>
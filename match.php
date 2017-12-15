<?php

namespace Battlerite;

Class Match extends api
{
    public $id = null;
    public $duration = null;
    public $map = null;
    public $type = null;
    public $rosters = [];
    public $players = [];

    function __construct($id = false)
    {
        if ($id) {

            $result = api::get('dev');
            $result = json_decode($result, true);

            $this->id = $result["data"]["id"];
            $this->duration = $result["data"]["attributes"]["duration"];

            $this->type = $result["data"]["attributes"]["stats"]["type"];

            //  $this->players[] = $result["included"]["attributes"]["stats"]["userID"];
            foreach ($result["included"] as $player) {
                if ($player["type"] == "participant") {
                    if ($player["attributes"]["stats"]["side"] == 1) {
                        $t = api::player($player["attributes"]["stats"]["userID"]);

                        $this->players[0][] = [
                            "id" => $player["attributes"]["stats"]["userID"],
                            "name" => $t->name,
                            "champion" => $player["attributes"]["actor"],
                            "abilityUses" => $player["attributes"]["stats"]["abilityUses"],
                            "damageDone" => $player["attributes"]["stats"]["damageDone"],
                            "damageReceived" => $player["attributes"]["stats"]["damageReceived"],
                            "deaths" => $player["attributes"]["stats"]["deaths"],
                            "disablesDone" => $player["attributes"]["stats"]["disablesDone"],
                            "energyGained" => $player["attributes"]["stats"]["energyGained"],
                            "energyUsed" => $player["attributes"]["stats"]["energyUsed"],
                            "healingDone" => $player["attributes"]["stats"]["healingDone"],
                            "healingReceived" => $player["attributes"]["stats"]["healingReceived"],
                            "kills" => $player["attributes"]["stats"]["kills"],
                            "score" => $player["attributes"]["stats"]["score"],
                            "timeAlive" => $player["attributes"]["stats"]["timeAlive"]
                        ];

                    } else {
                        $t = api::player($player["attributes"]["stats"]["userID"]);

                        $this->players[1][] = [
                            "id" => $player["attributes"]["stats"]["userID"],
                            "name" => $t->name,
                            "champion" => $player["attributes"]["actor"],
                            "abilityUses" => $player["attributes"]["stats"]["abilityUses"],
                            "damageDone" => $player["attributes"]["stats"]["damageDone"],
                            "damageReceived" => $player["attributes"]["stats"]["damageReceived"],
                            "deaths" => $player["attributes"]["stats"]["deaths"],
                            "disablesDone" => $player["attributes"]["stats"]["disablesDone"],
                            "energyGained" => $player["attributes"]["stats"]["energyGained"],
                            "energyUsed" => $player["attributes"]["stats"]["energyUsed"],
                            "healingDone" => $player["attributes"]["stats"]["healingDone"],
                            "healingReceived" => $player["attributes"]["stats"]["healingReceived"],
                            "kills" => $player["attributes"]["stats"]["kills"],
                            "score" => $player["attributes"]["stats"]["score"],
                            "timeAlive" => $player["attributes"]["stats"]["timeAlive"]
                        ];
                    }
                }
            }

            //echo "<pre>" . print_r($this->players, true) . "</pre>";

            echo "Match ID: " . $this->id;
            echo "<br/>Duration: " . ($this->duration / 60) . " min";
            echo "<br/>Type: " . $this->type;
            echo "<br/>Team 1: " . $this->players[0][0]["name"] . " (". $this->get_champion($this->players[0][0]["champion"]) . ") and " . $this->players[0][1]["name"] . " (". $this->get_champion($this->players[0][1]["champion"]) . ")";
            echo "<br/>Team 2: " . $this->players[1][0]["name"] . " (". $this->get_champion($this->players[1][0]["champion"]) . ") and " . $this->players[1][1]["name"] . " (". $this->get_champion($this->players[1][1]["champion"]) . ")";


            echo "<br/><br/>";
            $totaldmg = [
                $this->players[0][0]["damageDone"] + $this->players[0][1]["damageDone"],
                $this->players[1][0]["damageDone"] + $this->players[1][1]["damageDone"]
            ];

            echo "Team 1: <br/>";
            echo $this->players[0][0]["name"] . " : " . (number_format(((int)$this->players[0][0]["damageDone"]/(int)$totaldmg[0])*100,2)) . "%<br/>";
            echo $this->players[0][1]["name"] . " : " . (number_format(((int)$this->players[0][1]["damageDone"]/(int)$totaldmg[0])*100,2)) . "%<br/>";
            echo "Team 2: <br/>";
            echo $this->players[1][0]["name"] . " : " . (number_format(((int)$this->players[1][0]["damageDone"]/(int)$totaldmg[1])*100,2)) . "%<br/>";
            echo $this->players[1][1]["name"] . " : " . (number_format(((int)$this->players[1][1]["damageDone"]/(int)$totaldmg[1])*100,2)) . "%<br/>";
        }
/*
        $result = api::get('matches');
        $result = json_decode($result, true);

        $this->id = $result["data"][0]["id"];

        // duration
        $this->duration = $result["data"][0]["attributes"]["duration"];
        // Stats
        $this->map = $result["data"][0]["attributes"]["stats"]["mapID"];
        $this->type = $result["data"][0]["attributes"]["stats"]["type"];
        // Rosters

        $this->rosters[] = $result["data"][0]["relationships"]["rosters"]["data"][0]["id"];
        $this->rosters[] = $result["data"][0]["relationships"]["rosters"]["data"][1]["id"];

        return $result;
    */
    }
    public function get_champion($id)
    {
        $champion = [
          '39373466' => "Jumong",
            '1422481252' => "Bakko",
            '1649551456' => "Pestilus",
            '870711570' => "Destiny"
        ];

        return $champion[$id];

        }


}

?>

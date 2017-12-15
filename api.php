<?php

namespace Battlerite;

require_once('player.php');
require_once('match.php');

Class api
{
    protected $api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIxN2ZiMmVlMC1jMzA1LTAxMzUtOTcxMi0wYTU4NjQ2MGFhMzMiLCJpc3MiOiJnYW1lbG9ja2VyIiwiaWF0IjoxNTEzMjYwMDQxLCJwdWIiOiJzdHVubG9jay1zdHVkaW9zIiwidGl0bGUiOiJiYXR0bGVyaXRlIiwiYXBwIjoiYXJkbG9jaCIsInNjb3BlIjoiY29tbXVuaXR5IiwibGltaXQiOjEwfQ.pdW9JVWNw5e5wcVMTs7z2b-AlretLRBTJmPNa7aA1xQ';
    protected $base_uri = 'https://api.dc01.gamelockerapp.com/shards/global/';

    public $request_info = [];
    public $player = null;
    public $match = null;

    public function player($id = false)
    {
        if (!$id) {
            return $this->player;
        } else {
            $this->player = new \Battlerite\Player($id);
            return $this->player;
        }
    }

    public function matches()
    {
            $this->match = new \Battlerite\Match();
    }

    public function match($id = false)
    {
        if (!$id) {
            return $this->match;
        } else {
            $this->match = new \Battlerite\Match($id);
            return $this->match;
        }
    }

    public function get($option, $id = '')
    {
        if ($option == 'dev')
        {
            $string = file_get_contents("singlematch.json");
            return $string;
        }
        else {
            $h = curl_init();
            if ($id == '') {
                curl_setopt($h, CURLOPT_URL, $this->base_uri . $option);
            } else {
                curl_setopt($h, CURLOPT_URL, $this->base_uri . $option . '/' . $id);
            }
            curl_setopt($h, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($h, CURLOPT_HTTPHEADER, array(
                'Accept: application/vnd.api+json',
                'Authorization: ' . $this->api_key,
                'Accept-Encoding: gzip'
            ));
            $result = curl_exec($h);
            curl_close($h);

            return gzdecode($result);
        }
    }
}

?>
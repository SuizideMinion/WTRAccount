<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JSONController extends Controller
{
    public function json()
    {
        function wh_log($log_msg, $name)
        {
            $log_filename = $_SERVER['DOCUMENT_ROOT'] . "/jsonfiles/json_o";
            if (!file_exists($log_filename)) {
                // create directory/folder uploads.
                mkdir($log_filename, 0777, true);
            }
            $log_file_data = $log_filename . '/' . $name;
            file_put_contents($log_file_data, $log_msg . "\n"); //, FILE_APPEND
        }
        $path = public_path('jsonfiles/json_i');

        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ('.' === $file) continue;
                if ('..' === $file) continue;
                if ( !is_dir($path . '/' . $file))
                {
                    $json = json_decode(file_get_contents($path . '/' . $file), true);
//
////                $json_new = $json;
//                $json_new['type'] = 'minecraft:crafting_shaped';
//                $json_new['pattern'] = ["###","###","###"];
//                $json_new['key']['#']['item'] = $json['ingredient']['item'];
//                $json_new['result']['id'] = 'minecraft:player_head';
//                $json_new['result']['count'] = '1';
//                $json_new['result']['components']['minecraft:profile']['properties'][0]['name'] = 'textures';
//                $json_new['result']['components']['minecraft:profile']['properties'][0]['value'] = $json['result']['components']['minecraft:profile']['properties'][0]['value'];
                    $name = explode('"', $json['result']['components']['minecraft:item_name']);
                    $name = explode(' ', $name[1]);
//                $json_new['result']['components']['minecraft:item_name'] = '\"Compressed '. ( $name[1] ?? "" ) . ' ' . ( $name[2] ?? "" ) . ' ' . ( $name[3] ?? "" ) . ' ' . ( $name[4] ?? "" ) . ' ' . ( $name[5] ?? "" ) . '\"';
//
////                dd($json_new);
//                $json_new['result']['components']['minecraft:rarity'] = $json['result']['components']['minecraft:rarity'];
//
//                file_put_contents($path . '/' . $file, json_encode($json_new));
////                dd($json_new);
                    echo ($name[1] ?? "") . ' ' . ($name[2] ?? "") . ' ' . ($name[3] ?? "") . ' ' . ($name[4] ?? "") . ' ' . ($name[5] ?? "") . '<br >';
                }
            }
            closedir($handle);
        }

    }
}

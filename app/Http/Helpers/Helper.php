<?php

use Illuminate\Support\Facades\Http;

function getTimeForStatistik($user_id, $from, $to)
{
    $time = \Modules\TimeManagment\Entities\TimeTracking::where('user_id', $user_id)->where('stamped', '<', $to)->where('stamped', '>', $from)->sum('time_worked');

    $time = date("H:i",$time + strtotime("1970/1/1"));
    $time = str_replace(':', '.', $time);
    if( $time[0] == 0 )
        $time = substr($time, 1);

    return $time;

}

function getZeit($time, $secAnzeigen = false)
{
    $getHours = floor($time / 3600);
    $getMins = floor(($time - ($getHours*3600)) / 60);
    if( $getMins == 0 ) $getMins = '00';
    if( $getMins == 1 ) $getMins = '01';
    if( $getMins == 2 ) $getMins = '02';
    if( $getMins == 3 ) $getMins = '03';
    if( $getMins == 4 ) $getMins = '04';
    if( $getMins == 5 ) $getMins = '05';
    if( $getMins == 6 ) $getMins = '06';
    if( $getMins == 7 ) $getMins = '07';
    if( $getMins == 8 ) $getMins = '08';
    if( $getMins == 9 ) $getMins = '09';
    $getSecs = floor($time % 60);
    if( $getSecs == 0 ) $getSecs = '00';
    if( $getSecs == 1 ) $getSecs = '01';
    if( $getSecs == 2 ) $getSecs = '02';
    if( $getSecs == 3 ) $getSecs = '03';
    if( $getSecs == 4 ) $getSecs = '04';
    if( $getSecs == 5 ) $getSecs = '05';
    if( $getSecs == 6 ) $getSecs = '06';
    if( $getSecs == 7 ) $getSecs = '07';
    if( $getSecs == 8 ) $getSecs = '08';
    if( $getSecs == 9 ) $getSecs = '09';
    return $getHours.':'.$getMins . ($secAnzeigen == true ? ':'.$getSecs:'' );
}

function getShortName($name,){
    $names = explode(' ', $name);
    $last_name = array_pop($names);
    $last_initial = $last_name[0];
    return implode(' ', $names).' '.$last_initial.'.';
}

function getStatus($var) {
    if ( $var == 1 ) return 'Eingereicht';
    if ( $var == 2 ) return 'Angenommen';
    if ( $var == 3 ) return 'in Arbeit';
    if ( $var == 4 ) return 'Angebot Erstellt';
    if ( $var == 5 ) return 'Angebot Angenommen';
    if ( $var == 6 ) return 'Angebot Ändern';
    if ( $var == 7 ) return 'Rechnung erstellen';
    if ( $var == 8 ) return 'in Klärung';
    if ( $var == 9 ) return 'Irgendwas anderes';
    if ( $var == 100 ) return 'Abgeschlossen';
}

function getIsImage($image) {
    $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

    $explodeImage = explode('.', $image);
    $extension = end($explodeImage);
//dd($explodeImage, $extension);
    if(in_array($extension, $imageExtensions))
    {
        return true;
    }else
    {
        return false;
    }
}


function getUserData($key, $id)
{
    return (\App\Models\UserDatas::where('user_id', $id)->where('key', $key)->first()->value ?? null);
}

function saveUserData($key, $value, $id)
{
    \App\Models\UserDatas::updateOrCreate(
        [
            'user_id' => $id,
            'key' => $key
        ],
        [
            'value' => $value
        ]
    );
    return null;
}

function saveLog($text, $userid)
{
    \App\Models\Logs::create([
        'user_id' => $userid,
        'text' => $text,
        'time' => time()
    ]);
    return null;
}

function sendDiscordMessage($Hook, $Message)
{
    $Array = [
        'news' => 'https://discord.com/api/webhooks/1037465095057440808/H-CuHHceUA6ODa0VOZLc47ov0qAGNnyLkmCcKcwEBvpnZp9ffJQlJrj_aLGQ2H-5CyLA',
        'test' => 'https://discord.com/api/webhooks/904345996341968896/9cHCcoyV98qVnQf4gYM73KlLkh7iC-nNFD3JqWar1S89tDedPh_CPZNrLKqNW-BbHYKe'
    ];
    return Http::post($Array[$Hook], [
        'content' => $Message
    ]);
}

function sendPostHttp($Url, $Array) // {{ sendPostHttp('bde.bgam.es/request.php', ['name' => 'daniel']) }}
{
    $responsea = Http::asForm()->post($Url, $Array)->body();

    $response = Http::get($Url, $Array)->body();

    dd($responsea, $response);
}
function sendGetHttp($Url, $Array)
{
    $response['body'] = Http::get($Url, $Array)->body();
    $response['fail'] = Http::get($Url, $Array)->failed();
    $response['succ'] = Http::get($Url, $Array)->successful();

    return $response;
}

function getAvatar($userid) {
    if ( $userid != null And $userid != 0 ) {
        return (getUserData('userProvilAvatar', $userid) ?? 'noavatar.jpg');
    }
    else
        return 'noavatar.jpg';
}

function setNewDatabase($database, $username, $host, $password)
{
    config(['database.connections.custom.host' => $host]);
    config(['database.connections.custom.database' => $database]);
    config(['database.connections.custom.username' => $username]);
    config(['database.connections.custom.password' => $password]);

    return null;
}

function showBBcodes($text) {

    // BBcode array
    $find = array(
        '~\[b\](.*?)\[/b\]~s',
        '~\[i\](.*?)\[/i\]~s',
        '~\[u\](.*?)\[/u\]~s',
        '~\[quote\](.*?)\[/quote\]~s',
        '~\[size=(.*?)\](.*?)\[/size\]~s',
        '~\[color=(.*?)\](.*?)\[/color\]~s',
        '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
        '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
        '~\[B\](.*?)\[/B\]~s',
        '~\[I\](.*?)\[/I\]~s',
        '~\[U\](.*?)\[/U\]~s',
        '~\[QUOTE\](.*?)\[/QUOTE\]~s',
        '~\[SIZE=(.*?)\](.*?)\[/SIZE\]~s',
        '~\[COLOR=(.*?)\](.*?)\[/COLOR\]~s',
        '~\[URL\]((?:ftp|https?)://.*?)\[/URL\]~s',
        '~\[IMG\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/IMG\]~s'
    );

    // HTML tags to replace BBcode
    $replace = array(
        '<b>$1</b>',
        '<i>$1</i>',
        '<span style="text-decoration:underline;">$1</span>',
        '<pre>$1</'.'pre>',
        '<span style="font-size:$1px;">$2</span>',
        '<span style="color:$1;">$2</span>',
        '<a href="$1">$1</a>',
        '<img src="$1" alt="" />',
        '<b>$1</b>',
        '<i>$1</i>',
        '<span style="text-decoration:underline;">$1</span>',
        '<pre>$1</'.'pre>',
        '<span style="font-size:$1px;">$2</span>',
        '<span style="color:$1;">$2</span>',
        '<a href="$1">$1</a>',
        '<img src="$1" alt="" />'
    );

    $text = trim($text);
    $text = strip_tags($text);
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $text = preg_replace($find,$replace,$text);
    $text = smileys($text);
    $text = nl2br($text);

    // Replacing the BBcodes with corresponding HTML tags
    return $text;
}

function smileys($text) {

    // BBcode array
    $find = array(
        '/:1bluewinky:/i',
        '/:alien2:/i',
        '/:alien3:/i',
        '/:alien4:/i',
        '/:alien5:/i',
        '/:amidala:/i',
        '/:angryfire:/i',
        '/:angst:/i',
        '/:applaus:/i',
        '/:ausheck:/i',
        '/:baby:/i',
        '/:biggrin:/i',
        '/:birthday:/i',
        '/:bluepleased:/i',
        '/:borg:/i',
        '/:bounce1:/i',
        '/:bounce2:/i',
        '/:bounce3:/i',
        '/:bounce4:/i',
        '/:bounce5:/i',
        '/:burn1:/i',
        '/:bye:/i',
        '/:chinese:/i',
        '/:confused:/i',
        '/:cool:/i',
        '/:coolgr:/i',
        '/:coolred:/i',
        '/:cry:/i',
        '/:crying:/i',
        '/:cussing:/i',
        '/:cylon:/i',
        '/:d1:/i',
        '/:d2:/i',
        '/:d3:/i',
        '/:d4:/i',
        '/:d5:/i',
        '/:d6:/i',
        '/:d7:/i',
        '/:d8:/i',
        '/:d9:/i',
        '/:d10:/i',
        '/:d11:/i',
        '/:d12:/i',
        '/:d13:/i',
        '/:d14:/i',
        '/:d15:/i',
        '/:d16:/i',
        '/:d17:/i',
        '/:d18:/i',
        '/:d19:/i',
        '/:d20:/i',
        '/:d21:/i',
        '/:d22:/i',
        '/:dark:/i',
        '/:dark_anim:/i',
        '/:dead:/i',
        '/:eek:/i',
        '/:elk:/i',
        '/:engel:/i',
        '/:engel2:/i',
        '/:evil:/i',
        '/:fett:/i',
        '/:firedevil:/i',
        '/:flame1:/i',
        '/:flame2:/i',
        '/:fresse:/i',
        '/:frown:/i',
        '/:gaehn:/i',
        '/:gap:/i',
        '/:geld:/i',
        '/:happy:/i',
        '/:hat1:/i',
        '/:hat2:/i',
        '/:hat3:/i',
        '/:icon2:/i',
        '/:icon6:/i',
        '/:icon13:/i',
        '/:idee:/i',
        '/:innocent:/i',
        '/:jawa:/i',
        '/:jb:/i',
        '/:kiss1:/i',
        '/:knuddel:/i',
        '/:looking:/i',
        '/:love1:/i',
        '/:love2:/i',
        '/:mad:/i',
        '/:monster1:/i',
        '/:monster2:/i',
        '/:muhaha:/i',
        '/:multikiller:/i',
        '/:nee_nee:/i',
        '/:night:/i',
        '/:pleased:/i',
        '/:rebel:/i',
        '/:redface:/i',
        '/:respekt:/i',
        '/:rofl:/i',
        '/:rolleyes:/i',
        '/:schiel:/i',
        '/:schild:/i',
        '/:search:/i',
        '/:sick:/i',
        '/:skull1:/i',
        '/:skull2:/i',
        '/:skull3:/i',
        '/:skull4:/i',
        '/:sleep:/i',
        '/:smile:/i',
        '/:smily:/i',
        '/:sonne:/i',
        '/:sure:/i',
        '/:tdw:/i',
        '/:tongue:/i',
        '/:tongue2:/i',
        '/:traurig:/i',
        '/:trooper:/i',
        '/:tup:/i',
        '/:vader:/i',
        '/:vschwoer:/i',
        '/:wallbash:/i',
        '/:whatever:/i',
        '/:wink:/i',
        '/:wow:/i',
        '/:xmas:/i',
        '/:xp:/i'
    );

    // HTML tags to replace BBcode
    $replace = array(
        '<img src="/images/smileys/1bluewinky.gif" width="15px" height="15px">',
        '<img src="/images/smileys/alien2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/alien3.gif" width="15px" height="15px">',
        '<img src="/images/smileys/alien4.gif" width="15px" height="15px">',
        '<img src="/images/smileys/alien5.gif" width="15px" height="15px">',
        '<img src="/images/smileys/amidala.gif" width="15px" height="15px">',
        '<img src="/images/smileys/angryfire.gif" width="15px" height="15px">',
        '<img src="/images/smileys/angst.gif" width="15px" height="15px">',
        '<img src="/images/smileys/applaus.gif" width="15px" height="15px">',
        '<img src="/images/smileys/ausheck.gif" width="15px" height="15px">',
        '<img src="/images/smileys/baby.gif" width="15px" height="15px">',
        '<img src="/images/smileys/biggrin.gif" width="15px" height="15px">',
        '<img src="/images/smileys/birthday.gif" width="15px" height="15px">',
        '<img src="/images/smileys/bluepleased.gif" width="15px" height="15px">',
        '<img src="/images/smileys/borg.gif" width="15px" height="15px">',
        '<img src="/images/smileys/bounce1.gif" width="15px" height="15px">',
        '<img src="/images/smileys/bounce2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/bounce3.gif" width="15px" height="15px">',
        '<img src="/images/smileys/bounce4.gif" width="15px" height="15px">',
        '<img src="/images/smileys/bounce5.gif" width="15px" height="15px">',
        '<img src="/images/smileys/burn1.gif" width="15px" height="15px">',
        '<img src="/images/smileys/bye.gif" width="15px" height="15px">',
        '<img src="/images/smileys/chinese.gif" width="15px" height="15px">',
        '<img src="/images/smileys/confused.gif" width="15px" height="15px">',
        '<img src="/images/smileys/cool.gif" width="15px" height="15px">',
        '<img src="/images/smileys/coolgr.gif" width="15px" height="15px">',
        '<img src="/images/smileys/coolred.gif" width="15px" height="15px">',
        '<img src="/images/smileys/cry.gif" width="15px" height="15px">',
        '<img src="/images/smileys/crying.gif" width="15px" height="15px">',
        '<img src="/images/smileys/cussing.gif" width="15px" height="15px">',
        '<img src="/images/smileys/cylon.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d1.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d3.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d4.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d5.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d6.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d7.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d8.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d9.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d10.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d11.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d12.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d13.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d14.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d15.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d16.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d17.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d18.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d19.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d20.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d21.gif" width="15px" height="15px">',
        '<img src="/images/smileys/d22.gif" width="15px" height="15px">',
        '<img src="/images/smileys/dark.gif" width="15px" height="15px">',
        '<img src="/images/smileys/dark_anim.gif" width="15px" height="15px">',
        '<img src="/images/smileys/dead.gif" width="15px" height="15px">',
        '<img src="/images/smileys/eek.gif" width="15px" height="15px">',
        '<img src="/images/smileys/elk.gif" width="15px" height="15px">',
        '<img src="/images/smileys/engel.gif" width="15px" height="15px">',
        '<img src="/images/smileys/engel2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/evil.gif" width="15px" height="15px">',
        '<img src="/images/smileys/fett.gif" width="15px" height="15px">',
        '<img src="/images/smileys/firedevil.gif" width="15px" height="15px">',
        '<img src="/images/smileys/flame1.gif" width="15px" height="15px">',
        '<img src="/images/smileys/flame2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/fresse.gif" width="15px" height="15px">',
        '<img src="/images/smileys/frown.gif" width="15px" height="15px">',
        '<img src="/images/smileys/gaehn.gif" width="15px" height="15px">',
        '<img src="/images/smileys/gap.gif" width="15px" height="15px">',
        '<img src="/images/smileys/geld.gif" width="15px" height="15px">',
        '<img src="/images/smileys/happy.gif" width="15px" height="15px">',
        '<img src="/images/smileys/hat1.gif" width="15px" height="15px">',
        '<img src="/images/smileys/hat2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/hat3.gif" width="15px" height="15px">',
        '<img src="/images/smileys/icon2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/icon6.gif" width="15px" height="15px">',
        '<img src="/images/smileys/icon13.gif" width="15px" height="15px">',
        '<img src="/images/smileys/idee.gif" width="15px" height="15px">',
        '<img src="/images/smileys/innocent.gif" width="15px" height="15px">',
        '<img src="/images/smileys/jawa.gif" width="15px" height="15px">',
        '<img src="/images/smileys/jb.gif" width="15px" height="15px">',
        '<img src="/images/smileys/kiss1.gif" width="15px" height="15px">',
        '<img src="/images/smileys/knuddel.gif" width="15px" height="15px">',
        '<img src="/images/smileys/looking.gif" width="15px" height="15px">',
        '<img src="/images/smileys/love1.gif" width="15px" height="15px">',
        '<img src="/images/smileys/love2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/mad.gif" width="15px" height="15px">',
        '<img src="/images/smileys/monster1.gif" width="15px" height="15px">',
        '<img src="/images/smileys/monster2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/muhaha.gif" width="15px" height="15px">',
        '<img src="/images/smileys/multikiller.gif" width="15px" height="15px">',
        '<img src="/images/smileys/nee_nee.gif" width="15px" height="15px">',
        '<img src="/images/smileys/night.gif" width="15px" height="15px">',
        '<img src="/images/smileys/pleased.gif" width="15px" height="15px">',
        '<img src="/images/smileys/rebel.gif" width="15px" height="15px">',
        '<img src="/images/smileys/redface.gif" width="15px" height="15px">',
        '<img src="/images/smileys/respekt.gif" width="15px" height="15px">',
        '<img src="/images/smileys/rofl.gif" width="15px" height="15px">',
        '<img src="/images/smileys/rolleyes.gif" width="15px" height="15px">',
        '<img src="/images/smileys/schiel.gif" width="15px" height="15px">',
        '<img src="/images/smileys/schild.gif" width="15px" height="15px">',
        '<img src="/images/smileys/search.gif" width="15px" height="15px">',
        '<img src="/images/smileys/sick.gif" width="15px" height="15px">',
        '<img src="/images/smileys/skull1.gif" width="15px" height="15px">',
        '<img src="/images/smileys/skull2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/skull3.gif" width="15px" height="15px">',
        '<img src="/images/smileys/skull4.gif" width="15px" height="15px">',
        '<img src="/images/smileys/sleep.gif" width="15px" height="15px">',
        '<img src="/images/smileys/smile.gif" width="15px" height="15px">',
        '<img src="/images/smileys/smily.gif" width="15px" height="15px">',
        '<img src="/images/smileys/sonne.gif" width="15px" height="15px">',
        '<img src="/images/smileys/sure.gif" width="15px" height="15px">',
        '<img src="/images/smileys/tdw.gif" width="15px" height="15px">',
        '<img src="/images/smileys/tongue.gif" width="15px" height="15px">',
        '<img src="/images/smileys/tongue2.gif" width="15px" height="15px">',
        '<img src="/images/smileys/traurig.gif" width="15px" height="15px">',
        '<img src="/images/smileys/trooper.gif" width="15px" height="15px">',
        '<img src="/images/smileys/tup.gif" width="15px" height="15px">',
        '<img src="/images/smileys/vader.gif" width="15px" height="15px">',
        '<img src="/images/smileys/vschwoer.gif" width="15px" height="15px">',
        '<img src="/images/smileys/wallbash.gif" width="15px" height="15px">',
        '<img src="/images/smileys/whatever.gif" width="15px" height="15px">',
        '<img src="/images/smileys/wink.gif" width="15px" height="15px">',
        '<img src="/images/smileys/wow.gif" width="15px" height="15px">',
        '<img src="/images/smileys/xmas.gif" width="15px" height="15px">',
        '<img src="/images/smileys/xp.gif" width="15px" height="15px">'
    );

    // Replacing the BBcodes with corresponding HTML tags
    return preg_replace($find,$replace,$text);
}

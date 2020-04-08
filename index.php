<?php

require_once 'vendor/autoload.php';
$csv = new ParseCsv\Csv();
$csv->parse('sleep-export.csv');

function date_($string) {
    return str_replace('. ', '-', $string);
}

# echo '<pre>'; var_dump($csv->titles); echo '</pre>';
# echo $csv->data[0]['From'].'<br>';
# foreach($csv->data AS $key => $data) {
    for($i = 0; $i < count($csv->data); $i++) {
        echo $i.'<br>';
    }

    /*
    if($data['Id'] != 'Id') {
        echo 'Id: '.date_($data['Id']).'<br>';
        echo 'Timezone: '.date_($data['Tz']).'<br>';
        echo 'From: '.date_($data['From']).'<br>';
        echo 'To: '.date_($data['To']).'<br>';
        echo 'Alarm: '.date_($data['Sched']).'<br>';
        echo 'Hours: '.$data['Hours'].'<br>';
        echo 'Rating: '.$data['Rating'].'<br>';
        echo 'Comment: '.$data['Comment'].'<br>';
        echo 'Framerate: '.$data['Framerate'].'<br>';
        echo 'Snore: '.$data['Snore'].'<br>';
        echo 'Noise: '.$data['Noise'].'<br>';
        echo 'Cycles: '.$data['Cycles'].'<br>';
        echo 'DeepSleep: '.$data['DeepSleep'].'<br>';
        echo 'LenAdjust: '.$data['LenAdjust'].'<br>';
        echo 'Geo: '.$data['Geo'].'<br>';
    }
    echo '<br>';
    */

    # echo '<pre>'; var_dump($data); echo '</pre>';
# }

?>
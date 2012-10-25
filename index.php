<?php
define('USERNAME', 'mac');
define('PASSWORD', '***');
define('CRONTAB_FILE_PATH', 'crontab');
define('CRONTAB_REGEX', '/(?P<disabled>#?)\s*(?P<minute>[\*\d\/\-,]+)\s+(?P<hour>[\*\d\/\-,]+)\s+(?P<day>[\*\d\/\-,]+)\s+(?P<month>[\*\d\/\-,]+)\s+(?P<day_of_week>[\*\d\/\-,]+)\s+(?P<command>[^#$]+)#*\s*(?P<name>.*?)$/');

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != USERNAME || $_SERVER['PHP_AUTH_PW'] != PASSWORD) {
    header('WWW-Authenticate: Basic realm="Auth required"');
    header('HTTP/1.0 401 Unauthorized');
    echo '<!doctype html><title>Crontab</title><meta charset="utf-8"><link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/css/bootstrap-combined.min.css" rel="stylesheet"><div class="container-fluid" style="padding:20px"><div class="well" style="text-align:center;"><h3>Access Denied</h3></div></div>';
    exit;
}

$lines = array_filter(explode(PHP_EOL, file_get_contents(CRONTAB_FILE_PATH)), 'trim');
$schedules = array();

foreach ($lines as $line) {
    $ok = preg_match(CRONTAB_REGEX, $line, $matches);
    if (!$ok) continue;

    $schedules[] = array(
        'active' => empty($matches['disabled']),
        'minute' => $matches['minute'],
        'hour' => $matches['hour'],
        'day' => $matches['day'],
        'month' => $matches['month'],
        'day_of_week' => $matches['day_of_week'],
        'command' => $matches['command'],
        'name' => $matches['name']
    );
}

//echo json_encode($schedules);
?>
<!doctype html>
<title>Crontab</title>
<meta charset="utf-8">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/latest/css/bootstrap-combined.min.css" rel="stylesheet">
<div class="container-fluid" style="padding:20px">
    <table class="table">
        <thead>
            <tr>
                <th>Active</th>
                <th>Minute</th>
                <th>Hour</th>
                <th>Day</th>
                <th>Month</th>
                <th>Day of week</th>
                <th>Command</th>
                <th>Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($schedules as $schedule): ?>
        <tr>
            <td><?php echo $schedule['active']?></td>
            <td><?php echo $schedule['minute']?></td>
            <td><?php echo $schedule['hour']?></td>
            <td><?php echo $schedule['day']?></td>
            <td><?php echo $schedule['month']?></td>
            <td><?php echo $schedule['day_of_week']?></td>
            <td><?php echo $schedule['command']?></td>
            <td><?php echo $schedule['name']?></td>
            <td></td>
        </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<?php // Get UpTimeRobot stats via cURL:

// Replace with website API key:
$api_key = 'REPLACE_WITH_YOUR_KEY';

// Build request:
$request = 'api_key=' . $api_key . '&format=json&logs=1&log_types=1&logs_limit=1&all_time_uptime_ratio=1';

// Access API via cURL:
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.uptimerobot.com/v2/getMonitors',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $request,
    CURLOPT_HTTPHEADER => array(
        'cache-control: no-cache',
        'content-type: application/x-www-form-urlencoded'
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

// Decode JSON response and get only the data needed:
$response = json_decode($response);
$response = $response->monitors[0];

// Website details:
$website_name = $response->friendly_name;
$website_url = $response->url;

// Date monitor was created:
$monitor_started = $response->create_datetime;
$monitor_started = date('jS F Y', $monitor_started);

// Overall uptime percentage:
$monitor_uptime = $response->all_time_uptime_ratio;
$monitor_uptime = number_format($monitor_uptime, 2);

// Overall downtime percentage:
$monitor_downtime = 100 - $monitor_uptime;
$monitor_downtime = number_format($monitor_downtime, 2);

// Data to be passed to chart. Hide downtime if there is none:
if ($monitor_downtime == 0) {
    $data = $monitor_uptime;
    $background_colour = '\'#13B132\'';
    $border_colour = '\'#13B132\'';
    $labels = '\'Uptime\'';
} else {
    $data = $monitor_uptime . ', ' . $monitor_downtime;
    $background_colour = '\'#13B132\', \'#F42121\'';
    $border_colour = '\'#13B132\', \'#F42121\'';
    $labels = '\'Uptime\', \'Downtime\'';
}

// Current website status:
$monitor_status = $response->status;

// Change content to be displayed based on current website status:
if ($monitor_status == 0) { // Monitor is paused:

    $monitor_status = 'The monitor is currently paused. This may be for website updates/maintenance';
    $monitor_info = 'Please check again later for an updated status report';

} elseif ($monitor_status == 2) { // Website is up:

    $monitor_status = 'Website is currently UP' .
    '<span class="icon is-large has-text-success"><i class="fas fa-lg fa-check"></i></span>';

    // Check if there has been any recorded downtime:
    if (empty($response->logs)) { // Downtime recorded:
        $monitor_info = 'There has been no recorded downtime';
    } else { // No downtime recorded:

        // Get date of last downtime:
        $monitor_last_downtime = $response->logs[0]->datetime;
        $monitor_last_downtime = date('jS F Y', $monitor_last_downtime);

        // Get time since last downtime in hours:
        $time_downtime = strtotime($monitor_last_downtime);
        $time_current = time();
        $time_since_downtime = $time_current - $time_downtime;
        $time_since_downtime = floor($time_since_downtime / 3600);

        $monitor_info = 'It has been ' . $time_since_downtime . ' hours (' . $monitor_last_downtime . ') since any downtime';

    }

} elseif ($monitor_status == 9) { // Website is down:

    $monitor_status = 'Website is currently UP' .
    '<span class="icon is-large has-text-danger"><i class="fas fa-lg fa-times"></i></span>';

    // Get length of current downtime in hours:
    $monitor_downtime_seconds = $response->logs[0]->duration; // Seconds
    $monitor_downtime_hours = floor($monitor_downtime_seconds / 3600); // Hours
    $monitor_info = 'The website is currently down. It has been down for' . $monitor_downtime_hours . ' hours';

} ?>
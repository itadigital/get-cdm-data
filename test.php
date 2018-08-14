<?php 

$service_url = 'https://www.conferenceharvester.com/conferenceportal3/webservices/HarvesterJsonAPI.asp?apikey=IRtVaD2vPmx8&method=getAllExhibitorsWithBooth';
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additional info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response);
if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('error occured: ' . $decoded->response->errormessage);
}
echo 'response ok!<br/>';
var_dump(json_decode($decoded, true));

//var_export($decoded->response);

?>
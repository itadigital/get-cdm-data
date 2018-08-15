<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

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


$sortArray = array(); 

foreach($curl_response as $response){ 
    foreach($response as $key=>$value){ 
        if(!isset($sortArray[$key])){ 
            $sortArray[$key] = array(); 
        } 
        $sortArray[$key][] = $value; 
    } 
} 


array_multisort($sortArray['ExhibitorName'],SORT_DESC,$curl_response); 


echo $curl_response;

$decoded = json_decode($curl_response,true);
if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('error occured: ' . $decoded->response->errormessage);
}


$sponsorItems = array();

foreach ($decoded as $item) {
    
    $myObj = array(
        "ExhibitorID" => $item['ExhibitorID'],
        "ExhibitorName" => $item['ExhibitorName'],
        "ExhibitorSponsorshipLevel" => $item['ExhibitorSponsorshipLevel'],
        "ExhibitorLogo" => $item['ExhibitorLogo'],
        "ExhibitorDescriptionLong" => $item['ExhibitorDescriptionLong'],
        "ExhibitorBooth" => "",
        "ExhibitorWebsite" => $item['ExhibitorWebsite'],
        "ExhibitorFacebook" => $item['ExhibitorFacebook'],
        "ExhibitorLinkedIn" => $item['ExhibitorLinkedIn'],
        "ExhibitorTwitter" => $item['ExhibitorTwitter'] 
    );
    
    
    if($item['Booths'][0]){
        $myObj['ExhibitorBooth'] = $item['Booths'][0]['BoothNumber'];
    }

    $sponsorItems[$item['ExhibitorID']] = $myObj;
    
}

//echo json_encode($sponsorItems);
?>
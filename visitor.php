<html>
<head>
<title>Insert JSON Data</title>
</head>
<body>
<?php 

$data = json_decode(file_get_contents('php://input'), true);
$name = $data['Name'];
$company = $data['Company'];
$purpose = $data['Purpose'];
$status = "in";
$date = date("Y-m-d");




$webhookUrl = "";

// Visitor information


// Create the message card
$messageCard = array(
    "@type" => "MessageCard",
    "@context" => "https://schema.org/extensions",
    "summary" => "Visitor Onsite Alert",
    "themeColor" => "0076D7",
    "title" => "Visitor Onsite Alert",
    "sections" => array(
        array(
            "activityTitle" => "Visitor Information",
            "facts" => array(
                array(
                    "name" => "Name:",
                    "value" => $name
                ),
                array(
                    "name" => "Company:",
                    "value" => $company
                ),
                array(
                    "name" => "Purpose:",
                    "value" => $purpose
                )
            ),
            "markdown" => true
        )
    )
);

// Encode the message card to JSON
$jsonData = json_encode($messageCard);

// Use cURL to send the message to Teams
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);
curl_close($ch);

// Check the response
if ($response === false) {
    echo "Error sending message to Teams.";
} else {
    echo "Message sent to Teams successfully.";
}


?>
</body>
</html>

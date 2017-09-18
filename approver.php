<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>

<?php

if ($_FILES['fb_data']['size'] != 0 && $_FILES['tl_data']['size'] != 0)
	if (isset($_SERVER['HTTP_REFERER']))
		header("Location: ".$_SERVER['HTTP_REFERER']);
else
	header("Location: /");

$fb_file = fopen ("fb_data.csv","r");
$tl_file = fopen ("tl_data.csv","r");

fgetcsv ($fb_file, 1000, ",");
fgetcsv ($tl_file, 1000, ",");

$fb_campaigns = array();
$tl_campaigns = array();

while ($data = fgetcsv ($fb_file, 1000, ",")) {
	$campaign = $data[2];
	$stream = substr($campaign, strrpos($campaign, '-s') + 2);
	$cost = $data[7];
	$repotr_date = $data[1];

	if ($stream != '') {
		$fb_campaigns[$stream]['costs'][] = $cost;
		$fb_campaigns[$stream]['repotr_date'][] = $repotr_date;
	}
}

while ($data = fgetcsv ($tl_file, 1000, ",")) {	
	$stream = $data[12].str;
	$price = $data[13];
	$lead_time = $data[2];

	if ($stream != '') {
		$tl_campaigns[$stream]['price'][] = $price;
		$tl_campaigns[$stream]['lead_time'][] = $lead_time;
	}
}

print_r($tl_campaigns);

fclose($fb_file);
fclose($tl_file);
?>

</body>
</html>
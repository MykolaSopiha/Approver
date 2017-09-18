<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Results</title>
	<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
</head>
<body>


	<?php
		if ($_FILES['fb_data']['size'] != 0 && $_FILES['tl_data']['size'] != 0 && $_POST['rub_curr'] != "")
			if (isset($_SERVER['HTTP_REFERER']))
				header("Location: ".$_SERVER['HTTP_REFERER']);
		else
			header("Location: /");

		$fb_file = fopen ("fb_data.csv","r");
		$tl_file = fopen ("tl_data.csv","r");
		$rub_curr = floatval($_POST['rub_curr']);

		fgetcsv ($fb_file, 1000, ",");
		fgetcsv ($tl_file, 1000, ",");

		$fb_campaigns = array();
		$tl_campaigns = array();
		$results = array();

		// Facebook data
		while ($data = fgetcsv ($fb_file, 1000, ",")) {
			if ($data[2] != '') {
				$campaign = $data[2];
				$stream = substr($campaign, strrpos($campaign, '-s') + 2);
				if (strlen($data[7]) == 0) {
					$cost = '0';
				} else {
					$cost = $data[7];
				}
				$report_date = $data[1];
				if ($stream != '') {
					$fb_campaigns[$stream][$report_date] = floatval($cost);
					$results[$stream][$report_date]['cost'] = round(floatval($cost)/$rub_curr, 2);
					$results[$stream][$report_date]['price'] = 0;
				}
			}
		}

		// TerraLeads data
		while ($data = fgetcsv ($tl_file, 1000, ",")) {
			$product = $data[6];
			$stream = $data[12];
			$price = $data[13];
			$lead_time = substr($data[2], 0, 10);
			if ($stream != '' && array_key_exists($stream, $fb_campaigns)) {
				$tl_campaigns[$stream][$lead_time] = floatval($price);
				$results[$stream][$lead_time]['price'] = floatval($price);
			}
		}

		echo "
	<table id=\"example\">
		<thead>
			<tr>
				<th class=\"site_name\">Stream ID</th>
				<th>Day</th>
				<th>Cost</th>
				<th>Price</th>
				<th>Profit</th>
				<th>ROI</th>
			</tr>
		</thead>
	<tbody>
	";

		$keys = array_keys($results);
		foreach ($keys as &$key) {
			$data = array_keys($results[$key]);
			// echo "<tr>";
			foreach ($data as &$day) {
				echo "<tr>";
				$results[$key][$day]['profit'] = $results[$key][$day]['price'] - $results[$key][$day]['cost'];
				$results[$key][$day]['roi'] = ($results[$key][$day]['cost'] == 0) ? '--' :
					round(($results[$key][$day]['price'] - $results[$key][$day]['cost'])/$results[$key][$day]['cost']*100, 2).'%';
				echo "<td>".$key."</td>";
				echo "<td>".$day."</td>";
				echo "<td>".$results[$key][$day]['cost']."</td>";
				echo "<td>".$results[$key][$day]['price']."</td>";
				echo "<td>".$results[$key][$day]['profit']."</td>";
				echo "<td>".$results[$key][$day]['roi']."</td>";
				echo "</tr>";
			}
			// echo "</tr>";
		}

		echo "
    </tbody>
  </table>
		";

		//print_r($results);

		fclose($fb_file);
		fclose($tl_file);
	?>


	<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
	<script>
		$(function(){
			$("#example").dataTable();
		})
	</script>
</body>
</html>


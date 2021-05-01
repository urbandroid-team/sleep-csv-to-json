<?php

	function loadFile($filename) {
		return file_get_contents($filename);
	}

	function convertSleepCsvToJson($csvContents) {
		$resultArray = array();
		$rgx = '/^Id.*?(?=(?:Id|\z))/ms';
		preg_match_all($rgx, $csvContents, $unparsedRecords, PREG_SET_ORDER, 0);

		foreach($unparsedRecords AS $key => $value) {
			# Result array should look like:
			# $res = array(
			# "Id"=>"35",
			# "Tz"=>"37",
			# "Sched"=>"43"
			# );
			$resultRecordAssocArray = array();
			$unparsedRecord = $value[0];
			$unparsedRecordRows = explode("\n", $unparsedRecord);
			$headerRowArray = str_getcsv($unparsedRecordRows[0]);
			$valuesRowArray = str_getcsv($unparsedRecordRows[1]);
			$noiseValuesRowArray = str_getcsv($unparsedRecordRows[2]);

			# Go field by field through the header row
			for($i=0; $i < sizeof($headerRowArray); $i++) {
				if($i < 15) { # Single value fields
					$resultRecordAssocArray[$headerRowArray[$i]] = $valuesRowArray[$i];
					continue;
				}

				if($headerRowArray[$i] !== "Event") {
					# Actigraphy array
					if(!isset($resultRecordAssocArray['actigraphy'])) {
						$resultRecordAssocArray['actigraphy'] = array();
					}

					$resultRecordAssocArray['actigraphy'][] = [
						'time' => date('H:i', strtotime($headerRowArray[$i])),
						'data' => $valuesRowArray[$i]
					];

					# Noise values array
					if(!isset($resultRecordAssocArray['noise'])) {
						$resultRecordAssocArray['noise'] = array();
					}

					if(!empty($noiseValuesRowArray[$i])) {
						$resultRecordAssocArray['noise'][$headerRowArray[$i]] = $noiseValuesRowArray[$i];
					}

					continue;
				}

				if($headerRowArray[$i] === "Event") {
					# Events array
					if(!isset($resultRecordAssocArray['events'])) {
						$resultRecordAssocArray['events'] = array();
					}

					array_push($resultRecordAssocArray['events'], $valuesRowArray[$i]);
				}
			}

			array_push($resultArray, $resultRecordAssocArray);
		}

		return json_encode($resultArray);
	}


	$unique_id = uniqid();
	if(move_uploaded_file($_FILES['file']['tmp_name'], $unique_id.'.csv')) {
		$json = convertSleepCsvToJson(loadFile($unique_id.'.csv'));
		file_put_contents($unique_id.'.json', $json);
		unlink($unique_id.'.csv');
		echo $unique_id.'.json';
	}

?>

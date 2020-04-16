<?php

function loadFile($filename) {
  return file_get_contents($filename);
}

function convertSleepCsvToJson($csvContents) {
  $resultArray = array();

  $rgx = '/^Id.*?(?=(?:Id|\z))/ms';

  preg_match_all($rgx, $csvContents, $unparsedRecords, PREG_SET_ORDER, 0);

  foreach ($unparsedRecords as $key => $value) {
    // Result array should look like:
    // $res = array(
      // "Id"=>"35",
      // "Tz"=>"37",
      // "Sched"=>"43"
    // );
    $resultRecordAssocArray = array();

    $unparsedRecord = $value[0];
    $unparsedRecordRows = explode("\n", $unparsedRecord);

    $headerRowArray = str_getcsv($unparsedRecordRows[0]);
    $valuesRowArray = str_getcsv($unparsedRecordRows[1]);
    $noiseValuesRowArray = str_getcsv($unparsedRecordRows[2]);

    // go field by field through the header row
    for ($i=0; $i < sizeof($headerRowArray); $i++) {

      if ($i < 15) { // single value fields
        $resultRecordAssocArray[$headerRowArray[$i]] = $valuesRowArray[$i];
        continue;
      }

      if ($headerRowArray[$i] !== "Event") {
        // actigraphy array
        if (!isset($resultRecordAssocArray['actigraphy'])) {
          $resultRecordAssocArray['actigraphy'] = array();
        }
        $resultRecordAssocArray['actigraphy'][$headerRowArray[$i]] = $valuesRowArray[$i];

        // noise values array
        if (!isset($resultRecordAssocArray['noise'])) {
          $resultRecordAssocArray['noise'] = array();
        }
        if (!empty($noiseValuesRowArray[$i])) {
          $resultRecordAssocArray['noise'][$headerRowArray[$i]] = $noiseValuesRowArray[$i];
        }

        continue;
      }

      if ($headerRowArray[$i] === "Event") {
        // events array
        if (!isset($resultRecordAssocArray['events'])) {
          $resultRecordAssocArray['events'] = array();
        }
        array_push($resultRecordAssocArray['events'], $valuesRowArray[$i]);
      }

    }

    array_push($resultArray, $resultRecordAssocArray);

  }

  return json_encode($resultArray);

}

$filename = "sleep-test2.csv";
$json = convertSleepCsvToJson(loadFile($filename));
print_r($json);

file_put_contents('output.json', $json);

?>
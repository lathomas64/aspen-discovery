<?php
require_once ROOT_DIR . '/Action.php';
require_once ROOT_DIR . '/RecordDrivers/RecordDriverFactory.php';

class ETL_Home extends Action {
	function launch() {
		global $serverName;
		$importPath = '/data/aspen-discovery/' . $serverName . '/import/';
		$importFile = $importPath . "list.csv";
		if(!file_exists($importFile))
		{
			echo "could not find $importFile";
			return;
		}
		$fileHandler = fopen($importFile, 'r');
		$line = fgets($fileHandler);
		$createdLists = array();
		while ($line) {
			$split = explode(",",$line);
			$barcode = trim($split[0]);
			//$patronID = trim($split[1]);
			$ListName = trim($split[2]);
			$BibID = trim($split[3]);
			$line = fgets($fileHandler);//put here so we still get the next line if we loop early
			if(!array_key_exists($ListName, $createdLists))
			{
				$temp = array("title" => $ListName,
					"importedFrom" => "Sierra",
					"links" => array("user" =>$barcode, "userListEntries" => []));
				$createdLists[$ListName] = $temp;
			}
			$recordDriver = RecordDriverFactory::initRecordDriverById('ils:.b' . $BibID . $this->getCheckDigitStatic($BibID));
			if (is_null($recordDriver) || !$recordDriver->isValid())// initRecordDriverById itself does a validity check and returns null if not.
			{
				continue;//skip this line if we don't have a driver	
			}
			$groupedWorkID = $recordDriver->getGroupedWorkId();
			if(is_null($groupedWorkID))
			{
				continue;//skip null grouped Works
			}
			$createdLists[$ListName]["links"]["userListEntries"][] = array("source"=> "GroupedWork", "sourceId" => $groupedWorkID);
		}
		fclose($fileHandler);
		$exportFile = $importPath . "user_lists.json";
		$exportFileHandler = fopen($exportFile, 'w');

		foreach($createdLists as $name => $list)
		{
			fwrite($exportFileHandler, json_encode($list) . "\n");
			echo json_encode($list) . "<br>";
		}
		fclose($exportFileHandler);
		//global $interface;
		//$this->display('default.tpl', 'Hello World!', false);
	}

	function getCheckDigitStatic($baseId) {
		$baseId = preg_replace('/\.?[bij]/', '', $baseId);
		$sumOfDigits = 0;
		for ($i = 0; $i < strlen($baseId); $i++) {
			$curDigit = substr($baseId, $i, 1);
			$sumOfDigits += ((strlen($baseId) + 1) - $i) * (int)$curDigit;
		}
		$modValue = $sumOfDigits % 11;
		if ($modValue == 10) {
			return "x";
		} else {
			return $modValue;
		}
	}

	function getBreadcrumbs(): array
	{
		$breadcrumbs = [];
		return $breadcrumbs;
	}

	function canView(): bool {
		if (UserAccount::isLoggedIn()) {
			if (UserAccount::getActiveUserObj()->isAspenAdminUser()) {
				return true;
			}
		}
		return false;
	}
}
?>
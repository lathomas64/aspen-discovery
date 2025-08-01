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
			if(!array_key_exists($ListName, $createdLists))
			{
				$temp = array("title" => $ListName,
					"importedFrom" => "Sierra",
					"links" => array("user" =>$barcode, "userListEntries" => []));
				$createdLists[$ListName] = $temp;
			}
			$createdLists[$ListName]["links"]["userListEntries"][] = array("source"=> "GroupedWork", "sourceId" => $BibID);
			$line = fgets($fileHandler);
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

	function getBreadcrumbs(): array
	{
		$breadcrumbs = [];
		return $breadcrumbs;
	}
}
?>
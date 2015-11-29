<?

include_once(__DIR__ . "/../HomeKitService/module.php");

class HomeKitLightSensorService extends HomeKitService {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		$this->RegisterPropertyInteger("CurrentAmbientLightLevelVariableId", 0);
	}
}

?>
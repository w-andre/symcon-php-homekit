<?

include_once(__DIR__ . "/../HomeKitService/module.php");

class HomeKitTemperatureSensorService extends HomeKitService {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		$this->RegisterPropertyInteger("CurrentTemperatureVariableId", 0);
	}
}

?>
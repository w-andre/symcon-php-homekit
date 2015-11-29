<?

include_once(__DIR__ . "/../HomeKitService/module.php");

class HomeKitHumiditySensorService extends HomeKitService {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		$this->RegisterPropertyInteger("CurrentRelativeHumidityVariableId", 0);
		$this->RegisterPropertyFloat("CurrentRelativeHumidityMaxValue", 100);
	}
}

?>
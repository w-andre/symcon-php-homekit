<?

include_once(__DIR__ . "/../HomeKitService/module.php");

class HomeKitLightBulbService extends HomeKitService {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		// required
		$this->RegisterPropertyInteger("OnVariableId", 0);
		$this->RegisterPropertyString("OnValueTrue", "1");
		$this->RegisterPropertyString("OnValueFalse", "0");
		
		// optional
		$this->RegisterPropertyInteger("BrightnessVariableId", 0);
		$this->RegisterPropertyFloat("BrightnessMaxValue", 100);
		
		$this->RegisterPropertyInteger("HueVariableId", 0);
		
		$this->RegisterPropertyInteger("SaturationVariableId", 0);
		$this->RegisterPropertyFloat("SaturationMaxValue", 100);
	}
}

?>
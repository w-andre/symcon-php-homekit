<?

include_once(__DIR__ . "/../HomeKitService/module.php");

class HomeKitThermostatService extends HomeKitService {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		$this->RegisterPropertyInteger("CurrentHeatingCoolingStateVariableId", 0);
		$this->RegisterPropertyString("CurrentHeatingCoolingStateValue0", "");
		$this->RegisterPropertyString("CurrentHeatingCoolingStateValue1", "");
		$this->RegisterPropertyString("CurrentHeatingCoolingStateValue2", "");
		
		$this->RegisterPropertyInteger("TargetHeatingCoolingStateVariableId", 0);
		$this->RegisterPropertyString("TargetHeatingCoolingStateValue0", "");
		$this->RegisterPropertyString("TargetHeatingCoolingStateValue1", "");
		$this->RegisterPropertyString("TargetHeatingCoolingStateValue2", "");
		$this->RegisterPropertyString("TargetHeatingCoolingStateValue3", "");
		
		$this->RegisterPropertyInteger("CurrentTemperatureVariableId", 0);
		$this->RegisterPropertyInteger("TargetTemperatureVariableId", 0);
		
		$this->RegisterPropertyInteger("TemperatureDisplayUnits", 0);
	}
}

?>
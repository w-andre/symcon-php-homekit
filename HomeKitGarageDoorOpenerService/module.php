<?

include_once(__DIR__ . "/../HomeKitService/module.php");

class HomeKitGarageDoorOpenerService extends HomeKitService {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		$this->RegisterPropertyInteger("CurrentDoorStateVariableId", 0);
		$this->RegisterPropertyString("CurrentDoorStateValue0", "");
		$this->RegisterPropertyString("CurrentDoorStateValue1", "");
		$this->RegisterPropertyString("CurrentDoorStateValue2", "");
		$this->RegisterPropertyString("CurrentDoorStateValue3", "");
		$this->RegisterPropertyString("CurrentDoorStateValue4", "");
		
		$this->RegisterPropertyInteger("TargetDoorStateVariableId", 0);
		$this->RegisterPropertyString("TargetDoorStateValue0", "");
		$this->RegisterPropertyString("TargetDoorStateValue1", "");
		
		$this->RegisterPropertyInteger("ObstructionDetectedVariableId", 0);
		$this->RegisterPropertyString("ObstructionDetectedValueTrue", "1");
		$this->RegisterPropertyString("ObstructionDetectedValueFalse", "0");
	}
}

?>
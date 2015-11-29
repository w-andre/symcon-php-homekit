<?

include_once(__DIR__ . "/../HomeKitService/module.php");

class HomeKitWindowCoveringService extends HomeKitService {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		$this->RegisterPropertyInteger("CurrentPositionVariableId", 0);
		$this->RegisterPropertyFloat("CurrentPositionMaxValue", 100);
		
		$this->RegisterPropertyInteger("TargetPositionVariableId", 0);
		$this->RegisterPropertyFloat("TargetPositionMaxValue", 100);
		
		$this->RegisterPropertyInteger("PositionStateVariableId", 0);
		$this->RegisterPropertyString("PositionStateValue0", "");
		$this->RegisterPropertyString("PositionStateValue1", "");
		$this->RegisterPropertyString("PositionStateValue2", "");
	}
}

?>
<?

include_once(__DIR__ . "/../HomeKitService/module.php");

class HomeKitSwitchService extends HomeKitService {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		$this->RegisterPropertyInteger("OnVariableId", 0);
		$this->RegisterPropertyString("OnValueTrue", "1");
		$this->RegisterPropertyString("OnValueFalse", "0");
	}
}

?>
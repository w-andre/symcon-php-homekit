<?

include_once(__DIR__ . "/../HomeKitService/module.php");

class HomeKitOutletService extends HomeKitService {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		$this->RegisterPropertyInteger("OnVariableId", 0);
		$this->RegisterPropertyString("OnValueTrue", "1");
		$this->RegisterPropertyString("OnValueFalse", "0");
		
		$this->RegisterPropertyInteger("OutletInUseVariableId", 0);
		$this->RegisterPropertyString("OutletInUseValueTrue", "1");
		$this->RegisterPropertyString("OutletInUseValueFalse", "0");
	}
}

?>
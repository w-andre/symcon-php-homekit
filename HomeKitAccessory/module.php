<?
class HomeKitAccessory extends IPSModule {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		$this->RegisterPropertyInteger("Fan", 0);
		$this->RegisterPropertyInteger("GarageDoorOpener", 0);
		$this->RegisterPropertyInteger("LightBulb", 0);
		$this->RegisterPropertyInteger("LockMechanism", 0);
		$this->RegisterPropertyInteger("Switch", 0);
		$this->RegisterPropertyInteger("TemperatureSensor", 0);
		$this->RegisterPropertyInteger("Thermostat", 0);
		$this->RegisterPropertyInteger("WindowCovering", 0);
	}

	public function ApplyChanges() {
		// Diese Zeile nicht löschen
		parent::ApplyChanges();
		
		CreateInstances("Fan");
		CreateInstances("GarageDoorOpener");
		CreateInstances("LightBulb");
		CreateInstances("LockMechanism");
		CreateInstances("Switch");
		CreateInstances("TemperatureSensor");
		CreateInstances("Thermostat");
		CreateInstances("WindowCovering");
	}
	
	private function CreateInstances($type) {
		$count = $this->ReadPropertyInteger($type);
		if ($count <= 0) return;
		
		$parentId = $this->InstanceID;
				
		for($i = 1; $i <= $fan; $i++) {
			$instanceId = IPS_CreateInstance("{E12D6D3E-BF81-4BF2-B745-B217B85898CB}"); // HomeKitService
			IPS_SetParent($instanceId, $parentId);
			IPS_SetName($instanceId, $type . " " . $i);
		}
	}
	
	public function GetServices() {
		
		
	}
}

?>
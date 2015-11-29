<?

class HomeKitAccessory extends IPSModule {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
		$this->RegisterPropertyInteger("Fan", 0);
		$this->RegisterPropertyInteger("GarageDoorOpener", 0);
		$this->RegisterPropertyInteger("HumiditySensor", 0);
		$this->RegisterPropertyInteger("LightBulb", 0);
		$this->RegisterPropertyInteger("LightSensor", 0);
		$this->RegisterPropertyInteger("LockMechanism", 0);
		$this->RegisterPropertyInteger("Outlet", 0);
		$this->RegisterPropertyInteger("Switch", 0);
		$this->RegisterPropertyInteger("TemperatureSensor", 0);
		$this->RegisterPropertyInteger("Thermostat", 0);
		$this->RegisterPropertyInteger("WindowCovering", 0);
	}

	public function ApplyChanges() {
		// Diese Zeile nicht löschen
		parent::ApplyChanges();
		
		$services = $this->GetServices();
		
		foreach($services as $key => $value) {
			$configuredValue = $this->ReadPropertyInteger($key);
			$actualValue = count($value);
			$this->CreateServiceTypeInstances($key, $configuredValue - $actualValue);
		}
	}
	
	public function CreateServiceTypeInstances(string $serviceType, integer $count) {
		if ($count <= 0) return;
		
		$parentId = $this->InstanceID;
		$moduleId = $this->GetModuleIdFromServiceType($serviceType);
				
		for($i = 1; $i <= $count; $i++) {
			$instanceId = IPS_CreateInstance($moduleId);
			if ($instanceId == 0) continue;
			
			IPS_SetParent($instanceId, $parentId);
			IPS_SetName($instanceId, $serviceType . " " . $i);
		}
	}
	
	public function GetServices() {
		$childrenIds = IPS_GetChildrenIDs($this->InstanceID);
		
		$services = array(
			"Fan" => array(),
			"GarageDoorOpener" => array(),
			"HumiditySensor" => array(),
			"LightBulb" => array(),
			"LightSensor" => array(),
			"LockMechanism" => array(),
			"Outlet" => array(),
			"Switch" => array(),
			"TemperatureSensor" => array(),
			"Thermostat" => array(),
			"WindowCovering" => array()
		);
		
		foreach ($childrenIds as $id) {
			$instance = IPS_GetInstance($id);
			$moduleId = $instance["ModuleInfo"]["ModuleID"];
			$serviceType = $this->GetServiceTypeFromModuleId($moduleId);
			if (is_null($serviceType)) continue;
			array_push($services[$serviceType], $id);
		}
		
		return $services;
	}
	
	public function GetServiceTypeFromModuleId(string $moduleId) {
		switch($moduleId) {
			case "{15ED41C3-E385-4800-A109-AD7EDBE72FF0}": return "Fan";
			case "{46B95039-99AE-416D-81C7-948B469571EF}": return "GarageDoorOpener";
			case "{D94A1996-F60A-4AF1-B640-F4701DECED27}": return "HumiditySensor";
			case "{B3590C53-3E0E-4BBC-9BCA-76E208750C19}": return "LightBulb";
			case "{53F9E5A7-D0CB-4DF7-939C-4D112046BA18}": return "LightSensor";
			case "{1A0A3A42-1DA1-4336-A62E-2ECB7EA6FEFC}": return "LockMechanism";
			case "{CFB352B8-D547-4BD8-829A-5136B8EFD19B}": return "Outlet";
			case "{26AA1820-981B-42E0-BE68-81F505444D56}": return "Switch";
			case "{0AEE9E1C-6F9C-4003-B8CA-2495172F6C41}": return "TemperatureSensor";
			case "{8F76690C-C564-4A1C-A332-E754467A64CA}": return "Thermostat";
			case "{C7D35CD7-9EE6-451C-A67F-94C9D7165D1E}": return "WindowCovering";
		}
	}
	
	public function GetModuleIdFromServiceType(string $serviceType) {
		switch($serviceType) {
			case "Fan": return "{15ED41C3-E385-4800-A109-AD7EDBE72FF0}";
			case "GarageDoorOpener": return "{46B95039-99AE-416D-81C7-948B469571EF}";
			case "HumiditySensor": return "{D94A1996-F60A-4AF1-B640-F4701DECED27}";
			case "LightBulb": return "{B3590C53-3E0E-4BBC-9BCA-76E208750C19}";
			case "LightSensor": return "{53F9E5A7-D0CB-4DF7-939C-4D112046BA18}";
			case "LockMechanism": return "{1A0A3A42-1DA1-4336-A62E-2ECB7EA6FEFC}";
			case "Outlet": return "{CFB352B8-D547-4BD8-829A-5136B8EFD19B}";
			case "Switch": return "{26AA1820-981B-42E0-BE68-81F505444D56}";
			case "TemperatureSensor": return "{0AEE9E1C-6F9C-4003-B8CA-2495172F6C41}";
			case "Thermostat": return "{8F76690C-C564-4A1C-A332-E754467A64CA}";
			case "WindowCovering": return "{C7D35CD7-9EE6-451C-A67F-94C9D7165D1E}";
		}
	}
}

?>
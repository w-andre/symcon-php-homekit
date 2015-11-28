<?
class HomeKitService extends IPSModule {

	public function Create() {
		//Never delete this line!
		parent::Create();
		
		$this->RegisterPropertyInteger("DeviceType", 0);
		
		$this->RegisterPropertyInteger("PowerStateVariableId", 0);
		$this->RegisterPropertyString("PowerStateOn", "1");
		$this->RegisterPropertyString("PowerStateOff", "0");
		
		$this->RegisterPropertyInteger("BrightnessVariableId", 0);
		$this->RegisterPropertyFloat("BrightnessMaxValue", 100);
		
		$this->RegisterPropertyInteger("TargetDoorStateVariableId", 0);
		$this->RegisterPropertyString("TargetDoorStateOpen", "0");
		$this->RegisterPropertyString("TargetDoorStateClosed", "4");
		$this->RegisterPropertyString("TargetDoorStateOpening", "0");
		$this->RegisterPropertyString("TargetDoorStateClosing", "4");
		$this->RegisterPropertyString("TargetDoorStateStopped", "2");
		
		$this->RegisterPropertyInteger("CurrentDoorStateVariableId", 0);
		$this->RegisterPropertyString("CurrentDoorStateOpen", "0");
		$this->RegisterPropertyString("CurrentDoorStateClosed", "4");
		$this->RegisterPropertyString("CurrentDoorStateOpening", "0");
		$this->RegisterPropertyString("CurrentDoorStateClosing", "4");
		$this->RegisterPropertyString("CurrentDoorStateStopped", "2");
		
		$this->RegisterPropertyInteger("TargetTemperatureVariableId", 0);
		$this->RegisterPropertyInteger("CurrentTemperatureVariableId", 0);
		
		
		$this->RegisterPropertyInteger("TargetLockMechanismStateVariableId", 0);
		$this->RegisterPropertyString("TargetLockMechanismStateUnsecured", "0");
		$this->RegisterPropertyString("TargetLockMechanismStateSecured", "1");
		$this->RegisterPropertyString("TargetLockMechanismStateJammed", "2");
		$this->RegisterPropertyString("TargetLockMechanismStateUnknown", "3");
		
		$this->RegisterPropertyInteger("CurrentLockMechanismStateVariableId", 0);
		$this->RegisterPropertyString("CurrentLockMechanismStateUnsecured", "0");
		$this->RegisterPropertyString("CurrentLockMechanismStateSecured", "1");
		$this->RegisterPropertyString("CurrentLockMechanismStateJammed", "2");
		$this->RegisterPropertyString("CurrentLockMechanismStateUnknown", "3");
	}

	public function ApplyChanges() {
		//Never delete this line!
		parent::ApplyChanges();
		
		$this->RegisterProfileIntegerEx("DoorState.HomeKit", "Shutter", "", "", Array(
				Array(0, "Open", "", 65280),
				Array(1, "Closed", "", 16711680),
				Array(2, "Opening", "", -1),
				Array(3, "Closing", "", -1),
				Array(4, "Stopped", "", -1)
		));
		
		$this->RegisterProfileIntegerEx("LockMechanismSate.HomeKit", "LockClosed", "", "", Array(
				Array(0, "Unsecured", "LockOpen", 65280),
				Array(1, "Secured", "LockClosed", 16711680),
				Array(2, "Jammed", "", -1),
				Array(3, "Unknown", "", -1)
		));
		
		// get current device type
		$deviceType = $this->ReadPropertyInteger("DeviceType");

		// update variables for current device type
		switch ($deviceType) {
			case 0: // switch
				$this->MaintainVariable("PowerState", "Power State", 0, "~Switch", 10, true);
				$this->MaintainVariable("Brightness", "Brightness", 1, "~Intensity.100", 20, false);
				$this->MaintainVariable("TargetDoorState", "Target Door State", 1, "DoorState.HomeKit", 30, false);
				$this->MaintainVariable("CurrentDoorState", "Current Door State", 1, "DoorState.HomeKit", 40, false);
				$this->MaintainVariable("TargetTemperature", "Target Temperature", 2, "~Temperature", 50, false);
				$this->MaintainVariable("CurrentTemperature", "Current Temperature", 2, "~Temperature", 60, false);
				$this->MaintainVariable("TargetLockMechanismState", "Target Lock Mechanism State", 1, "LockMechanismSate.HomeKit", 70, false);
				$this->MaintainVariable("CurrentLockMechanismState", "Current Lock Mechanism State", 1, "LockMechanismSate.HomeKit", 80, false);
				break;
			case 1: // light bulb
				$this->MaintainVariable("PowerState", "Power State", 0, "~Switch", 10, true);
				$this->MaintainVariable("Brightness", "Brightness", 1, "~Intensity.100", 20, true);
				$this->MaintainVariable("Target Door State", "Target Door State", 1, "DoorState.HomeKit", 30, false);
				$this->MaintainVariable("Current Door State", "Current Door State", 1, "DoorState.HomeKit", 40, false);
				$this->MaintainVariable("Target Temperature", "Target Temperature", 2, "~Temperature", 50, false);
				$this->MaintainVariable("Current Temperature", "Current Temperature", 2, "~Temperature", 60, false);
				$this->MaintainVariable("TargetLockMechanismState", "Target Lock Mechanism State", 1, "LockMechanismSate.HomeKit", 70, false);
				$this->MaintainVariable("CurrentLockMechanismState", "Current Lock Mechanism State", 1, "LockMechanismSate.HomeKit", 80, false);
				break;
			case 2: // garage door opener
				$this->MaintainVariable("PowerState", "Power State", 0, "~Switch", 10, false);
				$this->MaintainVariable("Brightness", "Brightness", 1, "~Intensity.100", 20, false);
				$this->MaintainVariable("TargetDoorState", "Target Door State", 1, "DoorState.HomeKit", 30, true);
				$this->MaintainVariable("CurrentDoorState", "Current Door State", 1, "DoorState.HomeKit", 40, true);
				$this->MaintainVariable("TargetTemperature", "Target Temperature", 2, "~Temperature", 50, false);
				$this->MaintainVariable("CurrentTemperature", "Current Temperature", 2, "~Temperature", 60, false);
				$this->MaintainVariable("TargetLockMechanismState", "Target Lock Mechanism State", 1, "LockMechanismSate.HomeKit", 70, false);
				$this->MaintainVariable("CurrentLockMechanismState", "Current Lock Mechanism State", 1, "LockMechanismSate.HomeKit", 80, false);
				break;
			case 3: // thermostat
				$this->MaintainVariable("PowerState", "PowerState", 0, "~Switch", 10, false);
				$this->MaintainVariable("Brightness", "Brightness", 1, "~Intensity.100", 20, false);
				$this->MaintainVariable("TargetDoorState", "Target Door State", 1, "DoorState.HomeKit", 30, false);
				$this->MaintainVariable("CurrentDoorState", "Current Door State", 1, "DoorState.HomeKit", 40, false);
				$this->MaintainVariable("TargetTemperature", "Target Temperature", 2, "~Temperature", 50, true);
				$this->MaintainVariable("CurrentTemperature", "Current Temperature", 2, "~Temperature", 60, true);
				$this->MaintainVariable("TargetLockMechanismState", "Target Lock Mechanism State", 1, "LockMechanismSate.HomeKit", 70, false);
				$this->MaintainVariable("CurrentLockMechanismState", "Current Lock Mechanism State", 1, "LockMechanismSate.HomeKit", 80, false);
				break;
			case 4: // lock mechanism
				$this->MaintainVariable("PowerState", "Power State", 0, "~Switch", 10, false);
				$this->MaintainVariable("Brightness", "Brightness", 1, "~Intensity.100", 20, false);
				$this->MaintainVariable("TargetDoorState", "Target Door State", 1, "DoorState.HomeKit", 30, false);
				$this->MaintainVariable("CurrentDoorState", "Current Door State", 1, "DoorState.HomeKit", 40, false);
				$this->MaintainVariable("TargetTemperature", "Target Temperature", 2, "~Temperature", 50, false);
				$this->MaintainVariable("CurrentTemperature", "Current Temperature", 2, "~Temperature", 60, false);
				$this->MaintainVariable("TargetLockMechanismState", "Target Lock Mechanism State", 1, "LockMechanismSate.HomeKit", 70, true);
				$this->MaintainVariable("CurrentLockMechanismState", "Current Lock Mechanism State", 1, "LockMechanismSate.HomeKit", 80, true);
				break;
		}
	}
	
	/*
		Switch and Light Bulb functions
	*/

	public function SetPowerState($value) {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("PowerStateVariableId");
		$this->SetTargetVariableValue($variableId, "PowerState", $value);
		SetValueBoolean($this->GetIDForIdent("PowerState"), $value);
	}

	public function GetPowerState() {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("PowerStateVariableId");
		$value = $this->GetHomeKitValue($variableId, "PowerState");
		SetValueBoolean($this->GetIDForIdent("PowerState"), $value);
		return $value;
	}

	/*
		Light Bulb functions
	*/

	public function SetBrightness($value) {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("BrightnessVariableId");
		
		// brightness variable specified?
		if ($variableId > 0) {
			$this->SetTargetVariableValue($variableId, "Brightness", $value);
			SetValueInteger($this->GetIDForIdent("Brightness"), $value);
			return;
		}
		
		// fallback to power state
		$variableId = $this->ReadPropertyInteger("PowerStateVariableId");
		$this->SetTargetVariableValue($variableId, "PowerState", $value > 0);
		SetValueInteger($this->GetIDForIdent("Brightness"), $value > 0 ? 100 : 0);
	}

	public function GetBrightness() {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("BrightnessVariableId");
		$value = -1;
		
		// brightness variable specified?
		if ($variableId > 0) {
			$value = $this->GetHomeKitValue($variableId, "Brightness");
		} else {
			// fallback to power state
			$variableId = $this->ReadPropertyInteger("PowerStateVariableId");
			$value =  $this->GetHomeKitValue($variableId, "PowerState") ? 100 : 0;
		}
		SetValueInteger($this->GetIDForIdent("Brightness"), $value);
		return $value;
	}

	/*
		Thermostat functions
	*/

	public function SetTargetTemperature($value) {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("TargetTemperatureVariableId");
		$this->SetTargetVariableValue($variableId, "TargetTemperature", $value);
		SetValueFloat($this->GetIDForIdent("TargetTemperature"), $value);
	}

	public function GetTargetTemperature() {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("TargetTemperatureVariableId");
		$value = $this->GetHomeKitValue($variableId, "TargetTemperature");
		SetValueFloat($this->GetIDForIdent("TargetTemperature"), $value);
		return $value;
	}

	public function GetCurrentTemperature() {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("CurrentTemperatureVariableId");
		$value = $this->GetHomeKitValue($variableId, "CurrentTemperature");
		SetValueFloat($this->GetIDForIdent("CurrentTemperature"), $value);
		return $value;
	}

	/*
		Garage Door Opener functions
	*/

	public function SetTargetDoorState($value) {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("TargetDoorStateVariableId");
		$this->SetTargetVariableValue($variableId, "TargetDoorState", $value);
		SetValueInteger($this->GetIDForIdent("TargetDoorState"), $value);
	}

	public function GetTargetDoorState() {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("TargetDoorStateVariableId");
		$value = $this->GetHomeKitValue($variableId, "TargetDoorState");
		SetValueInteger($this->GetIDForIdent("TargetDoorState"), $value);
		return $value;
	}

	public function GetCurrentDoorState() {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("CurrentDoorStateVariableId");
		$value = $this->GetHomeKitValue($variableId, "CurrentDoorState");
		SetValueInteger($this->GetIDForIdent("CurrentDoorState"), $value);
		return $value;
	}

	/*
		Lock Mechanism functions
	*/

	public function SetTargetLockMechanismState($value) {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("TargetLockMechanismStateVariableId");
		$this->SetTargetVariableValue($variableId, "TargetLockMechanismState", $value);
		SetValueInteger($this->GetIDForIdent("TargetLockMechanismState"), $value);
	}

	public function GetTargetLockMechanismState() {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("TargetLockMechanismStateVariableId");
		$value = $this->GetHomeKitValue($variableId, "TargetLockMechanismState");
		SetValueInteger($this->GetIDForIdent("TargetLockMechanismState"), $value);
		return $value;
	}

	public function GetCurrentLockMechanismState() {
		// get target variable id
		$variableId = $this->ReadPropertyInteger("CurrentLockMechanismStateVariableId");
		$value = $this->GetHomeKitValue($variableId, "CurrentLockMechanismState");
		SetValueInteger($this->GetIDForIdent("CurrentLockMechanismState"), $value);
		return $value;
	}

	/*
		internal functions
	*/

	private function SetTargetVariableValue($variableId, $homeKitVariableType, $homeKitValue) {
		// get target variable object properties
		$variableObject = IPS_GetObject($variableId);
		$targetValue = $this->GetTargetValue($variableId, $homeKitVariableType, $homeKitValue);
		
		// request associated action for the specified variable and value
		IPS_RequestAction($variableObject["ParentID"], $variableObject["ObjectIdent"], $targetValue);
	}

	private function GetTargetValue($variableId, $homeKitVariableType, $homeKitValue) {
		$variable = IPS_GetVariable($variableId);
		$variableProfile = $variable['VariableProfile']
			? IPS_GetVariableProfile($variable['VariableProfile'])
			: NULL;
		
		$targetValueString = "";
		switch ($homeKitVariableType) {
			case "PowerState":
				$targetValueString = $homeKitValue 
					? $this->ReadPropertyString("PowerStateOn") 
					: $this->ReadPropertyString("PowerStateOff");
				break;
			case "Brightness":
				$maxValue = $this->ReadPropertyFloat("BrightnessMaxValue");
				$targetValue = ($homeKitValue / 100) * $maxValue;
				$targetValueString = strval($targetValue);
				break;
			case "TargetDoorState":
				switch ($homeKitValue) {
					case 0: //HMCharacteristicValueDoorState::Open
						$targetValueString = $this->ReadPropertyString("TargetDoorStateOpen");
						break;
					case 1: //HMCharacteristicValueDoorState::Closed
						$targetValueString = $this->ReadPropertyString("TargetDoorStateClosed");
						break;
					case 2: //HMCharacteristicValueDoorState::Opening
						$targetValueString = $this->ReadPropertyString("TargetDoorStateOpening");
						break;
					case 3: //HMCharacteristicValueDoorState::Closing
						$targetValueString = $this->ReadPropertyString("TargetDoorStateClosing");
						break;
					case 4: //HMCharacteristicValueDoorState::Stopped
						$targetValueString = $this->ReadPropertyString("TargetDoorStateStopped");
						break;
				}
				break;
			case "CurrentDoorState":
				switch ($homeKitValue) {
					case 0: //HMCharacteristicValueDoorState::Open
						$targetValueString = $this->ReadPropertyString("CurrentDoorStateOpen");
						break;
					case 1: //HMCharacteristicValueDoorState::Closed
						$targetValueString = $this->ReadPropertyString("CurrentDoorStateClosed");
						break;
					case 2: //HMCharacteristicValueDoorState::Opening
						$targetValueString = $this->ReadPropertyString("CurrentDoorStateOpening");
						break;
					case 3: //HMCharacteristicValueDoorState::Closing
						$targetValueString = $this->ReadPropertyString("CurrentDoorStateClosing");
						break;
					case 4: //HMCharacteristicValueDoorState::Stopped
						$targetValueString = $this->ReadPropertyString("CurrentDoorStateStopped");
						break;
				}
				break;
			case "TargetLockMechanism":
				switch ($homeKitValue) {
					case 0: //HMCharacteristicValueLockMechanismState::Unsecured
						$targetValueString = $this->ReadPropertyString("TargetLockMechanismStateUnsecured");
						break;
					case 1: //HMCharacteristicValueLockMechanismState::Secured
						$targetValueString = $this->ReadPropertyString("TargetLockMechanismStateSecured");
						break;
					case 2: //HMCharacteristicValueLockMechanismState::Jammed
						$targetValueString = $this->ReadPropertyString("TargetLockMechanismStateJammed");
						break;
					case 3: //HMCharacteristicValueLockMechanismState::Unknown
						$targetValueString = $this->ReadPropertyString("TargetLockMechanismStateUnknown");
						break;
				}
				break;
			case "CurrentLockMechanism":
				switch ($homeKitValue) {
					case 0: //HMCharacteristicValueLockMechanismState::Unsecured
						$targetValueString = $this->ReadPropertyString("CurrentLockMechanismStateUnsecured");
						break;
					case 1: //HMCharacteristicValueLockMechanismState::Secured
						$targetValueString = $this->ReadPropertyString("CurrentLockMechanismStateSecured");
						break;
					case 2: //HMCharacteristicValueLockMechanismState::Jammed
						$targetValueString = $this->ReadPropertyString("CurrentLockMechanismStateJammed");
						break;
					case 3: //HMCharacteristicValueLockMechanismState::Unknown
						$targetValueString = $this->ReadPropertyString("CurrentLockMechanismStateUnknown");
						break;
				}
				break;
			case "CurrentTemperature": 
			case "TargetTemperature": 
			default:
				$targetValueString = strval($homeKitValue);
		}
		
		if ($targetValueString == "") return $homeKitValue;
		
		switch ($variable["VariableType"]) {
			case 0: // boolean
				return boolval($targetValueString);
			case 1: // integer
				return intval($targetValueString);
			case 2: // float
				return $variableProfile && $variableProfile["Digits"] == 0
					? intval($targetValueString)
					: floatval($targetValueString);
			case 3: // string
				return $targetValueString;
			default:
				return $homeKitValue;
		}
	}

	private function GetHomeKitValue($variableId, $homeKitVariableType) {
		$variable = IPS_GetVariable($variableId);
		$value = GetValue($variableId);
		$valueString = strval($value);
		
		switch ($homeKitVariableType) {
			case "PowerState":
				return $valueString == $this->ReadPropertyString("PowerStateOn");
			case "Brightness":
				$maxValue = $this->ReadPropertyFloat("BrightnessMaxValue");
				$targetValue = ($value / $maxValue) * 100;
				return intval($targetValue);
			case "TargetDoorState":
				switch ($valueString) {
					case $this->ReadPropertyString("TargetDoorStateOpen"):
						return 0; //HMCharacteristicValueDoorState::Open;
					case $this->ReadPropertyString("TargetDoorStateClosed"):
						return 1; //HMCharacteristicValueDoorState::Closed;
					case $this->ReadPropertyString("TargetDoorStateOpening"):
						return 2; //HMCharacteristicValueDoorState::Opening;
					case $this->ReadPropertyString("TargetDoorStateClosing"):
						return 3; //HMCharacteristicValueDoorState::Closing;
					case $this->ReadPropertyString("TargetDoorStateStopped"):
						return 4; //HMCharacteristicValueDoorState::Stopped;
				}
				break;
			case "CurrentDoorState":
				switch ($valueString) {
					case $this->ReadPropertyString("CurrentDoorStateOpen"):
						return 0; //HMCharacteristicValueDoorState::Open;
					case $this->ReadPropertyString("CurrentDoorStateClosed"):
						return 1; //HMCharacteristicValueDoorState::Closed;
					case $this->ReadPropertyString("CurrentDoorStateOpening"):
						return 2; //HMCharacteristicValueDoorState::Opening;
					case $this->ReadPropertyString("CurrentDoorStateClosing"):
						return 3; //HMCharacteristicValueDoorState::Closing;
					case $this->ReadPropertyString("CurrentDoorStateStopped"):
						return 4; //HMCharacteristicValueDoorState::Stopped;
				}
				break;
			case "TargetLockMechanismState":
				switch ($valueString) {
					case $this->ReadPropertyString("TargetLockMechanismStateUnsecured"):
						return 0; //HMCharacteristicValueLockMechanismState::Unsecured
					case $this->ReadPropertyString("TargetLockMechanismStateSecured"):
						return 1; //HMCharacteristicValueLockMechanismState::Secured
					case $this->ReadPropertyString("TargetLockMechanismStateJammed"):
						return 2; //HMCharacteristicValueLockMechanismState::Jammed
					case $this->ReadPropertyString("TargetLockMechanismStateUnknown"):
						return 3; //HMCharacteristicValueLockMechanismState::Unknown
				}
				break;
			case "CurrentLockMechanismState":
				switch ($valueString) {
					case $this->ReadPropertyString("CurrentLockMechanismStateUnsecured"):
						return 0; //HMCharacteristicValueLockMechanismState::Unsecured
					case $this->ReadPropertyString("CurrentLockMechanismStateSecured"):
						return 1; //HMCharacteristicValueLockMechanismState::Secured
					case $this->ReadPropertyString("CurrentLockMechanismStateJammed"):
						return 2; //HMCharacteristicValueLockMechanismState::Jammed
					case $this->ReadPropertyString("CurrentLockMechanismStateUnknown"):
						return 3; //HMCharacteristicValueLockMechanismState::Unknown
				}
				break;
			case "CurrentTemperature": // value has to be float
			case "TargetTemperature": // value has to be float
				return floatval($value);
		}
		
		return $value;
	}

	private function RegisterProfileInteger($name, $icon, $prefix, $suffix, $minValue, $maxValue, $stepSize) {
		if(!IPS_VariableProfileExists($name)) {
			IPS_CreateVariableProfile($name, 1);
		} else {
			$profile = IPS_GetVariableProfile($name);
			if($profile['ProfileType'] != 1)
				throw new Exception("Variable profile type does not match for profile " . $name);
		}

		IPS_SetVariableProfileIcon($name, $icon);
		IPS_SetVariableProfileText($name, $prefix, $suffix);
		IPS_SetVariableProfileValues($name, $minValue, $maxValue, $stepSize);
	}

	private function RegisterProfileIntegerEx($name, $icon, $prefix, $suffix, $associations) {
		if ( sizeof($associations) === 0 ){
			$minValue = 0;
			$maxValue = 0;
		} else {
			$minValue = $associations[0][0];
			$maxValue = $associations[sizeof($associations)-1][0];
		}

		$this->RegisterProfileInteger($name, $icon, $prefix, $suffix, $minValue, $maxValue, 0);

		foreach($associations as $association)
			IPS_SetVariableProfileAssociation($name, $association[0], $association[1], $association[2], $association[3]);
	}

}

?>
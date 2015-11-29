<?

class HomeKitService extends IPSModule {
	
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();
		
	}

	public function ApplyChanges() {
		// Diese Zeile nicht löschen
		parent::ApplyChanges();
		
		
	}

	public function GetValue(string $characteristic, string $homeKitValueType, $defaultValue, integer $homeKitEnumValueCount) {
		// value is directly configured in this instance config form, e.g. temperature display units
		if ($this->HasProperty($characteristic)) return $this->ReadPropertyInteger($characteristic);
		
		// not (yet) implemented in php module
		if (!$this->HasProperty($characteristic . "VariableId")) return $defaultValue;
		
		$variableId = $this->ReadPropertyInteger($characteristic . "VariableId");
		
		// variable not configured in this instance
		if ($variableId == 0) return $defaultValue;
		
		$variable = IPS_GetVariable($variableId);
		$value = $this->GetHomeKitValue($variable, $characteristic, $homeKitValueType, $homeKitEnumValueCount);
		return $value;
	}
	
	public function SetValue(string $characteristic, string $homeKitValueType, $homeKitValue) {
		// value is directly configured in this instance config form, e.g. temperature display units
		if ($this->HasProperty($characteristic)) return $this->SetProperty($characteristic, $homeKitValue);
		
		// not (yet) implemented in php module
		if (!$this->HasProperty($characteristic . "VariableId")) return;
		
		$variableId = $this->ReadPropertyInteger($characteristic . "VariableId");
		
		// variable not configured in this instance
		if ($variableId == 0) return;
		
		$variable = IPS_GetVariable($variableId);
		$variableObject = IPS_GetObject($variableId);
		$ipsValue = $this->GetIPSValue($variable, $characteristic, $homeKitValue, $homeKitValueType);
		
		// request associated action for the specified variable and value
		IPS_RequestAction($variableObject["ParentID"], $variableObject["ObjectIdent"], $ipsValue);
	}
	
	private function GetIPSValue($variable, $characteristic, $homeKitValue, $homeKitValueType) {
		$variableProfile = $variable['VariableProfile']
			? IPS_GetVariableProfile($variable['VariableProfile'])
			: NULL;
		
		$ipsValueString = "";
		switch($homeKitValueType) {
			case "Boolean":
				$ipsValueString = boolval($homeKitValue)
					? $this->ReadPropertyString($characteristic . "ValueTrue")
					: $this->ReadPropertyString($characteristic . "ValueFalse");
				break;
			case "Percent":
				$maxValue = $this->ReadPropertyFloat($characteristic . "MaxValue");
				$targetValue = ($homeKitValue / 100) * $maxValue;
				$ipsValueString = strval($targetValue);
				break;
			case "Integer":
			case "Float":
				$ipsValueString = strval($homeKitValue);
				break;
			case "Enum":
				$ipsValueString = $this->ReadPropertyString($characteristic . "Value" . $homeKitValue);
				break;
		}
		
		if ($ipsValueString == "") return $homeKitValue;
		
		switch ($variable["VariableType"]) {
			case 0: // boolean
				return boolval($ipsValueString);
			case 1: // integer
				return intval($ipsValueString);
			case 2: // float
				return $variableProfile && $variableProfile["Digits"] == 0
					? intval($ipsValueString)
					: floatval($ipsValueString);
			case 3: // string
				return $ipsValueString;
			default:
				return $homeKitValue;
		}
	}
	
	private function GetHomeKitValue($variable, $characteristic, $homeKitValueType, $homeKitEnumValueCount) {
		$value = GetValue($variable["VariableID"]);
		$valueString = strval($value);
		
		switch ($homeKitValueType) {
			case "Boolean":
				return $valueString == $this->ReadPropertyString($characteristic . "ValueTrue");
			case "Percent":
				$maxValue = $this->ReadPropertyFloat($characteristic . "MaxValue");
				$targetValue = ($value / $maxValue) * 100;
				return intval($targetValue);
			case "Float":
				return floatval($value);
			case "Int":
				return intval($value);
			case "Enum":
				if (!is_array($homeKitEnumValues)) return $value;
				
				for($i = 0; $i < $homeKitEnumValueCount; $i++) {
					$ipsValue = $this->ReadPropertyString($characteristic . "Value" . $i);
					if ($ipsValue == $valueString) return $i;
				}
				
				// value not found
				return $value;
			default:
				return $value;
		}
	}
	
	private function HasProperty($propertyName) {
		$configuration = json_decode(IPS_GetConfiguration($this->InstanceID));
		return array_key_exists($propertyName, $configuration);		
	}
	
	private function SetProperty($propertyName, $propertyValue) {
		$instanceId = $this->InstanceID;
		IPS_SetProperty($instanceId, $propertyName, $propertyValue);
		IPS_ApplyChanges($instanceId);		
	}
}

?>
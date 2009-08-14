<?
	function parseRules($rules){
		$a_rule = explode("\n", $rules);
		$ret_str = "var rules = new Array();\n";
		$i = 0;
		foreach($a_rule as $item){
			if($item != ""){
				$ret_str .= "rules[".$i."] = new Array();\n";
				$item = trim($item);
				$a_basic = explode(";", $item);
				foreach($a_basic as $b_item){
					$b_item = trim($b_item);
					if($b_item != ""){
						$b_b_item = explode("=", $b_item);
						if($b_b_item[1] != ""){
							$ret_str .= "rules[".$i."]['".$b_b_item[0]."'] = ".$b_b_item[1].";\n";
						}else{
							$ret_str .= "rules[".$i."]['".$b_b_item[0]."'] = -1;\n";
						}
					}
				}
			}
			$i++;
		}
		return $ret_str;
	}
?>
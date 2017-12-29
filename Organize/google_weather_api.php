<?php 

class weather
{
	public static $response;
	public static $location;
	public static $current;
	public static $nextdays;
	public static $error = false;
	
	public function weather()
	{
		$this->location = 'Maputo';
	}
	
	public function get()
	{
		if (empty($this->location)) {
			$this->error = true;
			return false;
		}
		$requestAddress = "http://www.google.com/ig/api?weather=".trim(urlencode($this->location))."&hl=en";
		$xml_str = file_get_contents($requestAddress,0);
		$xml = new SimplexmlElement($xml_str);
		if (!$xml->weather->problem_cause) {
			$this->response = $xml->weather;
			$this->parse();
		}else{
			$this->error = true;
		}
	}
	
	public function parse()
	{
		foreach($this->response as $item) {
			$this->current = $item->current_conditions;
			foreach($item->forecast_conditions as $new) {
				$this->nextdays[] = $new;		
			}	
		}
	}
	
	public function display()
	{
		foreach($this->nextdays as $new) {			
			echo '<div class="weatherIcon">';
				echo '<h2>'.$new->day_of_week['data'].'</h2>';
				echo '<img src="http://www.google.com/' .$new->icon['data'] . '"/><br/>';
				echo '<br />Min: '.$this->convert($new->low['data']).' &#8451;';
				echo '<br />Max: '.$this->convert($new->high['data']).' &#8451;';
			echo '</div>';			
		}	
	}
	
	public function convert($value, $unit = "C"){
		switch($unit){
			case "C":
				return number_format(($value - 32)/1.8);
			break;
			case "F":
				return round($value * 1.8 + 32);
			break;
			default:
				return $value;
				break;
		};
	}	
}
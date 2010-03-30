<?php

/**
 * JSON to XML Converter
 *
 * @author		Brent Burgoyne
 * @link		http://brentburgoyne.com
 */

class Json_to_xml
{
	private static $dom;
	
	public static function convert($json)
	{
		self::$dom = new DomDocument('1.0', 'utf-8');
		self::$dom->formatOutput = TRUE;
		
		// remove callback functions from JSONP
		if (preg_match('/(\{|\[).*(\}|\])/s', $json, $matches))
		{
			$json = $matches[0];
		}
		else
		{
			$json = '{"error": "JSON not formatted correctly"}';
		}
		
		$data = json_decode($json);
		$data_element = self::_process($data, self::$dom->createElement('data'));
		self::$dom->appendChild($data_element);
		return self::$dom->saveXML();
	}
	
	private static function _process($data, $element)
	{
		if (is_array($data))
		{
			foreach ($data as $item)
			{
				$item_element = self::_process($item, self::$dom->createElement('item'));
				$element->appendChild($item_element);
			}
		}
		elseif (is_object($data))
		{
			$vars = get_object_vars($data);
			foreach ($vars as $key => $value)
			{
				$key = self::_valid_element_name($key);
				$var_element = self::_process($value, self::$dom->createElement($key));
				$element->appendChild($var_element);
			}
		}
		else
		{
			$element->appendChild(self::$dom->createTextNode($data));
		}
		return $element;
	}
	
	private static function _valid_element_name($name)
	{
		$name = preg_replace('/^(.*?)(xml)([a-z])/i', '$3', $name);
		$name = preg_replace('/[^a-z0-9_\-]/i', '', $name);
		return $name;
	}
}
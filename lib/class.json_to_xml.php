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
}
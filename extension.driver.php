<?php
 
class Extension_dynamic_json extends Extension
{
	public function about()
	{
		return array
		(
			'name' => 'Dynamic JSON Datasource',
			'version' => '0.1',
			'release-date' => '2010-03-18',
			'author' => array
			(
				'name' => 'Brent Burgoyne',
				'website' => 'http://brentburgoyne.com'
			),
		   'description' => 'Extends functionality of the dynamic XML datasource to read JSON'
		);
	}
}

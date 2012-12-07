<?php
class MultisitseAnalyticsExtension extends DataExtension {
	
	static $db = array(
		'GoogleAnalyticsID' => 'Varchar'
	);

	public function updateSiteCMSFields(FieldList $fields){
		$fields->addFieldToTab('Root.Main', TextField::create('GoogleAnalyticsID', 'Google Analytics ID'));
	}	
}

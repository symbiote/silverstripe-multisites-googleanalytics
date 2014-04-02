<?php
class MultisiteAnalyticsExtension extends DataExtension {
	
	static $db = array(
		'GoogleAnalyticsID' => 'Varchar',
		'GoogleAnalyticsUseUniversalAnalytics' => 'Boolean',
		'GoogleAnalyticsCookieDomain' => 'Varchar(255)',
		'GoogleAnalyticsUseEventTracking' => 'Boolean',
	);

	public function updateSiteCMSFields(FieldList $fields){
		$fields->addFieldsToTab(
			'Root.GoogleAnalytics', 
			array(
				TextField::create('GoogleAnalyticsID', _t('MultisitseAnalyticsExtension.GOOGLEANALYTICSID', 'Google Analytics ID')),
					
				FieldGroup::create(
					CheckboxField::create('GoogleAnalyticsUseUniversalAnalytics', '')
				)
				->setTitle(_t('MultisitseAnalyticsExtension.USEUNIVERSALANALYTICS', 'Use Universal Analytics'))
				->setName('GAUniversalAnalytics')
				->setRightTitle(
					_t(
						'MultisitseAnalyticsExtension.UNIVERSALANALYTICSHELP', 
						"Universal Analytics is the new analytics implementation from Google. If your Google Analytics account is set up to use Universal Analytics, please check this box."
					)
				),
					
				TextField::create(
					'GoogleAnalyticsCookieDomain',
					_t('MultisitseAnalyticsExtension.NONSTANDARDCOOKIEDOMAIN', 'Non-Standard Cookie Domain')
				)
				->setRightTitle(
					_t(
						'MultisitseAnalyticsExtension.COOKIEDOMAINHELP',
						"If you want to use a non-standard cookie domain for your tracking, please enter it here. If this field is left empty, 'auto' will be used."
					)
				),
				
				FieldGroup::create(
					CheckboxField::create('GoogleAnalyticsUseEventTracking', '')
				)
				->setTitle(_t('MultisitseAnalyticsExtension.USEEVENTTRACKING', 'Use Event Tracking'))
				->setName('GAEventTracking')
				->setRightTitle(
					_t(
						'MultisitseAnalyticsExtension.EVENTTRACKINGHELP',
						"Activate this box if you want to track events like downloads and clicks on external, email and phone links. "
					)
				),
			)
		);
		$fields->fieldByName("Root.GoogleAnalytics")->setTitle(_t('MultisitseAnalyticsExtension.GOOGLEANALYTICSTAB', 'Google Analytics'));
	}	
}

<?php

namespace Symbiote\Multisites\GoogleAnalytics;

use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\ORM\DataExtension;

class MultisiteAnalyticsExtension extends DataExtension {
	
	private static $db = array(
		'GoogleAnalyticsID' => 'Varchar',
		'GoogleAnalyticsUseUniversalAnalytics' => DBBoolean::class,
		'GoogleAnalyticsCookieDomain' => 'Varchar(255)',
		'GoogleAnalyticsUseEventTracking' => DBBoolean::class,
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
				->setDescription(
					_t(
						'MultisitseAnalyticsExtension.UNIVERSALANALYTICSHELP', 
						"Universal Analytics is the new analytics implementation from Google. If your Google Analytics account is set up to use Universal Analytics, please check this box."
					)
				),
					
				TextField::create(
					'GoogleAnalyticsCookieDomain',
					_t('MultisitseAnalyticsExtension.NONSTANDARDCOOKIEDOMAIN', 'Non-Standard Cookie Domain')
				)
				->setDescription(
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
				->setDescription(
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

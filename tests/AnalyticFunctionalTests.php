<?php

namespace Symbiote\Multisites\GoogleAnalytics\Tests;

use SilverStripe\Core\Config\Config;
use SilverStripe\Control\Director;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Core\Kernel;
use Symbiote\Multisites\Model\Site;
use Symbiote\Multisites\Multisites;

class AnalyticFunctionalTests extends FunctionalTest {

	protected $usesDatabase = true;

	public function testAnalyticSnippets() {

		$_SERVER['HTTP_HOST'] = 'www.site.com';
		$this->logInWithPermission();

		// Create a site and home page.

		$site = Site::create(
			array(
				'Title' => 'Site',
				'Host' => 'www.site.com',
				'GoogleAnalyticsID' => 'UA-TESTING'
			)
		);
		$site->writeToStage('Stage');
		$site->publishRecursive();
		$home = \Page::create(
			array(
				'Title' => 'Home',
				'ParentID' => $site->ID
			)
		);
		$home->writeToStage('Stage');
		$home->publishRecursive();

		// The environment needs to be live for the snippets to appear.

		$kernel = Injector::inst()->get(Kernel::class);
		$kernel->setEnvironment('live');

		// Determine whether the correct snippet was included in the source.

		$response = $this->get($home->Link());
		$this->assertContains("_gaq.push(['_setAccount', 'UA-TESTING']);", $response->getBody());

		// Update the site to use universal analytics.

		$site->GoogleAnalyticsUseUniversalAnalytics = 1;
		$site->write();
		$site->publishRecursive();

		// The site object is currently cached, so we need to retrieve it again.

		Multisites::inst()->resetCurrentSite();

		// Determine whether the correct snippet was included in the source.

		$response = $this->get($site->Link());
		$this->assertContains("ga('create', 'UA-TESTING', 'auto');", $response->getBody());
	}

}

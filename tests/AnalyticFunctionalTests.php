<?php

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
		$site->publish('Stage', 'Live');
		$home = Page::create(
			array(
				'Title' => 'Home',
				'ParentID' => $site->ID
			)
		);
		$home->writeToStage('Stage');
		$home->publish('Stage', 'Live');

		// The environment needs to be live for the snippets to appear.

		$config = Config::inst();
		$config->update('Director', 'environment_type', 'live');

		// Determine whether the correct snippet was included in the source.

		$response = $this->get($home->Link());
		$this->assertContains("_gaq.push(['_setAccount', 'UA-TESTING']);", $response->getBody());

		// Update the site to use universal analytics.

		$site->GoogleAnalyticsUseUniversalAnalytics = 1;
		$site->writeToStage('Stage');
		$site->publish('Stage', 'Live');

		// The site object is currently cached, so we need to retrieve it again.

		Multisites::inst()->resetCurrentSite();

		// Determine whether the correct snippet was included in the source.

		$response = $this->get($site->Link());
		$this->assertContains("ga('create', 'UA-TESTING', 'auto');", $response->getBody());
	}

}

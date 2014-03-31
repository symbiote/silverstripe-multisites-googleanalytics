<?php

class MultisiteAnalyticsControllerExtension extends Extension {
	
	static $use_template = false;
	
	function ShowGoogleAnalytics() {
		$config = Multisites::inst()->getCurrentSite();
		if (
//			Director::isLive() &&
			$config->GoogleAnalyticsID && 
			strpos($_SERVER['REQUEST_URI'], '/admin') === false && 
			strpos($_SERVER['REQUEST_URI'], '/Security') === false && 
			strpos($_SERVER['REQUEST_URI'], '/dev') === false ) 
		{
			return true;
		}
		return false;
	}

	public function onAfterInit() {
	    
		if ($this->ShowGoogleAnalytics()) {
			$config = Multisites::inst()->getCurrentSite();
			
			if ($config->GoogleAnalyticsUseUniversalAnalytics) {
				
				//  universal analytics
				
				if (!self::$use_template) {
					
					// cookie domain
					$domain = 'auto';
					if ($config->GoogleAnalyticsCookieDomain && strlen(trim($config->GoogleAnalyticsCookieDomain)) > 0) {
						$domain = trim($config->GoogleAnalyticsCookieDomain);
					}
					
					// tracking code
					Requirements::insertHeadTags("
						<script type=\"text/javascript\">
							(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
							(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
							m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
							})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
							ga('create', '".$config->GoogleAnalyticsID."', '".$domain."');
							ga('send', 'pageview');
						</script>
					");
				}
				
				// event tracking
				if ($config->GoogleAnalyticsUseEventTracking) {
					Requirements::javascript('framework/thirdparty/jquery/jquery.js');
					Requirements::javascript('multisites-googleanalytics/javascript/event-tracking-universal.js');
				}
			
			} else {
				
				// asynchronous analytics
				
				if (!self::$use_template) {
					
					// cookie domain
					$domain = '';
					if ($config->GoogleAnalyticsCookieDomain && strlen(trim($config->GoogleAnalyticsCookieDomain)) > 0) {
						$domain = "_gaq.push(['_setDomainName', '".trim($config->GoogleAnalyticsCookieDomain)."']);";
					}
					
					// tracking code
					Requirements::insertHeadTags("
						<script type=\"text/javascript\">
							var _gaq = _gaq || [];
							_gaq.push(['_setAccount', '".$config->GoogleAnalyticsID."']);
							".$domain."
							_gaq.push(['_trackPageview']);
							(function() {
								var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
								ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
								var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
							})();
						</script>
					");
					
				}
				
				// event tracking
				if ($config->GoogleAnalyticsUseEventTracking) {
					Requirements::javascript('framework/thirdparty/jquery/jquery.js');
					Requirements::javascript('multisites-googleanalytics/javascript/event-tracking.js');
				}
				
			}
		}
				
	}	
}
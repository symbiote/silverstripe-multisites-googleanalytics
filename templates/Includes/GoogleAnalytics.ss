<% if CurrentSite.GoogleAnalyticsID %>
	<% if CurrentSite.GoogleAnalyticsUseUniversalAnalytics %>
		<script type="text/javascript">
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', '$CurrentSite.GoogleAnalyticsID', '<% if CurrentSite.GoogleAnalyticsCookieDomain %>$CurrentSite.GoogleAnalyticsCookieDomain<% else %>auto<% end_if %>');
			ga('send', 'pageview');
		</script>
	<% else %>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '$CurrentSite.GoogleAnalyticsID']);
			<% if CurrentSite.GoogleAnalyticsCookieDomain %>_gaq.push(['_setDomainName', '$CurrentSite.GoogleAnalyticsCookieDomain']);<% end_if %>
			_gaq.push(['_trackPageview']);
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	<% end_if %>
<% end_if %>
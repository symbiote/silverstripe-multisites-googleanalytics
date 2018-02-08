# silverstripe-multisites-googleanalytics

Adds Google Analytics tracking code to each multisite

## Requirements

* SilverStripe 4
* Multisites

## Usage

The default behaviour inserts the tracking code automatically in the page head.

The code only gets inserted in live mode.

### Using a template for the tracking code

If you want to use the template version of the tracking code (i.e. if you need 
to modify the tracking code for your project/theme) add the following YAML:

```yaml
MultisiteAnalyticsControllerExtension
  use_template: true
```

Use `<% include GoogleAnalytics %>` in your layout template to insert the tracking code.

Copy the template `multisites-googleanalytics/templates/Includes/GoogleAnalytics.ss` 
to your theme to make changes to the tracking code.

### Download tracking with custom controller urls (i.e. DMS module)

In order to track downloads that use a controller url instead of the direct file 
link (i.e. DMS module), please add the following attributes to the links:

```
class="download" data-extension="$Extension" data-filename="$FilenameWithoutID"
```

This will trigger the event tracking script to record the clicks.
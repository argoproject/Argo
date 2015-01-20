Setting up Largo with Ad Code Manager
=====================================

You will neeed a `DoubleClick for Publishers`_ or `Google AdSense`_ account set up before you begin this process.

Install the `Ad Codes Manager`_ plugin
-----------------------------------------

1. Go to Plugins > Add New
2. Search for "`Ad Codes Manager`_"
3. Install the plugin.
4. Activate the plugin

Note: If you use INN's hosted version of Largo you do not have the ability to install and activate plugins and will need to ask us to do this for you. Please `submit a service request <http://jira.investigativenewsnetwork.org/servicedesk/customer/portal/4>`_ and we'll be happy to help.

Create the ad codes
---------------------

#. Go to Tools > Ad Code Manager
#. Choose your publisher. This will be Adsense or Doubleclick for Publishers Async. Click "Save Options."
#. Create the ad codes.

DFP Async ad code fields:
	- Tag: where the code goes:
		- leaderboard is for 728x90 ads that go in the top of the page, in the header
		- sidebar is for 300x250 ads that go in a sidebar widget
		- mobile banner is for 300x50 ads that go at the top of mobile pages
	- Tag ID: Whatever you want to call this one
	- DFP ID: Your DFP ID
	- Tag name: If you have a tag name defined, use it here. Remember to escape forward slashes by replacing the forward slash with a double forward slash. For example, `foo/bar` becomes `foo//bar`
	- Conditionals: Don't set anything here unless you want to limit this ad's display to certain pages or to when conditions are met.


Google AdSense ad code fields:
	- Tag: Your name for this tag.
	- Tag ID: If you have a tag name defined, use it here. Remember to escape forward slashes by replacing the forward slash with a double forward slash. For example, `foo/bar` becomes `foo//bar`
	- Publisher ID: Your publisher ID

Enable the Leaderboard Ad Zone (optional)
-----------------------------------------

If you want to run ads at the top of the page, above your masthead:

#. Go to Appearance > Theme Options > Advanced
#. Check "Enable Optional Leaderboard Ad Zone"

Create the ad widgets
---------------------

#. Go to Appearance > Widgets
#. Add the "Header Ad Zone" widget to the appropriate sidebar.
	- For header widgets, add an "Ad Code Manager Ad Zone" widget to the "Header Ad Zone" sidebar.
	- For sidebar widgets, add an "Ad Code Manager Ad Zone" widget to the appropriate sidebar.

#. Configure the widget.
	Widget settings:
		- Title: Leave this blank
		- Choose Ad Zone: This is the ad that you're going to display.


	Check that the "Hidden on *X*" settings are appropriate for the type of ad you are running.
		- If you are showing the leaderboard, make sure to check the "Hidden on phones" box.
		- If you are showing the mobile banner, make sure to check the "Hidden on desktops" and "Hidden on tablets" boxes.
		- You may wish to hide sidebar ads on tablets and desktops, similar to on mobile.

	You **must** define a widget for each ad zone that you have created ad codes for.

If your ads are not showing up, check that your ad widgets are set to be visible. Try resizing your browser window to be wider or narrower.

.. _DoubleClick for Publishers: https://www.google.com/doubleclick/publishers/welcome/
.. _Google AdSense: https://www.google.com/adsense/start/
.. _Ad Codes Manager: https://wordpress.org/plugins/ad-code-manager/

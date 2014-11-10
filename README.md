# Template Version 1.1 Updates
* Widgets are now supported
* ACF functionality on subpages is now available in shortcode form
* New events/calendaring system
* Fixed drop-down menu width bug
* Fixed other minor CSS bugs
* Removed TGM plugin requirement/recommendation service

## Requirements
All three **ACF** plugins found in the theme's `plugins` directory must be installed. Significant portions of the theme rely on the functionality provided by these plugins.

## Theme Update Info
The latest version of the template supports several oft requested features, namely widgets and shortcode support. Shortcodes are supported throughout all templates, and widgets are supported on the default page template.

The **Calendar App** has now been replaced with a more robust and much more featureful system. It is no longer a plugin, and it is availble in the **Events** section within the Dashboard. The events system has been completely re-engineered, but it outputs the same content to your front-end code. You will need to re-enter your calendar feeds. You can now edit imported event data from a feed, and you can also manually add an event.

The **RSS App** is no longer provided by default. A replacement system is in the works. For continued support of current RSS App users, the plugin can still be found in the theme's `plugins` directory. To re-enable the RSS App as a configurable option on the homepage template, you will need to uncomment lines 134-236 in `includes/custom_fields.php`.

## Getting Started
General site-wide settings can be found in **NC State Theme Options** in the left-hand nav of the admin pages. There you can choose the type of NC State "Brick" to use and also add tracking code for services such as Google Analytics.

You also have the option to provide the username of your social media accounts. The theme supports Facebook, Twitter, Instagram, and YouTube; however, not all accounts are required. The social networks to which you provide a username will automatically populate in your site’s footer. The social content will also be available in the social media module on the homepage if you choose to include it on that page.

The NC State Theme Options menu also lets you set other footer content such as resource links and your unit’s contact information. You can also set metadata for your site. Metadata is additional data that search engines and social networks can use to better describe your site’s content. The search engine description is usually the snippet of text displayed beneath your site’s URL in search engine results. The social media title, teaser text, and image are used for social networks such as Facebook when a URL from your website is shared on social media. The metadata provided in NC State Theme Options will automatically apply to every page on our site. If desired, you can override that content on a page-by-page basis. Providing site-wide and/or page-by-page metadata is not required, but it generally helps with search results.

Once you have Wordpress installed and the theme activated, you will need to setup your homepage and menu structure.

You can **create a homepage** by going to ``Pages->Add New``. In the right-hand menu select “Homepage” as the page’s template. You can then configure the page’s modules. Click Publish (or Update) to save the page.

To assign that page as your homepage, visit ``Appearance->Customize``. In the “Static Front Page” section of the menu you can choose which page will be the homepage. You should select the page that you just created.

Next you can **configure your site’s menus** in ``Appearance->Menus``. First a menu must be created, and then it must be assigned to a theme location. Theme locations correlate the main menu (i.e. ‘Header’) and each top-level page. The Header location will either display horizontally at the top of every page or in the left-hand nav on every page. The location depends upon the layout configuration set in ‘NC State Theme Options.’

Menus can also be created for each top-level page. This is not needed on the left-hand nav layout. Top-level page menus will display on the respective page and all of its subpages on the left-hand side of the page. If no menu is created and assigned to a top-level page, your content will span the full width of the page.

## Calendar
The NC State theme is capable of pulling data from outside calendars and displaying it on your website. XML feeds from Google Calendar and ActiveData are currently supported.

**Important:** The default feeds provided by Google Calendar and ActiveData need to be slightly maniupated.

If using a Google Calendar XML feed, `/basic` at the end of the URL needs to be repalced with `/full`. This alteration causes the feed to provide additional information that can be displayed on your website.

If using an ActiveData feed, it can be hard to find the XML feed URL. Instead you can select the iCal URL and then replace `ical` with `xml` in the URL to change the feed's format.

More than one source calendar feed can be provided; enter each URL on a newline. Your website will refresh the calendar feed every hour. By default new events are added as a draft and require human intervention to be published. The checkbox on the `Settings` allows you to auto-publish new events from your calendar feeds. Visiting the `Events->Settings` page will manually refresh your feeds.

## Homepage Modules
You can create your homepage from six different potential modules. These include:

* Body Copy
* Callout
* Calendar/Events
* Social Media
* Announcements/Resources

These modules can be added by clicking **Add Row**. Select the desired module, and then follow the on-screen instructions.

## News Page
You can create news posts under “Posts” in the left-hand menu. To display a page with all of your latest posts, create a new Page and use the “News” page template. This page will aggregate all of your recent posts in one page. You can then place this page wherever you would like in your site’s menu system.

## Subpages
Subpages can be created using two different page templates: **Default Template** and **Page with Nav**. The only difference between these two pages is that **Default Template** supports widgets in a righthand sidebar. **Page with Nav** does not support widgets, but it does support navigation in the lefthand sidebar. If no lefthand nav is provided, your content will span the full width of the page.

The default page template is a general purpose page that can serve as a subpage template. To help your subpage not just be large blocks of text, you can also add images within your body text. You can also intersperse callouts within your body copy. Callouts can be created using either custom fields or shortcodes. These callouts should include no more than 1-2 sentences, and they should highlight important or important additional information that is related to the page’s overall content.

## Callout Shortcode
The syntax to create a callout shortcode is as follows:

```
[cross_section img_src='' img_pos='' link='' link_txt='' link_url='' color='']
<!-- HTML text content here -->
[/cross_section]
```
### Attributes

| Attribute | Description | Default Value |
| --------- | ----------- | ------------- |
| `img_src`	| Optional. If you would like to use an image, enter the file URL here. Images must be part the Wordpress media library. You can find the file URL to the right of the image in the media library. | `null` |
| `img_pos` | Optional. If you do include an image, use this attribute to define the image's position. Options are `left` or `right`. | `left` |
| `link` | Optional. Should the cross section be a link? Options are `true` or `false`. | `false` |
| `link_txt` | Optional. Add text to the end of the cross section that underlines on hover. This is where you would add something like "Learn More". Requires `link='true'`. | Empty string|
| `link_url` | Required when `link='true'`. Link URL. | Empty string |
| `color` | Optional. Sets the background color of the cross section. Options are: red, reynolds-red, orange, yellow, green, blue, indigo, gray-lighter, gray-light, gray-dark, and gray-darker. | green |
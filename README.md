# NC State Campus Theme -- Version 2.0 Beta

## Theme Update Info
If updating from a 1.x version of the theme, it is **strongly** recommended that you make a backup of your DB before installing this update.  Some settings are not yet migratable.

This version of the theme was previously being developed under version number 1.2.  It has since been bumped to version 2.0 to denote the major changes from version 1.x of the theme.

## Getting Started
General site-wide settings can be found in `Appearance -> Theme Options`. There you can choose the type of NC State "Brick" to use and also provide your Google Analytics ID, Google Custom Search Engine ID.

You also have the option to provide the username of your social media accounts. The theme supports Facebook, Twitter, Instagram, and YouTube; however, not all accounts are required.  The social networks to which you provide a username will automatically populate in your site’s footer. The social content will also be available in the social media module on the homepage if you choose to include it on that page.

API keys for social networks can also be set in Theme Options.  Key information for each network that will be used on the homepage must be provided.  Documentation for finding the API keys will be provided later.

The Theme Options menu also lets you set other footer content such as resource links and your unit’s contact information.

The WP SEO plugin by Yoast is recommended to set metadata. Metadata is additional data that search engines and social networks can use to better describe your site’s content. The search engine description is usually the snippet of text displayed beneath your site’s URL in search engine results. The social media title, teaser text, and image are used for social networks such as Facebook when a URL from your website is shared on social media.

Once you have Wordpress installed and the theme activated, you will need to setup your homepage and menu structure.

You can **create a homepage** by going to `Pages->Add New`. In the right-hand menu select `Homepage` as the page’s template. You can then configure the page’s modules. Click Publish (or Update) to save the page.  Note that preview may not work correctly until the page has been published.

To assign that page as your homepage, visit `Appearance->Customize`. In the `Static Front Page` section of the menu you can choose which page will be the homepage. You should select the page that you just created.

Next you can **configure your site’s menus** in `Appearance->Menus`. First a menu must be created, and then it must be assigned to a theme location. Theme locations correlate the main menu (i.e. ‘Header’) and each top-level page. The Header location will display horizontally at the top of every page.

## Calendar
The NC State theme interfaces with the (NC State Events plugin)[https://github.ncsu.edu/ncstate-ucomm/ncstate-events] to pull in data from outside calendars and display it on your website. Public Google calendars and the University's ActiveData calendar are currently supported.

Within `Events -> Settings` you can specify external calendars.

Google Calendar can be used, and you *must* only provide the calendar's ID, not its entire URL.

If using an ActiveData feed, it can be hard to find the XML feed URL. Instead you can select the iCal URL and then replace `ical` with `xml` in the URL to change the feed's format.

More than one source calendar feed can be provided; enter each URL/calendar ID on a newline. Your website will refresh the calendar feed every hour. By default new events are added as a draft and require human intervention to be published. The checkbox on the `Settings` page allows you to auto-publish new events from your calendar feeds. Visiting the `Events->Settings` page will manually refresh your feeds.

## Homepage Modules
You can create your homepage from six different potential modules:

* Body Copy
* Callout
* Calendar/Events
* Social Media
* Announcements/Resources

These modules can be added by clicking `Add Row`. Select the desired module, and then follow the on-screen instructions.

## Subpages
Subpages should use the `Default Template` page template.  The `Default Template` supports widgetized left and right columns.  The page's main content will expand or contract as necessary for these columns.  The callout shortcode (below) can be used to provide additional visual interest to your subpages.

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
| `img_id`	| Optional. If you would like to use an image, enter the image's ID here. Images must be part the Wordpress media library. You can find the ID in the address bar when viewing the image in the media library. | `null` |
| `img_pos` | Optional. If you do include an image, use this attribute to define the image's position. Options are `left` or `right`. | `left` |
| `link` | Optional. Should the cross section be a link? Options are `true` or `false`. | `false` |
| `link_txt` | Optional. Add text to the end of the cross section that underlines on hover. This is where you would add something like "Learn More". Requires `link='true'`. | Empty string|
| `link_url` | Required when `link='true'`. Link URL. | Empty string |
| `color` | Optional. Sets the background color of the cross section. Options are: red, reynolds-red, orange, yellow, green, blue, indigo, gray-lighter, gray-light, gray-dark, and gray-darker. | green |

## Licensing
This premium theme is for use by the NC State campus community.  The theme includes ACF PRO.  ACF PRO is only availble for use within this theme.  ACF PRO use outside of the theme is a copyright violation.
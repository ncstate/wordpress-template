# NC State Campus Theme -- Version 2.0 Release Candidate

## Theme Update Info
If updating from a 1.x version of the theme, it is **strongly** recommended that you make a backup of your DB before installing this update.  Some settings are not yet migratable.

This version of the theme was previously being developed under version number 1.2.  It has since been bumped to version 2.0 to denote the major changes from version 1.x of the theme.

## Who is this theme for?
The general NC State WordPress template is best suited for smaller sites.  For example, it provides a good foundation for personal faculty or research labs sites.  It can also meet the needs of smaller campus units that only need a basic web presence.  Groups and units can also use the theme to create a site for internal resources and procedures.

The theme is not for departments, colleges, and larger units.  Such campus entities would be better served by a more robust theme that can better support the amount and type of information that needs to be communicated.

## How to get started
The WordPress theme can be run in a variety of hosting environments; however, if you have limited/no web development resources, [wordpress.ncsu.edu](http://wordpress.ncsu.edu) will be the easiest solution to use.  Two different tiers of service are available on wordpress.ncsu.edu.  For most sites, the free tier will easily meet your needs.

Some larger units and colleges on campus may have their own hosted solution.  Check with your unit’s communicator if you are unsure.

## Strategy Behind a Website
Simply putting information on a website does not mean that it will be found by your intended audience.  A site needs to be easily navigable without confusing or overwhelming a user.

If large amounts of text are necessary on one page, increase the readability of the page by using subheaders to organize related information.  Many web “readers” tend to only skim a webpage.  Using subheaders helps your audience more efficiently find and consume the information that they need.

## Menus
Menus in WordPress are created/updated by going to `Appearance -> Menus`.  Creating and editing WordPress menus is not hard, but there are several potentially confusing nuances for first-time users.

You can create multiple menus within WordPress, but they will not necessarily display until they are assigned to a theme location.  Once a menu is assigned to a theme location, it will be displayed in the corresponding area of your site.

You can add both pages on site by selecting them on the left side of the menus admin page.  You can also add specific URLs to external sites/resources.

Additional general information about WordPress menus is available.  Note: the video tutorial will not correspond to your site’s theme, but the basic functionality is the same.

## Theme Options
This WordPress theme has specific customizable settings.  These settings can be accessed by going to `Appearance -> Theme Options`.

In general, Theme Options allows you provide Google Analytics tracking codes, specify social media account names (if available), and customize your site’s footer.

Most settings within Theme Options are documented on the Theme Options page.

## Site Title
Your site title is what is displayed in your site’s header and footer.  This can be updated by going to Settings -> General.

## Creating the Homepage
To create a homepage, add a new page by going to Pages -> Add New.  On the right side of the window in the ‘Page Attributes’ section, choose “Homepage” from the ‘Template’ dropdown.

You can create your homepage from six different potential modules:

* Body Copy
* Callout
* Calendar/Events
* Social Media
* Announcements/Resources

These modules can be added by clicking `Add Row`. Select the desired module, and then follow the on-screen instructions.

To specify that this newly created page should be used as the site’s homepage, go to `Settings -> Reading`.  Within the `Front page displays` section, choose `A static page`.  In the `Front page` dropdown select the page that you just created.  Click `Save Changes` at the bottom of the page.

## Pages
Pages generally form the bulk of your site.  A page generally consists of a title and then body content.  Pages generally consist of static content that is consistently accessed.

The default page template supports widgetized left and right columns.  The page's main content will expand or contract as necessary for these columns.  The [callout shortcode](#callout-shortcode) can be used to provide additional visual interest to your subpages.

Often times it is useful to nest pages according to your site’s sitemap/menu structure.  For example, “Undergraduate” and “Graduate” might be nested beneath the “Academics” top-level page of your site.  On back-end admin screens for the “Undergraduate” and “Graduate” pages, you will probably want to set “Academics” as the `Parent` page in the `Page Attributes` section.

## Posts
Posts generally consist of news, announcements, and other timely content.

The structure of a post is similar to that of a page.  A title and body content are the basic components of a post.  However, you can also categorize posts.  This allows you to group posts with similar content.  For example, you may want a category for “Awards and Honors” and another category for “Research Grants”.

## Calendar/Events
The NC State theme interfaces with the [NC State Events plugin](https://github.ncsu.edu/ncstate-ucomm/ncstate-events) to pull in data from outside calendars and display it on your website. Public Google calendars and the University's ActiveData calendar are currently supported.

Within `Events -> Settings` you can specify external calendars.

Google Calendar can be used, and you *must* only provide the calendar's ID, not its entire URL.

If using an ActiveData feed, it can be hard to find the XML feed URL. Instead you can select the iCal URL and then replace `ical` with `xml` in the URL to change the feed's format.

More than one source calendar feed can be provided; enter each URL/calendar ID on a newline. Your website will refresh the calendar feed every hour. By default new events are added as a draft and require human intervention to be published. The checkbox on the `Settings` page allows you to auto-publish new events from your calendar feeds. Visiting the `Events->Settings` page will manually refresh your feeds.

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

## Additional Support
Additional help is available by emailing [web_feedback@ncsu.edu](mailto:web_feedback@ncsu.edu).

## Licensing
This premium theme is for use by the NC State campus community.  The theme includes ACF PRO.  ACF PRO is only availble for use within this theme.  ACF PRO use outside of the theme is a copyright violation.

Getting Started
==================

Start by dropping the files into your project. You might choose a directory called `/includes` in the root of your site for example.

##Dependencies

We highly recommend you use Composer to load dependencies. You may choose to load the dependencies some other way, but those methods will not be covered here.

The official documentation for installing Composer can be found [here](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx), but below is a TL;DR version for those on Linux/Unix/OSX. (Sorry Windows, no shortcuts here.)

Assuming you have cURL and PHP installed, run the following from inside your `/ncstate-social-sdk` directory.

```
// Installs Composer into ncstate-social-sdk/bin directory
$ curl -sS https://getcomposer.org/installer | php -- --install-dir=bin

// Excecutes dependency installation to ncstate-social-sdk/vendor
$ php bin/composer.phar install
```

If you have installed Composer globally for this or any other project, you can just run
```
$ composer install
```

##Configuration

Now that you have all the dependencies installed, you can set your configuration. Copy the contents of `config-sample.php` to a file called 'config.php' and edit the contents according to the instructions. Here is a quick list of what you might need.

###Facebook
* App ID
* App Secret

###Twitter
* Consumer Key
* Consumer Secret
* Oauth Token
* Oauth Token Secret

###Instagram
* Instagram App Key

Lastly, just include the following in whatever files need to access to social networks.
```php
require 'PATH_TO_FILE/ncstate-social-sdk.php';
```

##Functions

####Get Facebook Posts
```php
getFacebook(string $username [, int $num = 15, bool $raw = false ] );
```
If `$raw` is TRUE, returns an array of graph objects to be further parsed with API functions. If `$raw` is FALSE, returns an array of posts in the following format.
```php
Array (
    [0] => Array (
        ["time"] => 1422280943,
        ["message"] => "Inc. Magazine names Raleigh one of “Seven Better Cities for Startups. 
                        Why? Besides Research Triangle Park bringing development and opportunity 
                        into the area, it names NC State and its solution-driven research as a 
                        major reason.",
        ["url"] => "http://thinkand.do/O0Y2vL"
    )
)
```

####Get Twitter Tweets
```php
getTwitter(string $username [, int $num = 10 ] );
```
Returns an array of tweets in the following format.
```php
Array (
    [0] => Array (
        ["time"] => 1422126036,
        ["description"] => "RT @PackWomensBball: Six years ago today, we lost a wonderful person and
                        friend in Kay Yow. We love you, Coach.",
        ["url"] => "https://twitter.com/NCState/status/559063232040542210",
        ["media"] => Object // Twitter media object. See link below
    )
)
```
For more on twitter media objects, see their [docs](https://dev.twitter.com/overview/api/entities#obj-media).

####Get Instagram
```php
getInstagram(string $username [, int $num = 10, string $tag = false ] );
```
Returns an array of Instagram photos in the following format. Adding a `$tag` parameter will filter the results accordingly.
```php
Array (
    [0] => Array (
        ["time"] => 1422029941,
        ["img"] => "http://scontent-a.cdninstagram.com/hphotos-xaf1/t51.2885-15/e15/10919206_834981036560516_1206033178_n.jpg",
        ["url"] => "http://instagram.com/p/yM_GivGI17/"
    )
)
```




# URL Explorer

> Get all informations you need from an URL

[![Latest Stable Version](https://poser.pugx.org/ludovicm67/url-explorer/v/stable)](https://packagist.org/packages/ludovicm67/url-explorer)
[![Total Downloads](https://poser.pugx.org/ludovicm67/url-explorer/downloads)](https://packagist.org/packages/ludovicm67/url-explorer)
[![License](https://poser.pugx.org/ludovicm67/url-explorer/license)](https://packagist.org/packages/ludovicm67/url-explorer)

## Installation

Just run the following command: `composer require ludovicm67/url-explorer` to add it to your PHP project!

## How to use it?

Running the following code:

```php
<?php

require('./vendor/autoload.php'); // include here composer autoloader!

use ludovicm67\Url\Explorer\Explorer;

echo new Explorer("https://github.com/ludovicm67/php-url-explorer");

```

will give you something like:

```json
{
    "code": 200,
    "title": "ludovicm67/php-url-explorer",
    "description": "php-url-explorer - Get all informations you need from an URL",
    "img": {
        "url": "https://avatars3.githubusercontent.com/u/9420561?v=3&s=400",
        "width": 250,
        "height": 250,
        "mime": "image/png"
    },
    "type": "small",
    "url": {
        "request": "https://github.com/ludovicm67/php-url-explorer",
        "final": "https://github.com/ludovicm67/php-url-explorer",
        "base": "github.com"
    },
    "updated": "2017-06-05T20:11:27+00:00"
}
```

## What can I get for informations?

You can get by default all the following informations from a URL:

-   `code`: the HTTP code from the request
-   `title`: the title of the page
-   `description`: the webpage description
-   `img`: an image representing the webpage; if equals `null`, no image available, else it will give you:
    -   `url`: the url of the image
    -   `width`: the width of the image
    -   `height`: the height of the image
    -   `mime`: the mime type of the image
-   `type`: the type of _card_ to display. It can have the following values:
    -   `image`: the URL is an image
    -   `none`: no information found
    -   `basic`: only a title and maybe a description was found (no image)
    -   `small`: an image was found, but it's small
    -   `large`: if the image has a width >= 400 and height >= 200
-   `url`: here are some useful URL:
    -   `request`: the URL used for the request
    -   `final`: the final URL, after some redirections
    -   `base`: the hostname of the final URL
-   `updated`: the time at the UTC timezone when the informations were fetched (can be useful if you cache the results somewhere)

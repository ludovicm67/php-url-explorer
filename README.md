# URL Explorer

> Get all informations you need from an URL

[![Latest Stable Version](https://poser.pugx.org/ludovicm67/url-explorer/v/stable)](https://packagist.org/packages/ludovicm67/url-explorer)
[![Total Downloads](https://poser.pugx.org/ludovicm67/url-explorer/downloads)](https://packagist.org/packages/ludovicm67/url-explorer)
[![Latest Unstable Version](https://poser.pugx.org/ludovicm67/url-explorer/v/unstable)](https://packagist.org/packages/ludovicm67/url-explorer)
[![License](https://poser.pugx.org/ludovicm67/url-explorer/license)](https://packagist.org/packages/ludovicm67/url-explorer)
[![Monthly Downloads](https://poser.pugx.org/ludovicm67/url-explorer/d/monthly)](https://packagist.org/packages/ludovicm67/url-explorer)
[![Daily Downloads](https://poser.pugx.org/ludovicm67/url-explorer/d/daily)](https://packagist.org/packages/ludovicm67/url-explorer)
[![composer.lock](https://poser.pugx.org/ludovicm67/url-explorer/composerlock)](https://packagist.org/packages/ludovicm67/url-explorer)

## Installation

Just run the following command : `composer require ludovicm67/url-explorer` to add it to your PHP project!

## How to use it?

Running the following code :

```php
<?php

require('./vendor/autoload.php'); // include here composer autoloader!

use ludovicm67\Url\Explorer\Explorer;

echo new Explorer("https://github.com/ludovicm67/php-url-explorer");

```

will give you something like :

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
    }
}
```

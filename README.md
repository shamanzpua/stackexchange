# Apirequest

Request to stackexchange api

## Installation

Add to composer.json
````
 "require": {
    "shamanzpua/stackexchange": "*"
 }
````
## Usage

#### Usage:

```php
<?php
use shamanzpua\stackexchange\Stackoverflow;

$stackoverfow = new Stackoverflow("YOUR_API_KEY");

$answers =  $stackoverfow->grab("some search string");
```

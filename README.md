# TDD Twitter Client example

A simple wrapper/twitter client example built using TDD and https://twitteroauth.com/

Just add the package `arzola/twitter-library` to your composer dependencies and start using it.

You have to inject the TwitterOauth Object

### Example fetching tweets 😎

```php
<?php
use Arzola\TwitterClient;
use Abraham\TwitterOAuth\TwitterOAuth;

$client = new TwitterClient(new TwitterOAuth('consumer_key', 'consumer_secret', 'access_token',
                                                     'access_token_secret'));
$tweets = $client->fetch();

//You are done you got an a array of tweets with the ['text'] key;
```

### Example posting a tweet

```php
<?php 

use Arzola\TwitterClient;
use Abraham\TwitterOAuth\TwitterOAuth;

$client = new TwitterClient(new TwitterOAuth('consumer_key', 'consumer_secret', 'access_token',
                                                                                 'access_token_secret'));

//Post a tweet
$client->tweet('hello world');

//Done.

```

### Tests

To run the integrated unit tests please run: 

> vendor/bin/phpunit

#### TODO

* Convert it into a Laravel Package
* Pass Twitter API config through a configuration file.
* Abstract the Oauth Interface to be able to use any adapter.
<?php

use Arzola\TwitterClient;
use PHPUnit\Framework\TestCase;

class TwitterClientTest extends TestCase
{

    private $fakeTweets;
    private $oauthClient;

    public function setUp()
    {
        parent::setUp();
        $this->fakeTweets = [];
        $this->fakeTweets[0] = new stdClass();
        $this->fakeTweets[0]->text = 'Hello World';
        $this->fakeTweets[1] = new stdClass();
        $this->fakeTweets[1]->text = 'Hello World 2';

        $this->oauthClient = Mockery::mock('TwitterOAuth');
        $this->oauthClient->shouldReceive('__construct')->with('consumer_key', 'consumer_secret', 'access_token',
            'access_token_secret');
    }

    public function test_if_tweets_are_fetched()
    {
        $this->oauthClient->shouldReceive('get')->with('statuses/user_timeline',
            ['screen_name' => 'eclecticbro', 'count' => 10, 'include_rts' => 1])->andReturn($this->fakeTweets);

        $client = new TwitterClient($this->oauthClient);

        $tweets = $client->fetch('eclecticbro');

        $this->assertEquals('Hello World', $tweets[0]['text']);
        $this->assertEquals('Hello World 2', $tweets[1]['text']);
    }

    public function test_if_tweet_is_posted_and_retrieved()
    {
        $this->oauthClient->shouldReceive('post')->with('statuses/update', ['status' => '🙈']);
        $this->oauthClient->shouldReceive('getLastHttpCode')->andReturn(200);

        $client = new TwitterClient($this->oauthClient);

        $posted = $client->tweet('🙈');

        $this->assertTrue($posted);

        $this->fakeTweets[2] = new stdClass();
        $this->fakeTweets[2]->text = '🙈';

        $this->oauthClient->shouldReceive('get')->with('statuses/user_timeline',
            ['screen_name' => 'eclecticbro', 'count' => 3, 'include_rts' => 1])->andReturn($this->fakeTweets);

        $clientAfter = new TwitterClient($this->oauthClient);

        $tweets = $clientAfter->fetch('eclecticbro', 3);

        $this->assertEquals('🙈', $tweets[2]['text']);
    }
}

<?php namespace Arzola;

class TwitterClient
{
    private $oauthClient;

    public function __construct($oauthClient)
    {
        $this->oauthClient = $oauthClient;
    }

    public function fetch($user, $count = 10)
    {
        $tweets = $this->oauthClient->get("statuses/user_timeline",
            ["screen_name" => $user, "count" => $count, 'include_rts' => 1]);
        $processedTweets = [];
        foreach ($tweets as $tweet) {
            $processedTweets[] = ['text' => $tweet->text];
        }
        return $processedTweets;
    }

    public function tweet($msg)
    {
        $this->oauthClient->post('statuses/update', ['status' => $msg]);
        return $this->oauthClient->getLastHttpCode() == 200;
    }
}
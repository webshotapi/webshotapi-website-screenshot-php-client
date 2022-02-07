<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Webshotapi\Client\Exceptions\WebshotApiClientException;
use Webshotapi\Client\WebshotApiClient;

try{
    $API_CLIENT = '7815696ecbf1c96e6894b779456d330e7815696ecbf1c96e6894b779456d330d';
    $client = new WebshotApiClient($API_CLIENT);

    // Create new project
    $new_project = $client->projects()->create([
        "name" => "Test project",
        "status" => "active"
    ])->json();


    // Add urls to project
    $new_urls = $client->projectsUrl()->create(
        $new_project->id,
        [
            "urls" => [
                "https://example.com",
                "https://example.com/test"
            ],
            "params" => [
                "image_type" => "png",
                "remove_modals" => true,
                "ads" => true,
                "width" => 960,
                "thumbnail_width" => 256,
                "height" => 1440,
                "no_cache" =>  true,
            ]
        ]
    )->json();


    // Get urls from project
    $urls = $client->projectsUrl()->list(
        $new_project->id,
        1
    )->json();

    echo "Urls list:\n";
    foreach($urls->urls as $url) {
       echo 'id: '.$url->id.' link: '.$url->url."\n";
    }

    echo "Page: " . $urls->pagination->current_page . '/' . $urls->pagination->pages;

}catch(WebshotApiClientException $e) {
    echo 'Client error';
    echo $e->getMessage();
}catch(\Exception $e) {
    echo 'Internal error';
    echo $e->getMessage();
}
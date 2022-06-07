<?php

namespace App\Adapters;

use App\Http\Controllers\Controller;
use App\Models\BullhornHttpQuery;
use GuzzleHttp\Exception\GuzzleException;
use jonathanraftery\Bullhorn\Rest\Client as bullhornClient;

class BullhornAdapter extends Controller
{
    protected bullhornClient $api;

    public function __construct()
    {
        $this->api = new bullhornClient();
    }

    public function executeQuery(BullhornHttpQuery $query): array
    {
        try {
            // Get Bullhorn data
            $response = $this->api->rawRequest(
                $query->getMethod(),
                $query->getUrl(),
                [
                    'query' => $query->getWheres() . "&" . $query->getFields() . "&count=500"
                ]
            );
        }

        catch (GuzzleException $e) {
            // todo handle, log and throw BullhornApiException (to make) or something like that
        }

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        if (null === $jsonResponse) {
            // TODO THROW EXCEPTION, Bullhorn response cannot be decoded
        }

        // Transform Bullhorn data to internal model
        return $jsonResponse;
    }
}

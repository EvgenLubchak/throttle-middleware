<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Middleware;

use Tests\TestCase;
use Illuminate\Http\Response;

class ThrottlingTest extends TestCase
{

    public function testThrottlingAttemptSuccess()
    {
        $response = $this->getJson(
            route('test.throttling')
        );
        $response->assertOk();
    }

    public function testThrottlingAttemptsFailed()
    {
        for ($requestCnt = 0; $requestCnt <= config('throttling.requests'); $requestCnt++) {
            $response = $this->withSession(['test' => true])->getJson(
                route('test.throttling')
            );
            if ($requestCnt === config('throttling.requests')) {
                $response->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);
            } else {
                $response->assertOk();
            }
        }
    }
}

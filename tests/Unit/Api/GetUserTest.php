<?php

namespace Tests\Unit\Api;

use tests\TestCase;

class GetUserTest extends TestCase
{
    public function getUserTest() {
        $response = $this->json('GET', '/api/1/getUser');


    }
}
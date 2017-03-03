<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WebTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testHomepage()
    {
        $this->visit('/')
             ->see('Usage example');
    }
}

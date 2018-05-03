<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {

        $this->assertTrue(true);
    }
    
        public function testProfileHasUserId()
    {
        $this->visit('/')
             ->see('qienmunity')
             ->dontSee('henk');
    }
}
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page()
    {
        $this->actingAs($this->user());
        $response = $this->get('/');
        //$x = $this->view('/');
        $response->assertSeeText('welcome from home');

        //$response->assertStatus(200);
    }

    public function test_contact_page()
    {
        $this->actingAs($this->user());
        $response = $this->view('contact');
        $response->assertSeeText('hello from contact');
    }

}

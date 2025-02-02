<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BusinessControllerTest extends TestCase
{
    public function testRegisterBusinessForm()
    {
        $response = $this->get('/business/register');

        $response->assertStatus(200);
        $response->assertViewIs('business_register');
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_signup_need_password_confirmation()
    {
        // send a fake request to the signup endpoint
        $response = $this->postJson('/api/signup', [
            "name" => "John Doe",
            "email" => "test@admin.com",
            "password" => "password",
            ]);
        // assert that the response is 200
        $response->assertStatus(422);
        // check if has the error message
        //get json response
        $json = $response->json();
        $this->assertArrayHasKey("password", $json["errors"]);
    }
    public function test_signup_works()
    {
        // send a fake request to the signup endpoint
        $response = $this->postJson('/api/signup', [
            "name" => "John Doe",
            "email" => $this->email,
            "password" => "password",
            "password_confirmation" => "password"
            ]);
        // assert that the response is 200
        $response->assertStatus(200);
        // status message should be success
        $this->assertEquals("success", $response->json()["status"]);
    }
    public function test_login_requires_email_and_password()
    {
        // send a fake request to the signup endpoint
        $response = $this->postJson('/api/login', [
            "email" => "",
            "password" => ""
            ]);
        // assert that the response is 422
        $response->assertStatus(422);
        // check if has the error message
        //get json response
        $json = $response->json();
        $this->assertArrayHasKey("password", $json["errors"]);
    }
    public function test_login_works()
    {
        // send a fake request to the signup endpoint
        $response = $this->postJson('/api/login', [
            "email" => $this->email,
            "password" => "password",
            ]);
        // assert that the response is 200
        $response->assertStatus(200);
        // status message should be success
        $this->assertEquals("success", $response->json()["status"]);
        // check if the response has the token
        $this->assertArrayHasKey("token", $response->json()["data"]);
        // save the token
        $this->token = $response->json()["data"]["token"];
    }
            
    //bootup
    public function setUp(): void
    {
        parent::setUp();
        //create a user
        $this->email = "test".rand(1, 1000)."@admin.com";
    }

}

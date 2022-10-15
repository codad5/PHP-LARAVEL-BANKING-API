<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
   public User $user;
   public String $token;
   public string|int $account_number;
   public string $account_name;
   public string $account_type;
   public function test_account_route_requires_authentication()
   {
       // send a fake request to the signup endpoint
       $response = $this->postJson('/api/account', [
           "name" => "John Doe",
           "email" => ""
        ]);
        // assert that the response is 401
        $response->assertStatus(401);
    }
    //try to create an account without authentication
    public function test_create_account_requires_authentication()
    {
        // send a fake request to the signup endpoint
        $response = $this->postJson('/api/account', [
            "name" => "John Doe",
            "email" => $this->user->email,
            "password" => "password",
            "password_confirmation" => "password",
            "account_type" => "savings"
         ]);
         // assert that the response is 401
         $response->assertStatus(401);
    }
    //try to create an account with authentication
    public function test_create_account_works()
    {
        // send a fake request to the signup endpoint with bearer token
        $response = $this->postJson('/api/account', [
            "name" => "John Doe",
            "password" => $this->password,
            "password_confirmation" => $this->password,
            "account_type" => $this->account_type
         ], [
             "Authorization" => "Bearer " . $this->token
         ]);
         // assert that the response is 200
         $response->assertStatus(200);
         // status message should be success
         $this->assertEquals("success", $response->json()["status"]);
    }
    public function test_get_balance_works()
    {
        // send a fake request to the signup endpoint with bearer token
        $response = $this->postJson('/api/account/balance',[
            "account_number" => $this->account_number,
            "password" => $this->password
         ], [
             "Authorization" => "Bearer " . $this->token
         ]);
         // assert that the response is 200
         $response->assertStatus(200);
         // status message should be success
         $this->assertEquals("success", $response->json()["status"]);
    }
    //bootup
    public function setUp(): void
    {
        parent::setUp();
        $this->user = $user = User::factory()->create();
        $this->email = $user->email;
        $this->password = "password";
        $this->account_number = rand(1000000000, 9999999999);
        $this->account_type = "savings";

 
        $this->token = $user->createToken("Api Token Of".$user->name)->plainTextToken;
    }
}

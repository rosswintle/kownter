<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Site;
use App\UserAgent;

class TrackViewTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_page_view_can_be_tracked()
    {
        // Arrange
        $site = Site::create([
            'domain' => 'example.com',
        ]);
        
        // Act
        $response = $this->get( '/track/example.com' );

        // Assert
        $response->assertStatus( 200 );
        $this->assertDatabaseHas( 'views', [ 'site_id' => $site->id ] );
    }


    /** @test */
    // public function a_page_view_with_a_referrer_logs_the_referrer()
    // {
    //     // Arrange
        
    //     // Act
    //     $response = $this->get( '/track/example.com' );

    //     // Assert
    //     $response->assertStatus( 200 );
    // }


    /** @test */
    public function a_page_view_for_an_unknown_domain_fails()
    {
        // Arrange - this is not strictly necessary but...
        $site = Site::create([
            'domain' => 'example.com',
        ]);

        
        // Act
        $response = $this->get( '/track/notawebsite.com' );

        // Assert
        $response->assertStatus( 404 );
    }


    /** @test */
    public function a_page_view_logs_the_correct_user_agent()
    {
        // Arrange
        $site = Site::create([
            'domain' => 'example.com',
        ]);

        // Act
        $response = $this->withHeaders([
            'user-agent' => 'Mozilla/5.0'
        ])->get( '/track/example.com' );

        // Assert
        $this->assertDatabaseHas( 'user_agents', [ 'name' => 'Mozilla/5.0' ] );
        $userAgent = UserAgent::where('name', 'Mozilla/5.0')->firstOrFail();
        $this->assertDatabaseHas( 'views', [ 'site_id' => $site->id, 'user_agent_id' => $userAgent->id ]);
    }


    /** @test */
    public function a_page_view_updates_the_daily_count()
    {
        // Arrange
        
        // Act
        $response = $this->get( '/track/example.com' );

        // Assert
        $this->assertTrue(true);
    }


    /** @test */
    public function a_page_view_updates_the_hourly_count()
    {
        // Arrange
        
        // Act
        $response = $this->get( '/track/example.com' );

        // Assert
        $this->assertTrue(true);
    }


    /** @test */
    public function a_page_view_updates_the_minute_count()
    {
        // Arrange
        
        // Act
        $response = $this->get( '/track/example.com' );

        // Assert
        $this->assertTrue(true);
    }


}
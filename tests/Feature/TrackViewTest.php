<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Site;

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
        $this->assertDatabaseHas( 'views', [ 'site' => $site->id ] );
    }


    /** @test */
    public function a_page_view_with_a_referrer_logs_the_referrer()
    {
        // Arrange
        
        // Act
        $response = $this->get( '/track/example.com' );

        // Assert
        $this->assertTrue(true);
    }


    /** @test */
    public function a_page_view_for_an_unknown_domain_fails()
    {
        // Arrange
        
        // Act
        $response = $this->get( '/track/notawebsite.com' );

        // Assert
        $this->assertTrue(true);
    }


    /** @test */
    public function a_page_view_logs_the_correct_user_agent()
    {
        // Arrange
        
        // Act
        $response = $this->get( '/track/example.com' );

        // Assert
        $this->assertTrue(true);
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

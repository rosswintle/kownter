<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Site;
use App\UserAgent;
use App\Page;
use App\ReferringDomain;

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
        $response = $this->withHeaders([
            'referer' => 'https://example.com/test-page',
        ])->get( '/track' );

        // Assert
        $response->assertStatus( 200 );
        $this->assertDatabaseHas( 'views', [ 'site_id' => $site->id ] );
    }


    /** @test */
    public function a_page_view_with_no_referer_fails()
    {
        // Arrange
        $site = Site::create([
            'domain' => 'example.com',
        ]);
        
        // Act
        $response = $this->get( '/track' );

        // Assert
        $response->assertStatus( 400 );
    }


    /** @test */
    public function a_page_view_for_an_unknown_domain_fails()
    {
        // Arrange - this is not strictly necessary but...
        $site = Site::create([
            'domain' => 'example.com',
        ]);

        // Act
        $response = $this->withHeaders([
            'referer' => 'https://failure.com/',
        ])->get( '/track/' );

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
            'referer' => 'https://example.com/',
            'user-agent' => 'Mozilla/5.0'
        ])->get( '/track' );

        // Assert
        $this->assertDatabaseHas( 'user_agents', [ 'name' => 'Mozilla/5.0' ] );
        $userAgent = UserAgent::where('name', 'Mozilla/5.0')->firstOrFail();
        $this->assertDatabaseHas( 'views', [ 'site_id' => $site->id, 'user_agent_id' => $userAgent->id ]);
    }


    /** @test */
    public function a_page_view_sends_a_CORS_header()
    {
        // Arrange
        $site = Site::create([
            'domain' => 'example.com',
        ]);

        // Act
        $response = $this->withHeaders([
            'Referer' => 'https://example.com/test-page',
            'Origin' => 'https://example.com'
        ])->get('/track');

        // Assert
        $response->assertHeader('Access-Control-Allow-Origin', 'https://example.com');
    }


    /** @test */
    public function a_page_view_logs_the_correct_referring_page()
    {
        // Arrange
        $site = Site::create([
            'domain' => 'example.com',
        ]);

        // Act
        $response = $this->withHeaders([
            'user-agent' => 'Mozilla/5.0',
            'referer' => 'https://example.com/test-page',
        ])->get( '/track' );

        // Assert
        $this->assertDatabaseHas( 'pages', [
            'url' => 'https://example.com/test-page',
            'site_id' => $site->id,
        ] );
        $page = Page::where('url', 'https://example.com/test-page')->firstOrFail();
        $this->assertDatabaseHas( 'views', [
            'site_id' => $site->id,
            'page_id' => $page->id ] );
    }

    /** @test */
    public function a_page_view_with_a_specified_referer_saves_it()
    {
        // Arrange
        $site = Site::create([
            'domain' => 'example.com',
        ]);

        // Act
        $response = $this->withHeaders([
            'user-agent' => 'Mozilla/5.0',
            'referer' => 'https://example.com/test-page',
        ])->get('/track?referrer=' . urlencode('https://google.com/'));

        // Assert
        $this->assertDatabaseHas('referring_domains', [ 'domain' => 'google.com' ] );
        $referringDomain = ReferringDomain::where('domain', 'google.com')->firstOrFail();
        $this->assertDatabaseHas('views', [
            'referring_domain_id' => $referringDomain->id,
        ]);
    }


    /** @test */
    // public function a_page_view_updates_the_daily_count()
    // {
    //     // Arrange
        
    //     // Act
    //     $response = $this->get( '/track/example.com' );

    //     // Assert
    //     $this->assertTrue(true);
    // }


    // /** @test */
    // public function a_page_view_updates_the_hourly_count()
    // {
    //     // Arrange
        
    //     // Act
    //     $response = $this->get( '/track/example.com' );

    //     // Assert
    //     $this->assertTrue(true);
    // }


    // /** @test */
    // public function a_page_view_updates_the_minute_count()
    // {
    //     // Arrange
        
    //     // Act
    //     $response = $this->get( '/track/example.com' );

    //     // Assert
    //     $this->assertTrue(true);
    // }


}

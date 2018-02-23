<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Site;
use App\UserAgent;
use App\Page;
use App\View;
use App\User;

class AdminPageViewTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_page_views()
    {
        // Arrange
        $site = Site::create([
            'domain' => 'example.com',
        ]);
        $userAgent = UserAgent::create([
            'name' => 'Mozilla/5.0',
        ]);
        $page = Page::create([
            'url' => 'http://example.com/blah',
        ]);
        $view = View::make();
        $view->site()->associate($site);
        $view->page()->associate($page);
        $view->user_agent()->associate($userAgent);
        $view->save();

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'testing123',
        ]);
        // Act
        $response = $this->actingAs( $user )->get('/site/' . $site->id . '/');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('http://example.com/blah');
        $response->assertSee('Mozilla/5.0');
    }

}

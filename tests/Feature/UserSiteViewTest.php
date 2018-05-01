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

class UserSiteViewTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_a_site_they_own()
    {
        // Arrange
        $site = factory(\App\Site::class)->create();
        $userAgent = factory(\App\UserAgent::class)->create();
        $page = factory(\App\Page::class)->create();

        $view = factory(\App\View::class)->make();
        $view->site()->associate($site);
        $view->page()->associate($page);
        $view->user_agent()->associate($userAgent);
        $view->save();

        $user = factory(\App\User::class)->create();

        $site->owner()->associate($user);
        $site->save();

        // Act
        $response = $this->actingAs( $user )->get('/site/' . $site->id . '/');

        // Assert
        $response->assertStatus(200);
        $response->assertSee( $page->url );
        $response->assertSee( $userAgent->name );
    }

    /** @test */
    public function a_user_can_not_view_a_site_they_dont_own()
    {
        // Arrange
        $site = factory(\App\Site::class)->create();
        $userAgent = factory(\App\UserAgent::class)->create();
        $page = factory(\App\Page::class)->create();

        $view = factory(\App\View::class)->make();
        $view->site()->associate($site);
        $view->page()->associate($page);
        $view->user_agent()->associate($userAgent);
        $view->save();

        $owner = factory(\App\User::class)->create();
        $nonOwner = factory(\App\User::class)->create();

        $site->owner()->associate($owner);
        $site->save();

        // Act
        $response = $this->actingAs( $nonOwner )->get('/site/' . $site->id . '/');

        // Assert
        $response->assertStatus(401);
    }

    /** @test */
    public function a_guest_can_not_view_page_views()
    {
        // Arrange

        // Act

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function a_user_can_only_see_their_own_sites_listed_in_the_selector()
    {
        // Arrange

        // Act

        // Assert
        $this->assertTrue(true);        
    }
}

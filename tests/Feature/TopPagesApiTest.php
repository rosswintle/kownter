<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopPagesApiTest extends TestCase
{
    use RefreshDatabase;

    private function addViewsToSite( $site, $pageId, $state, $quantity ) {
        $site->views()
            ->saveMany(
                factory(\App\View::class, $quantity)
                    ->states($state)
                    ->create( ['page_id' => $pageId] )
            );

    }

    /* TODO: Should this really be a unit test? Maybe refactor. */
    /** @test */
    public function the_top_pages_this_week_api_returns_correct_results()
    {
        // Arrange
        $user = factory(\App\User::class)->create();

        $site = factory(\App\Site::class)->create();

        $pages = factory(\App\Page::class, 5)->create();
        $site->pages()->saveMany($pages);

        // Add 10 views for page 1 this week
        $this->addViewsToSite($site, $pages[1]->id, 'thisWeekButNotToday', 10);
        // Add 8 views for page 1 this month (but not this week)
        $this->addViewsToSite($site, $pages[1]->id, 'thisMonthButNotThisWeek', 8);
        // Add 5 views for page 2 this week
        $this->addViewsToSite($site, $pages[2]->id, 'thisWeekButNotToday', 5);
        // Add 2 views for page 2 this month (but not this week)
        $this->addViewsToSite($site, $pages[2]->id, 'thisMonthButNotThisWeek', 2);
        
        // Act
        $response = $this
            ->actingAs($user)
            ->get('/api/v1/site/' . $site->id . '/top-pages/week');

        // Assert
        $response->assertStatus(200);

        $responseObject1 = [ 'id' => (string)$pages[1]->id, 'views_count' => 10 ];
        $responseObject2 = [ 'id' => (string)$pages[2]->id, 'views_count' => 5  ];
        $response->assertJson( [ $responseObject1, $responseObject2 ] );
    }


    /** @test */
    public function the_top_pages_api_returns_correct_results()
    {
        // Arrange
        $user = factory(\App\User::class)->create();

        $site = factory(\App\Site::class)->create();

        $pages = factory(\App\Page::class, 5)->create();
        $site->pages()->saveMany($pages);

        // Add 10 views for page 1 this week
        $this->addViewsToSite($site, $pages[1]->id, 'thisWeekButNotToday', 10);
        // Add 8 views for page 1 this month (but not this week)
        $this->addViewsToSite($site, $pages[1]->id, 'thisMonthButNotThisWeek', 8);
        // Add 5 views for page 2 this week
        $this->addViewsToSite($site, $pages[2]->id, 'thisWeekButNotToday', 5);
        // Add 2 views for page 2 this month (but not this week)
        $this->addViewsToSite($site, $pages[2]->id, 'thisMonthButNotThisWeek', 2);
        
        // Act
        $response = $this
            ->actingAs($user)
            ->get('/api/v1/site/' . $site->id . '/top-pages');

        // Assert
        $response->assertStatus(200);

        $responseObject1 = ['id' => (string)$pages[1]->id, 'views_count' => 18];
        $responseObject2 = ['id' => (string)$pages[2]->id, 'views_count' => 7];
        $response->assertJson([$responseObject1, $responseObject2]);
    }

}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Devi;
use App\Models\Article;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviArticlesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_devi_articles()
    {
        $devi = Devi::factory()->create();
        $article = Article::factory()->create();

        $devi->articles()->attach($article);

        $response = $this->getJson(route('api.devis.articles.index', $devi));

        $response->assertOk()->assertSee($article->title);
    }

    /**
     * @test
     */
    public function it_can_attach_articles_to_devi()
    {
        $devi = Devi::factory()->create();
        $article = Article::factory()->create();

        $response = $this->postJson(
            route('api.devis.articles.store', [$devi, $article])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $devi
                ->articles()
                ->where('articles.id', $article->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_articles_from_devi()
    {
        $devi = Devi::factory()->create();
        $article = Article::factory()->create();

        $response = $this->deleteJson(
            route('api.devis.articles.store', [$devi, $article])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $devi
                ->articles()
                ->where('articles.id', $article->id)
                ->exists()
        );
    }
}

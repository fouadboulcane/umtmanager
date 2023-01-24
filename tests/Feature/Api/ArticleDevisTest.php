<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Devi;
use App\Models\Article;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleDevisTest extends TestCase
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
    public function it_gets_article_devis()
    {
        $article = Article::factory()->create();
        $devi = Devi::factory()->create();

        $article->devis()->attach($devi);

        $response = $this->getJson(route('api.articles.devis.index', $article));

        $response->assertOk()->assertSee($devi->start_date);
    }

    /**
     * @test
     */
    public function it_can_attach_devis_to_article()
    {
        $article = Article::factory()->create();
        $devi = Devi::factory()->create();

        $response = $this->postJson(
            route('api.articles.devis.store', [$article, $devi])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $article
                ->devis()
                ->where('devis.id', $devi->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_devis_from_article()
    {
        $article = Article::factory()->create();
        $devi = Devi::factory()->create();

        $response = $this->deleteJson(
            route('api.articles.devis.store', [$article, $devi])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $article
                ->devis()
                ->where('devis.id', $devi->id)
                ->exists()
        );
    }
}

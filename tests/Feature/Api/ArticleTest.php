<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Article;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
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
    public function it_gets_articles_list()
    {
        $articles = Article::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.articles.index'));

        $response->assertOk()->assertSee($articles[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_article()
    {
        $data = Article::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.articles.store'), $data);

        $this->assertDatabaseHas('articles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_article()
    {
        $article = Article::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'unit' => $this->faker->text(255),
            'quantity' => $this->faker->randomNumber,
        ];

        $response = $this->putJson(
            route('api.articles.update', $article),
            $data
        );

        $data['id'] = $article->id;

        $this->assertDatabaseHas('articles', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_article()
    {
        $article = Article::factory()->create();

        $response = $this->deleteJson(route('api.articles.destroy', $article));

        $this->assertModelMissing($article);

        $response->assertNoContent();
    }
}

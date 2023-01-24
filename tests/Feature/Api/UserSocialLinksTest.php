<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SocialLink;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSocialLinksTest extends TestCase
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
    public function it_gets_user_social_links()
    {
        $user = User::factory()->create();
        $socialLinks = SocialLink::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.social-links.index', $user)
        );

        $response->assertOk()->assertSee($socialLinks[0]->facebook);
    }

    /**
     * @test
     */
    public function it_stores_the_user_social_links()
    {
        $user = User::factory()->create();
        $data = SocialLink::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.social-links.store', $user),
            $data
        );

        unset($data['facebook']);
        unset($data['twitter']);
        unset($data['linkedin']);
        unset($data['google_plus']);
        unset($data['digg']);
        unset($data['youtube']);
        unset($data['pinterest']);
        unset($data['instagram']);
        unset($data['github']);
        unset($data['tumblr']);
        unset($data['tiktok']);
        unset($data['user_id']);

        $this->assertDatabaseHas('social_links', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $socialLink = SocialLink::latest('id')->first();

        $this->assertEquals($user->id, $socialLink->user_id);
    }
}

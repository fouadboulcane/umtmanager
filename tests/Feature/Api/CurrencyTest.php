<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Currency;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyTest extends TestCase
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
    public function it_gets_currencies_list()
    {
        $currencies = Currency::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.currencies.index'));

        $response->assertOk()->assertSee($currencies[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_currency()
    {
        $data = Currency::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.currencies.store'), $data);

        $this->assertDatabaseHas('currencies', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_currency()
    {
        $currency = Currency::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'symbol' => $this->faker->currencyCode,
        ];

        $response = $this->putJson(
            route('api.currencies.update', $currency),
            $data
        );

        $data['id'] = $currency->id;

        $this->assertDatabaseHas('currencies', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_currency()
    {
        $currency = Currency::factory()->create();

        $response = $this->deleteJson(
            route('api.currencies.destroy', $currency)
        );

        $this->assertModelMissing($currency);

        $response->assertNoContent();
    }
}

<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Currency;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_currencies()
    {
        $currencies = Currency::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('currencies.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.currencies.index')
            ->assertViewHas('currencies');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_currency()
    {
        $response = $this->get(route('currencies.create'));

        $response->assertOk()->assertViewIs('app.currencies.create');
    }

    /**
     * @test
     */
    public function it_stores_the_currency()
    {
        $data = Currency::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('currencies.store'), $data);

        $this->assertDatabaseHas('currencies', $data);

        $currency = Currency::latest('id')->first();

        $response->assertRedirect(route('currencies.edit', $currency));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_currency()
    {
        $currency = Currency::factory()->create();

        $response = $this->get(route('currencies.show', $currency));

        $response
            ->assertOk()
            ->assertViewIs('app.currencies.show')
            ->assertViewHas('currency');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_currency()
    {
        $currency = Currency::factory()->create();

        $response = $this->get(route('currencies.edit', $currency));

        $response
            ->assertOk()
            ->assertViewIs('app.currencies.edit')
            ->assertViewHas('currency');
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

        $response = $this->put(route('currencies.update', $currency), $data);

        $data['id'] = $currency->id;

        $this->assertDatabaseHas('currencies', $data);

        $response->assertRedirect(route('currencies.edit', $currency));
    }

    /**
     * @test
     */
    public function it_deletes_the_currency()
    {
        $currency = Currency::factory()->create();

        $response = $this->delete(route('currencies.destroy', $currency));

        $response->assertRedirect(route('currencies.index'));

        $this->assertModelMissing($currency);
    }
}

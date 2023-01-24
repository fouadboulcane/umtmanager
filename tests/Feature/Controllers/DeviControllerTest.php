<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Devi;

use App\Models\Client;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviControllerTest extends TestCase
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
    public function it_displays_index_view_with_devis()
    {
        $devis = Devi::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('devis.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.devis.index')
            ->assertViewHas('devis');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_devi()
    {
        $response = $this->get(route('devis.create'));

        $response->assertOk()->assertViewIs('app.devis.create');
    }

    /**
     * @test
     */
    public function it_stores_the_devi()
    {
        $data = Devi::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('devis.store'), $data);

        unset($data['status']);

        $this->assertDatabaseHas('devis', $data);

        $devi = Devi::latest('id')->first();

        $response->assertRedirect(route('devis.edit', $devi));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_devi()
    {
        $devi = Devi::factory()->create();

        $response = $this->get(route('devis.show', $devi));

        $response
            ->assertOk()
            ->assertViewIs('app.devis.show')
            ->assertViewHas('devi');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_devi()
    {
        $devi = Devi::factory()->create();

        $response = $this->get(route('devis.edit', $devi));

        $response
            ->assertOk()
            ->assertViewIs('app.devis.edit')
            ->assertViewHas('devi');
    }

    /**
     * @test
     */
    public function it_updates_the_devi()
    {
        $devi = Devi::factory()->create();

        $client = Client::factory()->create();

        $data = [
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'tax' => array_rand(array_flip(['dt', 'tva_19%', 'tva_9%']), 1),
            'tax2' => array_rand(array_flip(['dt', 'tva_19%', 'tva_9%']), 1),
            'note' => $this->faker->text,
            'status' => array_rand(
                array_flip(['accepted', 'denied', 'draft', 'sent']),
                1
            ),
            'client_id' => $client->id,
        ];

        $response = $this->put(route('devis.update', $devi), $data);

        unset($data['status']);

        $data['id'] = $devi->id;

        $this->assertDatabaseHas('devis', $data);

        $response->assertRedirect(route('devis.edit', $devi));
    }

    /**
     * @test
     */
    public function it_deletes_the_devi()
    {
        $devi = Devi::factory()->create();

        $response = $this->delete(route('devis.destroy', $devi));

        $response->assertRedirect(route('devis.index'));

        $this->assertModelMissing($devi);
    }
}

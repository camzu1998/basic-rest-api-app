<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\Car;

class CarApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_car()
    {
        $response = $this->postJson(route('api.cars.store'), [
            'name' => 'Toyota',
            'type' => 'big',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('cars', [
            'name' => 'Toyota',
            'type' => 'big',
        ]);
    }

    /** @test */
    public function user_can_update_car()
    {
        $car = Car::factory()->create();

        $response = $this->putJson(route('api.cars.update', $car), [
            'name' => 'Toyota Supra Mk4',
            'type' => 'small',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'name' => 'Toyota Supra Mk4',
            'type' => 'small',
        ]);
    }

    /** @test */
    public function user_can_delete_car()
    {
        $car = Car::factory()->create();

        $response = $this->deleteJson(route('api.cars.destroy', $car));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }

    /** @test */
    public function user_can_list_cars()
    {
        Car::factory()->count(3)->create();

        $response = $this->getJson(route('api.cars.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3);
    }

    /** @test */
    public function user_can_get_first_big_car_and_name_is_uppercase()
    {
        $response = $this->getJson(route('api.cars.showFirst', 'medium'));
        $response->assertStatus(Response::HTTP_NOT_FOUND);

        Car::factory()->create(['type' => 'small', 'name' => 'Skoda']);
        Car::factory()->create(['type' => 'big', 'name' => 'Toyota']);

        $response = $this->getJson(route('api.cars.showFirst', 'big'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'name' => 'TOYOTA'
            ]);
    }

    /** @test */
    public function user_can_get_first_small_car_and_name_is_lowercase()
    {
        Car::factory()->create(['type' => 'big', 'name' => 'Volvo']);
        Car::factory()->create(['type' => 'small', 'name' => 'BMW']);

        $response = $this->getJson(route('api.cars.showFirst', 'small'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'name' => 'bmw'
            ]);
    }

    /** @test */
    public function user_can_delete_first_big_car()
    {
        $response = $this->getJson(route('api.cars.showFirst', 'medium'));
        $response->assertStatus(Response::HTTP_NOT_FOUND);

        Car::factory()->create(['type' => 'small']);
        Car::factory()->create(['type' => 'big']);

        $response = $this->deleteJson(route('api.cars.destroyFirst', 'big'));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('cars', ['type' => 'big']);
    }
}

<?php

use Tests\TestCase;
use App\Models\Movies;
use Database\Seeders\MoviesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MoviesControllerTest extends TestCase
{
  use RefreshDatabase;

  public function testIndexMethodReturnsMoviesWhenAvailable()
  {
    Movies::factory()->count(5)->create();

    $response = $this->json('GET', '/movies');

    $response->assertStatus(200)
      ->assertJson([
        "response" => true,
        "message" => "Movies found",
      ])
      ->assertJsonCount(5, 'details');
  }

  public function testIndexMethodReturns204WhenNoMoviesAvailable()
  {

    $response = $this->json('GET', '/movies');

    $response->assertStatus(204);
  }

  public function testStoreMethodCreatesMovieSuccessfully()
  {
    $imageData = base64_encode(file_get_contents(public_path('upload/images/oppenheimer.jpg')));

    $response = $this->json('POST', '/movies', [
      'title' => 'Oppenheimer',
      'description' => 'Oppenheimer adalah film biografi sejarah Amerika Serikat tahun 2023 yang disutradarai oleh Christopher Nolan dan diproduseri oleh Christopher Nolan, Emma Thomas dan Charles Roven.',
      'rating' => 9.0,
      'image' => $imageData,
    ]);

    $response->assertStatus(201)
      ->assertJson([
        "response" => true,
        "message" => "Movie created successfully",
      ]);

    $this->assertDatabaseHas('movies', ['title' => 'Oppenheimer']);
  }

  public function testShowMethodReturnsMovieIfExists()
  {
    $movie = Movies::factory()->create();

    $response = $this->json('GET', "/movies/{$movie->id}");

    $response->assertStatus(200)
      ->assertJson([
        "response" => true,
        "message" => "Movie found",
      ]);
  }

  public function testShowMethodReturns404WhenMovieDoesNotExist()
  {
    $response = $this->json('GET', "/movies/999");

    $response->assertStatus(404)
      ->assertJson([
        "response" => false,
        "message" => "Movie not found",
      ]);
  }

  public function testUpdateMethodUpdatesMovieSuccessfully()
  {
    $movie = Movies::factory()->create();

    $response = $this->json('PUT', "/movies/{$movie->id}", [
      'title' => 'Oppenheimer 2',
      'description' => 'This is an updated movie Oppenheimer.',
      'rating' => 7.8,
    ]);

    $response->assertStatus(200)
      ->assertJson([
        "response" => true,
        "message" => "Movie updated successfully",
      ]);

    // Add additional assertions to check if the movie is updated in the database
    $this->assertDatabaseHas('movies', ['id' => $movie->id, 'title' => 'Oppenheimer 2']);
  }

  public function testUpdateMethodReturns404WhenMovieDoesNotExist()
  {
    $response = $this->json('PUT', "/movies/999", [
      'title' => 'Oppenheimer 3',
      'description' => 'This is an updated movie Oppenheimer.',
      'rating' => 7.8,
    ]);

    $response->assertStatus(404)
      ->assertJson([
        "response" => false,
        "message" => "Movie not found",
      ]);
  }

  public function testDestroyMethodDeletesMovieSuccessfully()
  {
    $movie = Movies::factory()->create();

    $response = $this->json('DELETE', "/movies/{$movie->id}");

    $response->assertStatus(200)
      ->assertJson([
        "response" => true,
        "message" => "Movie deleted successfully",
      ]);

    // Add additional assertions to check if the movie is deleted from the database
    $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
  }

  public function testDestroyMethodReturns404WhenMovieDoesNotExist()
  {
    $response = $this->json('DELETE', "/movies/999");

    $response->assertStatus(404)
      ->assertJson([
        "response" => false,
        "message" => "Movie not found",
      ]);
  }
}

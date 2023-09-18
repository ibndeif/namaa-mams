<?php

namespace Database\Factories;

use App\Enum\ArticleStatus;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        $statuses = ArticleStatus::cases();
        $randomStatus = $statuses[rand(0, count($statuses) - 1)];
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $this->faker->paragraph(),
            'image' => 'https://source.unsplash.com/collection/1346951/1000x500?sig=1',
            'author_id' => User::factory(),
            'status' => $randomStatus->value
        ];
    }
}

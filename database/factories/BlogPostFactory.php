<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->paragraphs(5,true),
            'created_at' => $this->faker->dateTimeBetween('-30 days' ,'now'),
        ];
    }

    public function titleContent()     //state function
    {
        return $this->state(function (array $attributes){
            return [
                'title' => 'new title',
                'content' => 'new post content'
            ];
        });
    }
}

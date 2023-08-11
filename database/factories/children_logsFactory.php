<?php

namespace Database\Factories;

use App\Models\children_logs;
use Illuminate\Database\Eloquent\Factories\Factory;

class children_logsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = children_logs::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'key' => $this->faker->word,
        'date' => $this->faker->word,
        'total' => $this->faker->randomDigitNotNull,
        'list_id' => $this->faker->word,
        'failed_list_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

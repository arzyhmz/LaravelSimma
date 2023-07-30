<?php

namespace Database\Factories;

use App\Models\chat_logs;
use Illuminate\Database\Eloquent\Factories\Factory;

class chat_logsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = chat_logs::class;

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
        'list_id' => $this->faker->text,
        'failed_list_id' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

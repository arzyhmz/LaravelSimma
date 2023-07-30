<?php

namespace Database\Factories;

use App\Models\wab_history;
use Illuminate\Database\Eloquent\Factories\Factory;

class wab_historyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = wab_history::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'partner_id' => $this->faker->word,
        'room_id' => $this->faker->word,
        'chat' => $this->faker->text,
        'status' => $this->faker->word,
        'update_date' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

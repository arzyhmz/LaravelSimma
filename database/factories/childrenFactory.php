<?php

namespace Database\Factories;

use App\Models\children;
use Illuminate\Database\Eloquent\Factories\Factory;

class childrenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = children::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'partner_id' => $this->faker->word,
        'pledge_id' => $this->faker->word,
        'paid_thru' => $this->faker->word,
        'name' => $this->faker->word,
        'idn' => $this->faker->word,
        'status' => $this->faker->word,
        'message' => $this->faker->word,
        'udpate_date' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

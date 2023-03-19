<?php

namespace Database\Factories;

use App\Models\contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class contactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'contact_email' => $this->faker->word,
        'phone_number' => $this->faker->word,
        'status' => $this->faker->word,
        'date_of_birth' => $this->faker->word,
        'source' => $this->faker->word,
        'sponsor_id' => $this->faker->word,
        'name_see' => $this->faker->word,
        'motivation_code' => $this->faker->word,
        'join_date' => $this->faker->word,
        'sp' => $this->faker->word,
        'title' => $this->faker->word,
        'en' => $this->faker->word,
        'pl' => $this->faker->word,
        'dr' => $this->faker->word,
        'email_sponsor' => $this->faker->word,
        'need_tp_post' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

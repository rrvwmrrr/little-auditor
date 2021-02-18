<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rrvwmrrr\Auditor\Tests\Support\Models\FailingAuditable;

class FailingAuditableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FailingAuditable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

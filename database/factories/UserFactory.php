<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'message' => $this->faker->text,
            'facebook' => $this->faker->text,
            'twitter' => $this->faker->text,
            'github' => $this->faker->text,
            'name' => $this->faker->name(),
            'slug' => $this->faker->word(),
            'email' => $this->faker->unique()->safeEmail(),
            'title_job' => $this->faker->text,
            'tel' => '+541136179324',
            'address' => $this->faker->address,
            'excerpt' =>$this->faker->text,
            'email_verified_at' => now(),
            'password' => '$2a$12$f7N1aPeCyN2hmzIVQZy4LumV31xb4FREriM5cCmRlBLrzALnJiH/S', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withPersonalTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name.'\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }
}
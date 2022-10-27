<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Provider\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

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
            'username' => $this->faker->userName,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt(123), // password
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user){

            $this->faker->addProvider(new PicsumProvider($this->faker));
            $this->faker->addProvider(new LoremSpaceProvider($this->faker));

            try {

                $url = $this->faker->loremSpace(LoremSpaceProvider::CATEGORY_FACE,storage_path('temp'));

                $user->addMedia($url)
                    ->toMediaCollection('avatars');

            }catch (\Exception $exception){
                dump($exception->getMessage());
            }
        });
    }


}

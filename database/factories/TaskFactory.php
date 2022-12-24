<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;



    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'    =>$this->faker->name(),
            'user_id' => User::factory(),
            // 'image'   => '/images/1.jpg', //ví dụ: có 1 hình ảnh nằm ở foder public/images/1.jpg
            ];
    }
}

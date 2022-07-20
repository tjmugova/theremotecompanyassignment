<?php

namespace Database\Factories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'resource_type' => $this->faker->randomElement(['pdf', 'html', 'link']),
            'title' => $this->faker->sentence(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Resource $resource) {
            if ($resource->resource_type === 'pdf') {
                //$resource->file_path = $this->faker->file(null,'storage/app/public');
            }
            if ($resource->resource_type === 'html') {
                $resource->description = $this->faker->paragraph();
                $resource->html = $this->faker->randomHtml();
            }
            if ($resource->resource_type === 'link') {
                $resource->link = $this->faker->url();
                $resource->open_in_new_tab = $this->faker->randomElement([0, 1]);
            }
        });
    }
}

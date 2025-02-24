<?php

declare (strict_types= 1);

namespace Tests\Feature;

use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;


class CreateResourceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
    }

    private function GetResourceData(): array
    {
        return Resource::factory()->make()->toArray();

    }

    public function testItCanCreateAResource()
    {
        $response = $this->postJson(route('resource.create'), $this->GetResourceData());

        $response->assertStatus(201);
    }

    public function testItReturns404WhenRouteIsNotFound()
    {
        $response = $this->postJson('/non-existent-route', []);

        $response->assertStatus(404);
    } 
    
    public function testItCanShowStatus422WithDuplicateGithubId()
    {
        $resource = Resource::factory()->create();

        $data = $this->GetResourceData();
        $data['github_id'] = $resource->github_id;

        $response = $this->postJson(route('resource.create'), $data);

        $response->assertStatus(422);
    }

    public function testItCanShowStatus422WithDuplicateUrl()
    {
        $resource = Resource::factory()->create();

        $data = $this->GetResourceData();
        $data['url'] = $resource->url;

        $response = $this->postJson(route('resource.create'), $data);

        $response->assertStatus(422);
    }    

    #[DataProvider('resourceValidationProvider')]
    public function testItCanShowStatus422WithInvalidData(array $invalidData)
    {
        $data = $this->GetResourceData();
        $data = array_merge($data, $invalidData);

        $response = $this->postJson(route('resource.create'), $data);

        $response->assertStatus(422);
    }

    public static function resourceValidationProvider()
    {
        return[
            // github_id
            'missing github_id' => [['github_id' => null]],
            'invalid github_id (is not a string)' => [['github_id' => 2345]],            
            // title
            'missing title' => [['title' => null]],
            'invalid title (too short)' => [['title' => 'a']],
            'invalid title (too long)' => [['title' => self::generateLongText(256)]],
            'invalid title (array)' => [['title' => []]],
            // description
            'invalid description (too short)' => [['description' => 'a']],
            'invalid description (too long)' => [['description' => self::generateLongText(1001)]],
            'invalid description (array)' => [['description' => []]],
            // url
            'missing url' => [['url' => null]],
            'invalid url (not a url)' => [['url' => 'not a url']],
            'invalid url (array)' => [['url' => []]],
            'invalid url (integer)' => [['url' => 123]],
        ];
    }

    /**
     * Generates a string of the exact length specified by the `$length` parameter.
     *
     * This method uses a regular expression to ensure the generated string
     * matches the desired length, guaranteeing that the output will have
     * precisely the number of characters requested.
     *
     * @param int $length The desired length of the generated string.
     * @return string A string with the exact specified length.
     */
    private static function generateLongText(int $length): string
    {
        $faker = \Faker\Factory::create();
        return $faker->regexify("[a-zA-Z0-9]{{$length}}");
    }

}

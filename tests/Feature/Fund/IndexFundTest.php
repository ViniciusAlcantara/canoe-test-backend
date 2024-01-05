<?php

namespace Tests\Feature\Fund;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class IndexFundTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_return_fund_successfully(): void
    {
        $this->seed();

        $response = $this->post('/api/fund/index', data: [
            'name' => 'Testing',
            'start_year' => Carbon::now()->year,
            'fund_manager_id' => '0cd42c7a-79ea-4ecc-8699-2f0714db92dd',
            'page' => 1,
            'per_page' => 1
        ]);

        $response->assertStatus(200);
    }

    /**
     * Check return message for name wrong type
     */
    public function test_return_fund_fail_name_wrong_type(): void
    {
        $this->seed();

        $response = $this->post('/api/fund/index', data: [
            'name' => 1,
            'start_year' => Carbon::now()->year,
            'fund_manager_id' => '0cd42c7a-79ea-4ecc-8699-2f0714db92dd',
            'page' => 1,
            'per_page' => 1
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => 'The name field must be a string.',
                'errors' => [
                    'name' => [
                        'The name field must be a string.'
                    ],
                ]
            ]);
    }

    /**
     * Check return message for name too many characters
     */
    public function test_return_fund_fail_name_length_size(): void
    {
        $this->seed();

        $response = $this->post('/api/fund/index', data: [
            'name' => Str::random(256),
            'start_year' => Carbon::now()->year,
            'fund_manager_id' => '0cd42c7a-79ea-4ecc-8699-2f0714db92dd',
            'aliases' => [
                [
                    'alias' => 'testing'
                ]
            ]
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => 'The name field must not be greater than 255 characters.',
                'errors' => [
                    'name' => [
                        'The name field must not be greater than 255 characters.'
                    ],
                ]
            ]);
    }

    /**
     * Check return message for non existent fund manager id
     */
    public function test_return_fund_fail_fund_manager_id_non_existent(): void
    {
        $this->seed();

        $response = $this->post('/api/fund/index', data: [
            'name' => 'Testing',
            'start_year' => Carbon::now()->year,
            'fund_manager_id' => 'test',
            'aliases' => [
                [
                    'alias' => 'testing'
                ]
            ]
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => 'The selected fund manager id is invalid.',
                'errors' => [
                    'fund_manager_id' => [
                        'The selected fund manager id is invalid.'
                    ],
                ]
            ]);
    }

    /**
     * Check return message for start year before current year
     */
    public function test_return_fund_fail_start_year_before_current_year(): void
    {
        $this->seed();

        $response = $this->post('/api/fund/index', data: [
            'name' => 'Testing',
            'start_year' => 2023,
            'fund_manager_id' => '0cd42c7a-79ea-4ecc-8699-2f0714db92dd',
            'aliases' => [
                [
                    'alias' => 'testing'
                ]
            ]
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => 'The start year field must be at least ' . Carbon::now()->year . '.',
                'errors' => [
                    'start_year' => [
                        'The start year field must be at least ' . Carbon::now()->year . '.'
                    ],
                ]
            ]);
    }

    /**
     * Check return message for page wrong type
     */
    public function test_return_fund_fail_page_wrong_type(): void
    {
        $this->seed();

        $response = $this->post('/api/fund/index', data: [
            'name' => 'Testing',
            'start_year' => Carbon::now()->year,
            'fund_manager_id' => '0cd42c7a-79ea-4ecc-8699-2f0714db92dd',
            'page' => 'test'
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => 'The page field must be an integer.',
                'errors' => [
                    'page' => [
                        'The page field must be an integer.'
                    ],
                ]
            ]);
    }

    /**
     * Check return message for per page wrong type
     */
    public function test_return_fund_fail_per_page_wrong_type(): void
    {
        $this->seed();

        $response = $this->post('/api/fund/index', data: [
            'name' => 'Testing',
            'start_year' => Carbon::now()->year,
            'fund_manager_id' => '0cd42c7a-79ea-4ecc-8699-2f0714db92dd',
            'page' => 1,
            'per_page' => 'test'
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => 'The per page field must be an integer.',
                'errors' => [
                    'per_page' => [
                        'The per page field must be an integer.'
                    ],
                ]
            ]);
    }
}

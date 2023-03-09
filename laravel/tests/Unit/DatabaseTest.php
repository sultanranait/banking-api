<?php

namespace Tests\Unit;

use Tests\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_migrations_and_seeders_were_run_when_setting_up_the_project()
    {
        $this->assertDatabaseCount('branches', 1);
        $this->assertDatabaseHas('customers', [
	        'email' => 'arisha.b123@example.com',
	    ]);
        $this->assertDatabaseHas('accounts', [
	        'account_no' => '01006000000001',
	    ]);
    }
}

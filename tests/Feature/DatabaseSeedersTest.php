<?php 

namespace Lunacms\Forums\Tests\Feature;

use Lunacms\Forums\Database\Seeders\DatabaseSeeder;
use Lunacms\Forums\Forums;
use Lunacms\Forums\Models\Forum;
use Lunacms\Forums\Tests\TestCase;

/**
 * Database seeders tests
 */
class DatabaseSeedersTest extends TestCase
{
	public function test_can_seed_database_without_errors()
	{
		if (!Forums::runningSingleMode()) {
			$this->seed(DatabaseSeeder::class);

			$this->assertGreaterThanOrEqual(3, Forum::count());
		} else {
			$this->seed(\Lunacms\Forums\Database\Seeders\TagSeeder::class);
			$this->seed(\Lunacms\Forums\Database\Seeders\PostSeeder::class);
			$this->assertGreaterThanOrEqual(3, Forum::count());
		}
	}
}
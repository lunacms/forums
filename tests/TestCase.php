<?php 

namespace Lunacms\Forums\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Lunacms\Forums\Forums;
use Lunacms\Forums\ForumsServiceProvider;
use Lunacms\Forums\Tests\Models\User;

/**
 * TestCase
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    protected $loadEnvironmentVariables = true;

    protected $enablePackageDiscoveries = true;

    protected $authUser = null;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testbench']);

        $this->artisan('migrate', ['--database' => 'testbench']);

        // setup user to be used for auth
        $this->setAuthUser();

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(
            'forums.resources.'. \Lunacms\Forums\Tests\Models\User::class, 
            \Lunacms\Forums\Http\Users\Resources\UserResource::class
        );

        $app['config']->set('forums.models.users', User::class);

        $app['config']->set('database.default', 'testbench');

        // Setup default database to use sqlite :memory:
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return array(
            ForumsServiceProvider::class
        );
    }

    public function ignorePackageDiscoveriesFrom()
    {
        return [];
    }

    public function forumSingleMode()
    {
        return Forums::runInSingleMode();
    }

    public function useLogin()
    {
        $user = $this->authUser();

        return $this->actingAs($user);
    }

    public function setAuthUser()
    {
        $this->authUser = User::factory()->create();
    }

    public function authUser()
    {
        return $this->authUser;
    }

    public function forumsUrl($url, $forumSlug = null)
    {
        $url = !empty($forumSlug) && !($mode = Forums::runningSingleMode()) ? $forumSlug . $url : $url;

        return $this->wrapUrl($mode ? $url : '/forums/' . trim($url, '/'));
    }

    public function wrapUrl($url)
    {
        return (trim(config('forums.routes.prefix', '/'), '/') . '/'. trim($url, '/'));
    }
}

<?php

namespace RafflesArgentina\ActionBasedFormRequest;

use Orchestra\Testbench\TestCase;

class ActionBasedFormRequestTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        \Route::group([
            'middleware' => 'web',
            'namespace'  => 'RafflesArgentina\ActionBasedFormRequest',
        ], function ($router) {
            $router->resource('test', 'TestController');
        });
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    function testIndexRules()
    {
        $this->get('/test?show=notnumber')
             ->assertSessionHasErrors();

        $this->get('/test?show=25')
             ->assertStatus(200);
    }

    function testStoreRules()
    {
        $this->post('/test', [])
            ->assertSessionHasErrors();

        $this->post('/test', ['title' => 'test'])
             ->assertStatus(200);
    }

    function testUpdateRules()
    {
        $this->put('/test/1', [])
            ->assertSessionHasErrors();

        $this->put('/test/1', ['title' => 'test'])
             ->assertStatus(200);
    }
}

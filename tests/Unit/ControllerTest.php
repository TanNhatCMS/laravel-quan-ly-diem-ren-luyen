<?php

namespace Tests\Unit;

use App\Http\Controllers\Controller;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    /**
     * Test Controller class exists.
     */
    public function test_controller_exists(): void
    {
        $this->assertTrue(class_exists(Controller::class));
    }

    /**
     * Test Controller can be instantiated.
     */
    public function test_controller_can_be_instantiated(): void
    {
        $controller = new Controller();
        $this->assertInstanceOf(Controller::class, $controller);
    }

    /**
     * Test Controller extends base controller.
     */
    public function test_controller_extends_base_controller(): void
    {
        $controller = new Controller();
        $this->assertInstanceOf(\Illuminate\Routing\Controller::class, $controller);
    }

    /**
     * Test Controller uses required traits.
     */
    public function test_controller_uses_traits(): void
    {
        $traits = class_uses(Controller::class);
        
        $this->assertContains(\Illuminate\Foundation\Auth\Access\AuthorizesRequests::class, $traits);
        $this->assertContains(\Illuminate\Foundation\Bus\DispatchesJobs::class, $traits);
        $this->assertContains(\Illuminate\Foundation\Validation\ValidatesRequests::class, $traits);
    }
}
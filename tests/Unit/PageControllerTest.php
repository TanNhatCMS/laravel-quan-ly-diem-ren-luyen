<?php

namespace Tests\Feature;

use App\Http\Controllers\PageController;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    /**
     * Test PageController exists and has correct namespace.
     */
    public function test_page_controller_exists(): void
    {
        $this->assertTrue(class_exists(PageController::class));
        $this->assertInstanceOf(PageController::class, new PageController());
    }

    /**
     * Test PageController extends Controller.
     */
    public function test_page_controller_extends_controller(): void
    {
        $controller = new PageController();
        $this->assertInstanceOf(\App\Http\Controllers\Controller::class, $controller);
    }

    /**
     * Test PageController has index method.
     */
    public function test_page_controller_has_index_method(): void
    {
        $this->assertTrue(method_exists(PageController::class, 'index'));
    }
}

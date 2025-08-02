<?php

namespace Tests\Unit;

use App\Models\EvaluationScores;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluationScoresTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test EvaluationScores model instantiation.
     */
    public function test_evaluation_scores_model_instantiation(): void
    {
        $evaluationScore = new EvaluationScores();
        $this->assertInstanceOf(EvaluationScores::class, $evaluationScore);
    }

    /**
     * Test EvaluationScores table name.
     */
    public function test_evaluation_scores_table_name(): void
    {
        $evaluationScore = new EvaluationScores();
        $this->assertEquals('evaluation_scores', $evaluationScore->getTable());
    }

    /**
     * Test EvaluationScores guarded attributes.
     */
    public function test_evaluation_scores_guarded_attributes(): void
    {
        $evaluationScore = new EvaluationScores();
        $expected = ['id'];

        $this->assertEquals($expected, $evaluationScore->getGuarded());
    }

    /**
     * Test EvaluationScores uses required traits.
     */
    public function test_evaluation_scores_uses_traits(): void
    {
        $traits = class_uses(EvaluationScores::class);

        $this->assertContains(\Backpack\CRUD\app\Models\Traits\CrudTrait::class, $traits);
        $this->assertContains(\Illuminate\Database\Eloquent\Factories\HasFactory::class, $traits);
    }

    /**
     * Test EvaluationScores model exists.
     */
    public function test_evaluation_scores_model_exists(): void
    {
        $this->assertTrue(class_exists(EvaluationScores::class));
    }

    /**
     * Test EvaluationScores timestamps.
     */
    public function test_evaluation_scores_timestamps(): void
    {
        $evaluationScore = new EvaluationScores();
        $this->assertTrue($evaluationScore->timestamps);
    }
}

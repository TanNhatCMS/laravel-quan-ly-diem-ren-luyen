<?php

namespace Tests\Unit;

use App\Models\SemesterScores;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SemesterScoresTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test SemesterScores model instantiation.
     */
    public function test_semester_scores_model_instantiation(): void
    {
        $semesterScore = new SemesterScores();
        $this->assertInstanceOf(SemesterScores::class, $semesterScore);
    }

    /**
     * Test SemesterScores table name.
     */
    public function test_semester_scores_table_name(): void
    {
        $semesterScore = new SemesterScores();
        $this->assertEquals('semester_scores', $semesterScore->getTable());
    }

    /**
     * Test SemesterScores fillable attributes.
     */
    public function test_semester_scores_fillable_attributes(): void
    {
        $semesterScore = new SemesterScores();
        $expected = ['year', 'semester', 'evaluation_start', 'evaluation_end'];

        $this->assertEquals($expected, $semesterScore->getFillable());
    }

    /**
     * Test SemesterScores guarded attributes.
     */
    public function test_semester_scores_guarded_attributes(): void
    {
        $semesterScore = new SemesterScores();
        $expected = ['id'];

        $this->assertEquals($expected, $semesterScore->getGuarded());
    }

    /**
     * Test SemesterScores uses required traits.
     */
    public function test_semester_scores_uses_traits(): void
    {
        $traits = class_uses(SemesterScores::class);

        $this->assertContains(\Backpack\CRUD\app\Models\Traits\CrudTrait::class, $traits);
        $this->assertContains(\Illuminate\Database\Eloquent\Factories\HasFactory::class, $traits);
    }

    /**
     * Test mass assignment protection.
     */
    public function test_mass_assignment_protection(): void
    {
        $semesterScore = new SemesterScores();
        
        // Should be able to fill allowed attributes
        $semesterScore->fill([
            'year' => 2024,
            'semester' => 1,
            'evaluation_start' => '2024-01-01',
            'evaluation_end' => '2024-06-30'
        ]);
        
        $this->assertEquals(2024, $semesterScore->year);
        $this->assertEquals(1, $semesterScore->semester);
        $this->assertEquals('2024-01-01', $semesterScore->evaluation_start);
        $this->assertEquals('2024-06-30', $semesterScore->evaluation_end);
        
        // Should not be able to fill id (guarded)
        $semesterScore->fill(['id' => 999]);
        $this->assertNull($semesterScore->id);
    }

    /**
     * Test semester score validation scenarios.
     */
    public function test_semester_validation(): void
    {
        $semesterScore = new SemesterScores();
        
        // Test valid semester values (assuming 1-2 for annual system or 1-3 for trimester)
        $validSemesters = [1, 2, 3];
        foreach ($validSemesters as $semester) {
            $semesterScore->fill(['semester' => $semester]);
            $this->assertEquals($semester, $semesterScore->semester);
        }
    }

    /**
     * Test year validation scenarios.
     */
    public function test_year_validation(): void
    {
        $semesterScore = new SemesterScores();
        
        // Test current and future years
        $currentYear = date('Y');
        $semesterScore->fill(['year' => $currentYear]);
        $this->assertEquals($currentYear, $semesterScore->year);
        
        $futureYear = $currentYear + 1;
        $semesterScore->fill(['year' => $futureYear]);
        $this->assertEquals($futureYear, $semesterScore->year);
    }
}
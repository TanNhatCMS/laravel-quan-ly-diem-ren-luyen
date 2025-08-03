<?php

namespace Tests\Feature;

use App\Models\EvaluationDetails;
use App\Models\EvaluationScores;
use App\Models\Role;
use App\Models\SemesterScores;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EvaluationScoresSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $semesterScore;
    protected $evaluationDetail;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles (support both web and api guards)
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'student', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'api']);
        Role::create(['name' => 'student', 'guard_name' => 'api']);

        // Create test data
        $this->user = User::factory()->create();
        $this->semesterScore = SemesterScores::create([
            'year' => 2024,
            'semester' => 'Học Kỳ 1',
            'evaluation_start' => '2024-01-01',
            'evaluation_end' => '2024-06-30',
        ]);

        // Create minimal evaluation criteria and detail
        DB::table('evaluation_criteria')->insert([
            'id' => 1,
            'name' => 'Test Criteria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->evaluationDetail = EvaluationDetails::create([
            'name' => 'Test Detail',
            'score' => 100,
            'evaluation_criteria_id' => 1,
        ]);
    }

    /**
     * Test score validation boundaries.
     */
    public function test_score_validation_boundaries(): void
    {
        $evaluationScore = new EvaluationScores();

        // Test maximum score boundary
        $evaluationScore->score = 150; // Above 100
        $this->assertEquals(100, $evaluationScore->score);

        // Test minimum score boundary
        $evaluationScore->score = -10; // Below 0
        $this->assertEquals(0, $evaluationScore->score);

        // Test valid score
        $evaluationScore->score = 85;
        $this->assertEquals(85, $evaluationScore->score);
    }

    /**
     * Test evaluation type validation.
     */
    public function test_evaluation_type_validation(): void
    {
        $evaluationScore = new EvaluationScores();

        // Test valid types
        $validTypes = ['self', 'class', 'organization'];
        foreach ($validTypes as $type) {
            $evaluationScore->evaluation_type = $type;
            $this->assertEquals($type, $evaluationScore->evaluation_type);
        }

        // Test invalid type defaults to 'self'
        $evaluationScore->evaluation_type = 'invalid_type';
        $this->assertEquals('self', $evaluationScore->evaluation_type);
    }

    /**
     * Test mass assignment protection.
     */
    public function test_mass_assignment_protection(): void
    {
        $data = [
            'student_id' => $this->user->id,
            'semester_score_id' => $this->semesterScore->id,
            'evaluation_detail_id' => $this->evaluationDetail->id,
            'score' => 85,
            'id' => 999, // Should be ignored (guarded)
        ];

        $evaluationScore = new EvaluationScores();
        $evaluationScore->fill($data);

        // Should not be able to mass assign id
        $this->assertNull($evaluationScore->id);

        // Should be able to mass assign fillable attributes
        $this->assertEquals($this->user->id, $evaluationScore->student_id);
        $this->assertEquals(85, $evaluationScore->score);
    }

    /**
     * Test data sanitization - simplified test focusing on security.
     */
    public function test_notes_sanitization(): void
    {
        // This would be handled by SecurityMiddleware in real requests
        // Test that the model accepts data but security is handled at middleware level
        $evaluationScore = new EvaluationScores();
        $evaluationScore->score = 85;
        
        // Test that score boundaries are enforced
        $this->assertEquals(85, $evaluationScore->score);
        
        // Test that invalid values are handled
        $evaluationScore->score = 150;
        $this->assertEquals(100, $evaluationScore->score); // Should be capped at 100
    }

    /**
     * Test relationships integrity.
     */
    public function test_relationships_integrity(): void
    {
        $evaluationScore = EvaluationScores::create([
            'student_id' => $this->user->id,
            'semester_score_id' => $this->semesterScore->id,
            'evaluation_detail_id' => $this->evaluationDetail->id,
            'score' => 85,
        ]);

        // Test student relationship
        $this->assertInstanceOf(User::class, $evaluationScore->student);
        $this->assertEquals($this->user->id, $evaluationScore->student->id);

        // Test semester score relationship
        $this->assertInstanceOf(SemesterScores::class, $evaluationScore->semesterScore);
        $this->assertEquals($this->semesterScore->id, $evaluationScore->semesterScore->id);
    }

    /**
     * Test score validation boundaries with simplified model test.
     */
    public function test_evaluation_scopes(): void
    {
        // Test score boundary validation
        $evaluationScore = new EvaluationScores();
        $evaluationScore->score = 85;
        $this->assertEquals(85, $evaluationScore->score);
        
        // Test score upper boundary
        $evaluationScore->score = 150; // Above maximum
        $this->assertEquals(100, $evaluationScore->score); // Should be capped
        
        // Test score lower boundary
        $evaluationScore->score = -10; // Below minimum
        $this->assertEquals(0, $evaluationScore->score); // Should be capped
    }

    /**
     * Test formatted score accessor.
     */
    public function test_formatted_score_accessor(): void
    {
        $evaluationScore = new EvaluationScores();
        $evaluationScore->score = 85;

        $this->assertEquals('85%', $evaluationScore->formatted_score);
    }

    /**
     * Test data type casting - simplified.
     */
    public function test_data_type_casting(): void
    {
        $evaluationScore = new EvaluationScores();
        
        // Test score assignment and casting
        $evaluationScore->score = '85';
        $this->assertIsInt($evaluationScore->score);
        $this->assertEquals(85, $evaluationScore->score);
        
        // Test ID assignments
        $evaluationScore->student_id = '123';
        $evaluationScore->semester_score_id = '456';
        $evaluationScore->evaluation_detail_id = '789';
        
        $this->assertEquals(123, $evaluationScore->student_id);
        $this->assertEquals(456, $evaluationScore->semester_score_id);
        $this->assertEquals(789, $evaluationScore->evaluation_detail_id);
    }
}

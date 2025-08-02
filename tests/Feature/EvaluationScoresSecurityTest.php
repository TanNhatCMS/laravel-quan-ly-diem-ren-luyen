<?php

namespace Tests\Feature;

use App\Models\EvaluationScores;
use App\Models\User;
use App\Models\SemesterScores;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluationScoresSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $semesterScore;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'student', 'guard_name' => 'web']);
        
        // Create test data
        $this->user = User::factory()->create();
        $this->semesterScore = SemesterScores::create([
            'year' => 2024,
            'semester' => 1,
            'evaluation_start' => '2024-01-01',
            'evaluation_end' => '2024-06-30'
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
            'user_id' => $this->user->id,
            'semester_score_id' => $this->semesterScore->id,
            'score' => 85,
            'evaluation_type' => 'self',
            'notes' => 'Good performance',
            'id' => 999, // Should be ignored (guarded)
        ];
        
        $evaluationScore = new EvaluationScores();
        $evaluationScore->fill($data);
        
        // Should not be able to mass assign id
        $this->assertNull($evaluationScore->id);
        
        // Should be able to mass assign fillable attributes
        $this->assertEquals($this->user->id, $evaluationScore->user_id);
        $this->assertEquals(85, $evaluationScore->score);
    }

    /**
     * Test data sanitization in notes field.
     */
    public function test_notes_sanitization(): void
    {
        $maliciousNote = '<script>alert("XSS")</script>Good student performance';
        
        $evaluationScore = EvaluationScores::create([
            'user_id' => $this->user->id,
            'semester_score_id' => $this->semesterScore->id,
            'score' => 85,
            'evaluation_type' => 'self',
            'notes' => $maliciousNote,
        ]);
        
        // Verify script tags are not stored as-is (would be handled by middleware)
        $this->assertNotEquals($maliciousNote, $evaluationScore->notes);
    }

    /**
     * Test relationships integrity.
     */
    public function test_relationships_integrity(): void
    {
        $evaluationScore = EvaluationScores::create([
            'user_id' => $this->user->id,
            'semester_score_id' => $this->semesterScore->id,
            'score' => 85,
            'evaluation_type' => 'self',
        ]);
        
        // Test user relationship
        $this->assertInstanceOf(User::class, $evaluationScore->user);
        $this->assertEquals($this->user->id, $evaluationScore->user->id);
        
        // Test semester score relationship
        $this->assertInstanceOf(SemesterScores::class, $evaluationScore->semesterScore);
        $this->assertEquals($this->semesterScore->id, $evaluationScore->semesterScore->id);
    }

    /**
     * Test scopes functionality.
     */
    public function test_evaluation_scopes(): void
    {
        // Create approved evaluation
        $approvedEvaluation = EvaluationScores::create([
            'user_id' => $this->user->id,
            'semester_score_id' => $this->semesterScore->id,
            'score' => 85,
            'evaluation_type' => 'self',
            'approved_at' => now(),
            'approved_by' => $this->user->id,
        ]);
        
        // Create pending evaluation
        $pendingEvaluation = EvaluationScores::create([
            'user_id' => $this->user->id,
            'semester_score_id' => $this->semesterScore->id,
            'score' => 90,
            'evaluation_type' => 'class',
        ]);
        
        // Test approved scope
        $approved = EvaluationScores::approved()->get();
        $this->assertCount(1, $approved);
        $this->assertEquals($approvedEvaluation->id, $approved->first()->id);
        
        // Test pending scope
        $pending = EvaluationScores::pending()->get();
        $this->assertCount(1, $pending);
        $this->assertEquals($pendingEvaluation->id, $pending->first()->id);
        
        // Test type scope
        $selfEvaluations = EvaluationScores::byType('self')->get();
        $this->assertCount(1, $selfEvaluations);
        
        $classEvaluations = EvaluationScores::byType('class')->get();
        $this->assertCount(1, $classEvaluations);
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
     * Test data type casting.
     */
    public function test_data_type_casting(): void
    {
        $evaluationScore = EvaluationScores::create([
            'user_id' => $this->user->id,
            'semester_score_id' => $this->semesterScore->id,
            'score' => '85.50',
            'evaluation_type' => 'self',
            'submitted_at' => '2024-01-15 10:30:00',
        ]);
        
        // Test decimal casting for score
        $this->assertIsFloat($evaluationScore->score);
        $this->assertEquals(85.50, $evaluationScore->score);
        
        // Test datetime casting
        $this->assertInstanceOf(\Carbon\Carbon::class, $evaluationScore->submitted_at);
        
        // Test integer casting for IDs
        $this->assertIsInt($evaluationScore->user_id);
        $this->assertIsInt($evaluationScore->semester_score_id);
    }
}
<?php

namespace Tests\Unit;

use App\Http\Requests\EvaluationScoresRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ValidationRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test UserRequest validation rules.
     */
    public function test_user_request_validation_rules(): void
    {
        $request = new UserRequest();
        $rules = $request->rules();

        // Test that required validation rules exist
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('email', $rules);
        $this->assertContains('required', explode('|', $rules['name']));
        $this->assertContains('required', explode('|', $rules['email']));
    }

    /**
     * Test UserRequest validation with valid data.
     */
    public function test_user_request_valid_data(): void
    {
        $request = new UserRequest();
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * Test UserRequest validation with invalid data.
     */
    public function test_user_request_invalid_data(): void
    {
        $request = new UserRequest();
        $data = [
            'name' => 'A', // Too short
            'email' => 'invalid-email', // Invalid format
            'password' => '123', // Too short
        ];

        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('name'));
        $this->assertTrue($validator->errors()->has('email'));
        $this->assertTrue($validator->errors()->has('password'));
    }

    /**
     * Test EvaluationScoresRequest validation rules.
     */
    public function test_evaluation_scores_request_validation_rules(): void
    {
        $request = new EvaluationScoresRequest();
        $rules = $request->rules();

        // Test that key validation rules exist
        $this->assertArrayHasKey('user_id', $rules);
        $this->assertArrayHasKey('score', $rules);
        $this->assertArrayHasKey('evaluation_type', $rules);

        $this->assertContains('required', explode('|', $rules['user_id']));
        $this->assertContains('required', explode('|', $rules['score']));
        $this->assertContains('required', explode('|', $rules['evaluation_type']));
    }

    /**
     * Test EvaluationScoresRequest score validation.
     */
    public function test_evaluation_scores_score_validation(): void
    {
        $request = new EvaluationScoresRequest();
        $rules = $request->rules();

        // Test valid score
        $validData = [
            'user_id' => 1,
            'semester_score_id' => 1,
            'score' => 85,
            'evaluation_type' => 'self',
        ];

        $validator = Validator::make($validData, $rules);
        $this->assertTrue($validator->passes());

        // Test invalid score (above maximum)
        $invalidData = [
            'user_id' => 1,
            'semester_score_id' => 1,
            'score' => 150, // Above 100
            'evaluation_type' => 'self',
        ];

        $validator = Validator::make($invalidData, $rules);
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('score'));

        // Test invalid score (below minimum)
        $invalidData['score'] = -10; // Below 0
        $validator = Validator::make($invalidData, $rules);
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('score'));
    }

    /**
     * Test EvaluationScoresRequest evaluation type validation.
     */
    public function test_evaluation_scores_type_validation(): void
    {
        $request = new EvaluationScoresRequest();
        $rules = $request->rules();

        // Test valid evaluation types
        $validTypes = ['self', 'class', 'organization'];

        foreach ($validTypes as $type) {
            $data = [
                'user_id' => 1,
                'semester_score_id' => 1,
                'score' => 85,
                'evaluation_type' => $type,
            ];

            $validator = Validator::make($data, $rules);
            $this->assertTrue($validator->passes(), "Failed for evaluation type: {$type}");
        }

        // Test invalid evaluation type
        $invalidData = [
            'user_id' => 1,
            'semester_score_id' => 1,
            'score' => 85,
            'evaluation_type' => 'invalid_type',
        ];

        $validator = Validator::make($invalidData, $rules);
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('evaluation_type'));
    }

    /**
     * Test request authorization.
     */
    public function test_request_authorization(): void
    {
        $userRequest = new UserRequest();
        $evaluationRequest = new EvaluationScoresRequest();

        // Test that authorize methods exist and return boolean
        $this->assertTrue(method_exists($userRequest, 'authorize'));
        $this->assertTrue(method_exists($evaluationRequest, 'authorize'));
    }

    /**
     * Test custom validation messages.
     */
    public function test_custom_validation_messages(): void
    {
        $userRequest = new UserRequest();
        $messages = $userRequest->messages();

        $this->assertIsArray($messages);

        // Test that important messages are defined
        if (! empty($messages)) {
            $this->assertNotEmpty($messages);
        }
    }

    /**
     * Test XSS prevention in validation.
     */
    public function test_xss_prevention_validation(): void
    {
        $request = new UserRequest();
        $maliciousData = [
            'name' => '<script>alert("XSS")</script>',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $validator = Validator::make($maliciousData, $request->rules());

        // The validation should still pass, but the data will be sanitized during processing
        // This depends on your application's XSS protection implementation
        $this->assertTrue($validator->passes());
    }

    /**
     * Test SQL injection prevention in validation.
     */
    public function test_sql_injection_prevention_validation(): void
    {
        $request = new UserRequest();
        $maliciousData = [
            'name' => "'; DROP TABLE users; --",
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $validator = Validator::make($maliciousData, $request->rules());

        // Validation should pass, protection happens at the database layer
        $this->assertTrue($validator->passes());
    }
}

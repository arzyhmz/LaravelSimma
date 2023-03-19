<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\contact;

class contactApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_contact()
    {
        $contact = contact::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/contacts', $contact
        );

        $this->assertApiResponse($contact);
    }

    /**
     * @test
     */
    public function test_read_contact()
    {
        $contact = contact::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/contacts/'.$contact->id
        );

        $this->assertApiResponse($contact->toArray());
    }

    /**
     * @test
     */
    public function test_update_contact()
    {
        $contact = contact::factory()->create();
        $editedcontact = contact::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/contacts/'.$contact->id,
            $editedcontact
        );

        $this->assertApiResponse($editedcontact);
    }

    /**
     * @test
     */
    public function test_delete_contact()
    {
        $contact = contact::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/contacts/'.$contact->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/contacts/'.$contact->id
        );

        $this->response->assertStatus(404);
    }
}

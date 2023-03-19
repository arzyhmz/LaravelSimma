<?php namespace Tests\Repositories;

use App\Models\contact;
use App\Repositories\contactRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class contactRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var contactRepository
     */
    protected $contactRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->contactRepo = \App::make(contactRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_contact()
    {
        $contact = contact::factory()->make()->toArray();

        $createdcontact = $this->contactRepo->create($contact);

        $createdcontact = $createdcontact->toArray();
        $this->assertArrayHasKey('id', $createdcontact);
        $this->assertNotNull($createdcontact['id'], 'Created contact must have id specified');
        $this->assertNotNull(contact::find($createdcontact['id']), 'contact with given id must be in DB');
        $this->assertModelData($contact, $createdcontact);
    }

    /**
     * @test read
     */
    public function test_read_contact()
    {
        $contact = contact::factory()->create();

        $dbcontact = $this->contactRepo->find($contact->id);

        $dbcontact = $dbcontact->toArray();
        $this->assertModelData($contact->toArray(), $dbcontact);
    }

    /**
     * @test update
     */
    public function test_update_contact()
    {
        $contact = contact::factory()->create();
        $fakecontact = contact::factory()->make()->toArray();

        $updatedcontact = $this->contactRepo->update($fakecontact, $contact->id);

        $this->assertModelData($fakecontact, $updatedcontact->toArray());
        $dbcontact = $this->contactRepo->find($contact->id);
        $this->assertModelData($fakecontact, $dbcontact->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_contact()
    {
        $contact = contact::factory()->create();

        $resp = $this->contactRepo->delete($contact->id);

        $this->assertTrue($resp);
        $this->assertNull(contact::find($contact->id), 'contact should not exist in DB');
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatecontactAPIRequest;
use App\Http\Requests\API\UpdatecontactAPIRequest;
use App\Models\contact;
use App\Repositories\contactRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class contactController
 * @package App\Http\Controllers\API
 */

class contactAPIController extends AppBaseController
{
    /** @var  contactRepository */
    private $contactRepository;

    public function __construct(contactRepository $contactRepo)
    {
        $this->contactRepository = $contactRepo;
    }

    /**
     * Display a listing of the contact.
     * GET|HEAD /contacts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $contacts = $this->contactRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($contacts->toArray(), 'Contacts retrieved successfully');
    }

    /**
     * Store a newly created contact in storage.
     * POST /contacts
     *
     * @param CreatecontactAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatecontactAPIRequest $request)
    {
        $input = $request->all();

        $contact = $this->contactRepository->create($input);

        return $this->sendResponse($contact->toArray(), 'Contact saved successfully');
    }

    /**
     * Display the specified contact.
     * GET|HEAD /contacts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var contact $contact */
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        return $this->sendResponse($contact->toArray(), 'Contact retrieved successfully');
    }

    /**
     * Update the specified contact in storage.
     * PUT/PATCH /contacts/{id}
     *
     * @param int $id
     * @param UpdatecontactAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecontactAPIRequest $request)
    {
        $input = $request->all();

        /** @var contact $contact */
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        $contact = $this->contactRepository->update($input, $id);

        return $this->sendResponse($contact->toArray(), 'contact updated successfully');
    }

    /**
     * Remove the specified contact from storage.
     * DELETE /contacts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var contact $contact */
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        $contact->delete();

        return $this->sendSuccess('Contact deleted successfully');
    }
}

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

class contactAPIController extends AppBaseController {
    /** @var  contactRepository */
    private $contactRepository;

    public function __construct(contactRepository $contactRepo)
    {
        $this->contactRepository = $contactRepo;
    }

    public function index(Request $request)
    {
        $contacts = $this->contactRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($contacts->toArray(), 'Contacts retrieved successfully');
    }

    public function store(CreatecontactAPIRequest $request)
    {
        $input = $request->all();
        $contact = $this->contactRepository->create($input);
        return $this->sendResponse($contact->toArray(), 'Contact saved successfully');
    }

    public function show($id)
    {
        /** @var contact $contact */
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        return $this->sendResponse($contact->toArray(), 'Contact retrieved successfully');
    }

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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatechildrenRequest;
use App\Http\Requests\UpdatechildrenRequest;
use App\Repositories\childrenRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class childrenController extends AppBaseController
{
    /** @var  childrenRepository */
    private $childrenRepository;

    public function __construct(childrenRepository $childrenRepo)
    {
        $this->childrenRepository = $childrenRepo;
    }

    /**
     * Display a listing of the children.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $childrens = $this->childrenRepository->all();

        return view('childrens.index')
            ->with('childrens', $childrens);
    }

    /**
     * Show the form for creating a new children.
     *
     * @return Response
     */
    public function create()
    {
        return view('childrens.create');
    }

    /**
     * Store a newly created children in storage.
     *
     * @param CreatechildrenRequest $request
     *
     * @return Response
     */
    public function store(CreatechildrenRequest $request)
    {
        $input = $request->all();

        $children = $this->childrenRepository->create($input);

        Flash::success('Children saved successfully.');

        return redirect(route('childrens.index'));
    }

    /**
     * Display the specified children.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $children = $this->childrenRepository->find($id);

        if (empty($children)) {
            Flash::error('Children not found');

            return redirect(route('childrens.index'));
        }

        return view('childrens.show')->with('children', $children);
    }

    /**
     * Show the form for editing the specified children.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $children = $this->childrenRepository->find($id);

        if (empty($children)) {
            Flash::error('Children not found');

            return redirect(route('childrens.index'));
        }

        return view('childrens.edit')->with('children', $children);
    }

    /**
     * Update the specified children in storage.
     *
     * @param int $id
     * @param UpdatechildrenRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatechildrenRequest $request)
    {
        $children = $this->childrenRepository->find($id);

        if (empty($children)) {
            Flash::error('Children not found');

            return redirect(route('childrens.index'));
        }

        $children = $this->childrenRepository->update($request->all(), $id);

        Flash::success('Children updated successfully.');

        return redirect(route('childrens.index'));
    }

    /**
     * Remove the specified children from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $children = $this->childrenRepository->find($id);

        if (empty($children)) {
            Flash::error('Children not found');

            return redirect(route('childrens.index'));
        }

        $this->childrenRepository->delete($id);

        Flash::success('Children deleted successfully.');

        return redirect(route('childrens.index'));
    }
}

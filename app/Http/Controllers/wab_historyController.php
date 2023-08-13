<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createwab_historyRequest;
use App\Http\Requests\Updatewab_historyRequest;
use App\Repositories\wab_historyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class wab_historyController extends AppBaseController
{
    /** @var  wab_historyRepository */
    private $wabHistoryRepository;

    public function __construct(wab_historyRepository $wabHistoryRepo)
    {
        $this->wabHistoryRepository = $wabHistoryRepo;
    }

    /**
     * Display a listing of the wab_history.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $wabHistories = $this->wabHistoryRepository->allQuery()
            ->paginate(25)->appends(request()->query());

        return view('wab_histories.index')
            ->with('wabHistories', $wabHistories);
    }

    /**
     * Show the form for creating a new wab_history.
     *
     * @return Response
     */
    public function create()
    {
        return view('wab_histories.create');
    }

    /**
     * Store a newly created wab_history in storage.
     *
     * @param Createwab_historyRequest $request
     *
     * @return Response
     */
    public function store(Createwab_historyRequest $request)
    {
        $input = $request->all();

        $wabHistory = $this->wabHistoryRepository->create($input);

        Flash::success('Wab History saved successfully.');

        return redirect(route('wabHistories.index'));
    }

    /**
     * Display the specified wab_history.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $wabHistory = $this->wabHistoryRepository->find($id);

        if (empty($wabHistory)) {
            Flash::error('Wab History not found');

            return redirect(route('wabHistories.index'));
        }

        return view('wab_histories.show')->with('wabHistory', $wabHistory);
    }

    /**
     * Show the form for editing the specified wab_history.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $wabHistory = $this->wabHistoryRepository->find($id);

        if (empty($wabHistory)) {
            Flash::error('Wab History not found');

            return redirect(route('wabHistories.index'));
        }

        return view('wab_histories.edit')->with('wabHistory', $wabHistory);
    }

    /**
     * Update the specified wab_history in storage.
     *
     * @param int $id
     * @param Updatewab_historyRequest $request
     *
     * @return Response
     */
    public function update($id, Updatewab_historyRequest $request)
    {
        $wabHistory = $this->wabHistoryRepository->find($id);

        if (empty($wabHistory)) {
            Flash::error('Wab History not found');

            return redirect(route('wabHistories.index'));
        }

        $wabHistory = $this->wabHistoryRepository->update($request->all(), $id);

        Flash::success('Wab History updated successfully.');

        return redirect(route('wabHistories.index'));
    }

    /**
     * Remove the specified wab_history from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $wabHistory = $this->wabHistoryRepository->find($id);

        if (empty($wabHistory)) {
            Flash::error('Wab History not found');

            return redirect(route('wabHistories.index'));
        }

        $this->wabHistoryRepository->delete($id);

        Flash::success('Wab History deleted successfully.');

        return redirect(route('wabHistories.index'));
    }
}

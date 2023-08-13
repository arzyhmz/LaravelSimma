<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createchildren_logsRequest;
use App\Http\Requests\Updatechildren_logsRequest;
use App\Repositories\children_logsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class children_logsController extends AppBaseController
{
    /** @var  children_logsRepository */
    private $childrenLogsRepository;

    public function __construct(children_logsRepository $childrenLogsRepo)
    {
        $this->childrenLogsRepository = $childrenLogsRepo;
    }

    /**
     * Display a listing of the children_logs.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $childrenLogs = $this->childrenLogsRepository->allQuery()
            ->paginate(25)->appends(request()->query());

        return view('children_logs.index')
            ->with('childrenLogs', $childrenLogs);
    }

    /**
     * Show the form for creating a new children_logs.
     *
     * @return Response
     */
    public function create()
    {
        return view('children_logs.create');
    }

    /**
     * Store a newly created children_logs in storage.
     *
     * @param Createchildren_logsRequest $request
     *
     * @return Response
     */
    public function store(Createchildren_logsRequest $request)
    {
        $input = $request->all();

        $childrenLogs = $this->childrenLogsRepository->create($input);

        Flash::success('Children Logs saved successfully.');

        return redirect(route('childrenLogs.index'));
    }

    /**
     * Display the specified children_logs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $childrenLogs = $this->childrenLogsRepository->find($id);

        if (empty($childrenLogs)) {
            Flash::error('Children Logs not found');

            return redirect(route('childrenLogs.index'));
        }

        return view('children_logs.show')->with('childrenLogs', $childrenLogs);
    }

    /**
     * Show the form for editing the specified children_logs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $childrenLogs = $this->childrenLogsRepository->find($id);

        if (empty($childrenLogs)) {
            Flash::error('Children Logs not found');

            return redirect(route('childrenLogs.index'));
        }

        return view('children_logs.edit')->with('childrenLogs', $childrenLogs);
    }

    /**
     * Update the specified children_logs in storage.
     *
     * @param int $id
     * @param Updatechildren_logsRequest $request
     *
     * @return Response
     */
    public function update($id, Updatechildren_logsRequest $request)
    {
        $childrenLogs = $this->childrenLogsRepository->find($id);

        if (empty($childrenLogs)) {
            Flash::error('Children Logs not found');

            return redirect(route('childrenLogs.index'));
        }

        $childrenLogs = $this->childrenLogsRepository->update($request->all(), $id);

        Flash::success('Children Logs updated successfully.');

        return redirect(route('childrenLogs.index'));
    }

    /**
     * Remove the specified children_logs from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $childrenLogs = $this->childrenLogsRepository->find($id);

        if (empty($childrenLogs)) {
            Flash::error('Children Logs not found');

            return redirect(route('childrenLogs.index'));
        }

        $this->childrenLogsRepository->delete($id);

        Flash::success('Children Logs deleted successfully.');

        return redirect(route('childrenLogs.index'));
    }
}

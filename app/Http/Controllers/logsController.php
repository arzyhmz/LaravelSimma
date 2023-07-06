<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatelogsRequest;
use App\Http\Requests\UpdatelogsRequest;
use App\Repositories\logsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class logsController extends AppBaseController
{
    /** @var  logsRepository */
    private $logsRepository;

    public function __construct(logsRepository $logsRepo)
    {
        $this->logsRepository = $logsRepo;
    }

    /**
     * Display a listing of the logs.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $logs = $this->logsRepository->all();

        return view('logs.index')
            ->with('logs', $logs);
    }

    /**
     * Show the form for creating a new logs.
     *
     * @return Response
     */
    public function create()
    {
        return view('logs.create');
    }

    /**
     * Store a newly created logs in storage.
     *
     * @param CreatelogsRequest $request
     *
     * @return Response
     */
    public function store(CreatelogsRequest $request)
    {
        $input = $request->all();

        $logs = $this->logsRepository->create($input);

        Flash::success('Logs saved successfully.');

        return redirect(route('logs.index'));
    }

    /**
     * Display the specified logs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $logs = $this->logsRepository->find($id);

        if (empty($logs)) {
            Flash::error('Logs not found');

            return redirect(route('logs.index'));
        }

        return view('logs.show')->with('logs', $logs);
    }

    /**
     * Show the form for editing the specified logs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $logs = $this->logsRepository->find($id);

        if (empty($logs)) {
            Flash::error('Logs not found');

            return redirect(route('logs.index'));
        }

        return view('logs.edit')->with('logs', $logs);
    }

    /**
     * Update the specified logs in storage.
     *
     * @param int $id
     * @param UpdatelogsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatelogsRequest $request)
    {
        $logs = $this->logsRepository->find($id);

        if (empty($logs)) {
            Flash::error('Logs not found');

            return redirect(route('logs.index'));
        }

        $logs = $this->logsRepository->update($request->all(), $id);

        Flash::success('Logs updated successfully.');

        return redirect(route('logs.index'));
    }

    /**
     * Remove the specified logs from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $logs = $this->logsRepository->find($id);

        if (empty($logs)) {
            Flash::error('Logs not found');

            return redirect(route('logs.index'));
        }

        $this->logsRepository->delete($id);

        Flash::success('Logs deleted successfully.');

        return redirect(route('logs.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createchat_logsRequest;
use App\Http\Requests\Updatechat_logsRequest;
use App\Repositories\chat_logsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class chat_logsController extends AppBaseController
{
    /** @var  chat_logsRepository */
    private $chatLogsRepository;

    public function __construct(chat_logsRepository $chatLogsRepo)
    {
        $this->chatLogsRepository = $chatLogsRepo;
    }

    /**
     * Display a listing of the chat_logs.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $chatLogs = $this->chatLogsRepository->allQuery()
            ->paginate(25)->appends(request()->query());

        return view('chat_logs.index')
            ->with('chatLogs', $chatLogs);
    }

    /**
     * Show the form for creating a new chat_logs.
     *
     * @return Response
     */
    public function create()
    {
        return view('chat_logs.create');
    }

    /**
     * Store a newly created chat_logs in storage.
     *
     * @param Createchat_logsRequest $request
     *
     * @return Response
     */
    public function store(Createchat_logsRequest $request)
    {
        $input = $request->all();

        $chatLogs = $this->chatLogsRepository->create($input);

        Flash::success('Chat Logs saved successfully.');

        return redirect(route('chatLogs.index'));
    }

    /**
     * Display the specified chat_logs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $chatLogs = $this->chatLogsRepository->find($id);

        if (empty($chatLogs)) {
            Flash::error('Chat Logs not found');

            return redirect(route('chatLogs.index'));
        }

        return view('chat_logs.show')->with('chatLogs', $chatLogs);
    }

    /**
     * Show the form for editing the specified chat_logs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $chatLogs = $this->chatLogsRepository->find($id);

        if (empty($chatLogs)) {
            Flash::error('Chat Logs not found');

            return redirect(route('chatLogs.index'));
        }

        return view('chat_logs.edit')->with('chatLogs', $chatLogs);
    }

    /**
     * Update the specified chat_logs in storage.
     *
     * @param int $id
     * @param Updatechat_logsRequest $request
     *
     * @return Response
     */
    public function update($id, Updatechat_logsRequest $request)
    {
        $chatLogs = $this->chatLogsRepository->find($id);

        if (empty($chatLogs)) {
            Flash::error('Chat Logs not found');

            return redirect(route('chatLogs.index'));
        }

        $chatLogs = $this->chatLogsRepository->update($request->all(), $id);

        Flash::success('Chat Logs updated successfully.');

        return redirect(route('chatLogs.index'));
    }

    /**
     * Remove the specified chat_logs from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $chatLogs = $this->chatLogsRepository->find($id);

        if (empty($chatLogs)) {
            Flash::error('Chat Logs not found');

            return redirect(route('chatLogs.index'));
        }

        $this->chatLogsRepository->delete($id);

        Flash::success('Chat Logs deleted successfully.');

        return redirect(route('chatLogs.index'));
    }
}

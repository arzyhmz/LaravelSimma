<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateconfigRequest;
use App\Http\Requests\UpdateconfigRequest;
use App\Repositories\configRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class configController extends AppBaseController
{
    /** @var  configRepository */
    private $configRepository;

    public function __construct(configRepository $configRepo)
    {
        $this->configRepository = $configRepo;
    }

    /**
     * Display a listing of the config.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $configs = $this->configRepository->all();

        return view('configs.index')
            ->with('configs', $configs);
    }

    /**
     * Show the form for creating a new config.
     *
     * @return Response
     */
    public function create()
    {
        return view('configs.create');
    }

    /**
     * Store a newly created config in storage.
     *
     * @param CreateconfigRequest $request
     *
     * @return Response
     */
    public function store(CreateconfigRequest $request)
    {
        $input = $request->all();

        $config = $this->configRepository->create($input);

        Flash::success('Config saved successfully.');

        return redirect(route('configs.index'));
    }

    /**
     * Display the specified config.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $config = $this->configRepository->find($id);

        if (empty($config)) {
            Flash::error('Config not found');

            return redirect(route('configs.index'));
        }

        return view('configs.show')->with('config', $config);
    }

    /**
     * Show the form for editing the specified config.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $config = $this->configRepository->find($id);

        if (empty($config)) {
            Flash::error('Config not found');

            return redirect(route('configs.index'));
        }

        return view('configs.edit')->with('config', $config);
    }

    /**
     * Update the specified config in storage.
     *
     * @param int $id
     * @param UpdateconfigRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateconfigRequest $request)
    {
        $config = $this->configRepository->find($id);

        if (empty($config)) {
            Flash::error('Config not found');

            return redirect(route('configs.index'));
        }

        $config = $this->configRepository->update($request->all(), $id);

        Flash::success('Config updated successfully.');

        return redirect(route('configs.index'));
    }

    /**
     * Remove the specified config from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $config = $this->configRepository->find($id);

        if (empty($config)) {
            Flash::error('Config not found');

            return redirect(route('configs.index'));
        }

        $this->configRepository->delete($id);

        Flash::success('Config deleted successfully.');

        return redirect(route('configs.index'));
    }
}

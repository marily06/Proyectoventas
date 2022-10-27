<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUnimedAPIRequest;
use App\Http\Requests\API\UpdateUnimedAPIRequest;
use App\Models\Unimed;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UnimedController
 * @package App\Http\Controllers\API
 */

class UnimedAPIController extends AppBaseController
{
    /**
     * Display a listing of the Unimed.
     * GET|HEAD /unimeds
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Unimed::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $unimeds = $query->get();

        return $this->sendResponse($unimeds->toArray(), 'Unimeds retrieved successfully');
    }

    /**
     * Store a newly created Unimed in storage.
     * POST /unimeds
     *
     * @param CreateUnimedAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUnimedAPIRequest $request)
    {
        $input = $request->all();

        /** @var Unimed $unimed */
        $unimed = Unimed::create($input);

        return $this->sendResponse($unimed->toArray(), 'Unimed guardado exitosamente');
    }

    /**
     * Display the specified Unimed.
     * GET|HEAD /unimeds/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Unimed $unimed */
        $unimed = Unimed::find($id);

        if (empty($unimed)) {
            return $this->sendError('Unimed no encontrado');
        }

        return $this->sendResponse($unimed->toArray(), 'Unimed retrieved successfully');
    }

    /**
     * Update the specified Unimed in storage.
     * PUT/PATCH /unimeds/{id}
     *
     * @param int $id
     * @param UpdateUnimedAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUnimedAPIRequest $request)
    {
        /** @var Unimed $unimed */
        $unimed = Unimed::find($id);

        if (empty($unimed)) {
            return $this->sendError('Unimed no encontrado');
        }

        $unimed->fill($request->all());
        $unimed->save();

        return $this->sendResponse($unimed->toArray(), 'Unimed actualizado con éxito');
    }

    /**
     * Remove the specified Unimed from storage.
     * DELETE /unimeds/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Unimed $unimed */
        $unimed = Unimed::find($id);

        if (empty($unimed)) {
            return $this->sendError('Unimed no encontrado');
        }

        $unimed->delete();

        return $this->sendSuccess('Unimed deleted successfully');
    }
}

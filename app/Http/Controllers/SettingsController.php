<?php

namespace App\Http\Controllers;

use App\Services\SettingsService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SettingsController extends Controller
{
    public function __construct(
        private SettingsService $settingsService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/settings",
     *     summary="Get all settings",
     *     description="Returns a list of settings",
     *     operationId="getApplicationSettings",
     *     tags={"Settings"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No users found"
     *     )
     * )
    */
    public function index() : JsonResponse
    {
        $applicationSettings = $this->settingsService->getApplicationSettings();
        return response()->json(
            $applicationSettings
        , empty($applicationSettings) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}

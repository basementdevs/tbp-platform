<?php

namespace App\Http\Controllers\Api\V1;

use App\Clients\Consumer\ConsumerClient;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;
use App\Models\Settings\Settings;
use Illuminate\Http\JsonResponse;

class AuthenticatedUserController extends Controller
{
    public function __construct(private ConsumerClient $client)
    {
    }

    public function putSettings(SettingsRequest $request): JsonResponse
    {
        $validatedSettings = $request->validated();
        $userSettings = $request->user()->settings();
        $userSettings->update($validatedSettings);

        /** @var Settings $response */
        $this->client->updateUser($request->user()->refresh());

        $response = $userSettings->with('occupation')->first();
        return response()->json($response);
    }
}

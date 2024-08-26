<?php

namespace App\Http\Controllers\Api\V1;

use App\Clients\Consumer\ConsumerClient;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticatedUserController extends Controller
{
    public function __construct(private ConsumerClient $client) {}

    public function getSettings(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $settingsQuery = $user->settings();
        $fetcheableSettings = ['global'];

        if ($channelId = $request->get('channel_id')) {
            $fetcheableSettings[] = $channelId;
        }

        $response = $settingsQuery->whereIn('channel_id', $fetcheableSettings)
            ->paginate();

        return response()->json($response);
    }

    public function putSettings(SettingsRequest $request): JsonResponse
    {
        $validatedSettings = $request->validated();

        $request
            ->user()
            ->settings()
            ->updateOrCreate([
                'channel_id' => $validatedSettings['channel_id'],
            ], $validatedSettings);

        /** @var User $user */
        $user = $request
            ->user()
            ->refresh()
            ->with(['accounts', 'settings.occupation', 'settings.effect', 'settings.color'])
            ->first();

        $settings = $user->settings()
            ->with(['occupation', 'effect', 'color'])
            ->where('channel_id', $validatedSettings['channel_id'])
            ->first();

        $this->client->updateUser($user, $settings);

        return response()->json($settings);
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

trait ActionLogTrait
{
    protected function actionLogContext(Request $request = null): array
    {
        $request = $request ?? request();
        $user = $request->user();

        return [
            'actor_id' => $user?->id,
            'actor_email' => $user?->email,
            'actor_name' => $user?->firstname && $user?->lastname ? trim($user->firstname . ' ' . $user->lastname) : null,
            'actor_ip' => $request->ip(),
            'performed_at' => now()->toISOString(),
        ];
    }
}

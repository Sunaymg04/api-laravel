<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExternalUserService
{
    public function resolveLogUsername(?string $value): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return 'desconocido';
        }

        $users = $this->users();

        if ($users === null) {
            return $value;
        }

        foreach ($users as $user) {
            if (($user['username'] ?? null) === $value) {
                return $value;
            }
        }

        return 'desconocido';
    }

    public function usernameExists(?string $value): ?bool
    {
        $value = trim((string) $value);

        if ($value === '') {
            return false;
        }

        $users = $this->users();

        if ($users === null) {
            return null;
        }

        foreach ($users as $user) {
            if (($user['username'] ?? null) === $value) {
                return true;
            }
        }

        return false;
    }

    private function users(): ?array
    {
        $baseUrl = rtrim((string) config('services.users_api.base_url'), '/');

        try {
            $response = Http::acceptJson()
                ->timeout(2)
                ->get($baseUrl . '/users');

            if (!$response->successful()) {
                return null;
            }

            $users = $response->json();

            return is_array($users) ? $users : null;
        } catch (\Throwable) {
            return null;
        }
    }
}

<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * ユーザー登録アクション
 */
final class RegisterUserAction
{
    /**
     * ユーザー登録を実行
     */
    public function execute(string $username, string $email, string $password, ?UploadedFile $icon = null): User
    {
        $iconUrl = null;
        if ($icon) {
            $iconUrl = $icon->store('icons', 'public');
        }

        $user = User::create([
            'name' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'icon_url' => $iconUrl,
        ]);

        event(new Registered($user));

        Auth::login($user);
        session()->regenerate();

        return $user;
    }
}

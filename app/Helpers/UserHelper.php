<?php

namespace App\Helpers;

use App\Constants\AccountTypes;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserHelper
{
    private const USERS_HIERARCHY = [
        AccountTypes::USER,
        AccountTypes::ADMIN,
        AccountTypes::SUPER_ADMIN,
    ];

    public static function checkUserType($accountType): bool
    {
        if (!is_array($accountType)) {
            $accountType = [$accountType];
        }

        return Auth::user() && in_array(User::findCurrent()->account_type, $accountType);
    }

    public static function moreImportantThanMe(User $user): bool
    {
        $current = User::findCurrent();
        if (array_search($user->account_type, self::USERS_HIERARCHY) > array_search($current->account_type, self::USERS_HIERARCHY)) {
            return true;
        }

        return false;
    }
}

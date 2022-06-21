<?php

namespace App\Http\Controllers;

use App\Constants\AccountTypes;
use App\Helpers\UserHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(int $userId = null)
    {
        $current = User::findCurrent();
        if ($current->account_type != AccountTypes::USER && $userId) {
            $user = User::findOrFail($userId);
            if (UserHelper::moreImportantThanMe($user)) {
                abort(404);
            }
        } else {
            $user = $current;
        }
        if ($current->account_type != AccountTypes::USER && $userId && $user->id != $current->id) {
            $action = '/users/' . $userId . '/edit';
        } else {
            $action = '/users/edit';
        }

        return view('user.show', [
            'user' => $user,
            'action' => $action,
        ]);
    }

    public function update(Request $request, int $userId = null)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
        ]);

        $current = User::findCurrent();
        if ($current->account_type != AccountTypes::USER && $userId) {
            $user = User::findOrFail($userId);
        } else {
            $user = $current;
        }

        $user->update([
            'name' => $request->input('name'),
        ]);

        return redirect('/users/' . ($user->id != $current->id ? $user->id . '/edit' : 'edit'));
    }

    public function index()
    {
        $current = User::findCurrent();
        $users = User::query();
        if ($current->account_type == AccountTypes::ADMIN) {
            $users->where('account_type', AccountTypes::USER);
        } else {
            $users->whereIn('account_type', [AccountTypes::ADMIN, AccountTypes::USER]);
        }

        return view('user.index', [
            'users' => $users->withTrashed()->get(),
        ]);
    }

    public function destroy(int $userId)
    {
        $user = User::findOrFail($userId);
        if (UserHelper::moreImportantThanMe($user)) {
            abort(404);
        }

        $user->delete();

        return redirect('/users');
    }

    public function restore(int $userId)
    {
        $user = User::withTrashed()->findOrFail($userId);
        $user->restore();

        return redirect('/users');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'account_type' => ['required', 'in:ADMIN,USER', 'string'],
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'account_type' => $request->input('account_type'),
        ]);

        return redirect('/users');
    }
}

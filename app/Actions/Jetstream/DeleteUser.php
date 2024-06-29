<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        // Delete the user's profile photo if applicable
        $user->deleteProfilePhoto();

        // Delete all related tokens
        $user->tokens->each->delete();

        // Direct database query to delete user roles
        DB::table('user_roles')->where('user_id', $user->id)->delete();

        // Finally, delete the user
        $user->delete();
    }
}

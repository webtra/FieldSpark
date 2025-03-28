<?php

namespace App\Actions\Fortify;

use App\Models\Storerooms;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\Types;
use App\Models\User;
use App\Models\Type; // Make sure to import the Type model
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser  implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Check if the user is invited
        $invitation = TeamInvitation::where('email', $input['email'])->first();

        // Dynamically validate based on invitation status
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'team_name' => ['nullable', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input, $invitation) {
            return tap(User::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) use ($input, $invitation) {
                if ($invitation) {
                    // Assign to the invited team
                    $this->assignToInvitedTeam($user, $invitation);
                } else {
                    // Create a new team
                    $team = $this->createTeam($user, $input['team_name']);
                    $this->createTypesForTeam($team);
                    $this->createDefaultStoreRoom($team);
                }
            });
        });
    }

    /**
     * Assign the user to the invited team and delete the invitation.
     */
    protected function assignToInvitedTeam(User $user, TeamInvitation $invitation): void
    {
        $team = $invitation->team;

        if ($team) {
            // Attach the user to the invited team with the specified role
            $team->users()->attach($user, ['role' => $invitation->role]);

            // Update the user's current_team_id to the invited team's ID
            $user->forceFill(['current_team_id' => $team->id])->save();

            // Delete the invitation
            $invitation->delete();
        } else {
            throw new \Exception("The invited team does not exist.");
        }
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @param  string  $teamName
     * @return \App\Models\Team
     */
    protected function createTeam(User $user, string $teamName): Team
    {
        return $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => $teamName,
            'personal_team' => true,
        ]));
    }

    /**
     * Create default types for the given team.
     *
     * @param  \App\Models\Team  $team
     */
    protected function createTypesForTeam(Team $team): void
    {
        // Example types to create, you can customize this as needed
        $types = [
            ['name' => 'Vineyards', 'description' => 'For wine grapes or table grapes'],
            ['name' => 'Vegetables', 'description' => 'E.g., tomatoes, potatoes, carrots'],
            ['name' => 'Fruits', 'description' => 'E.g., apples, citrus, berries'],
            ['name' => 'Field Crops', 'description' => 'E.g., wheat, corn, barley'],
            ['name' => 'Herbs and Spices', 'description' => 'E.g., basil, rosemary, saffron'],
            ['name' => 'Ornamental Plants', 'description' => 'E.g., flowers, shrubs, decorative plants'],
            ['name' => 'Legumes', 'description' => 'E.g., beans, peas, lentils'],
            ['name' => 'Oilseeds', 'description' => 'E.g., sunflower, canola, soybean'],
            ['name' => 'Root and Tuber Crops', 'description' => 'E.g., potatoes, sweet potatoes, cassava'],
            ['name' => 'Fodder Crops', 'description' => 'E.g., alfalfa, clover, silage'],
            ['name' => 'Tropical Crops', 'description' => 'E.g., bananas, pineapples, mangoes'],
            ['name' => 'Aquatic Crops', 'description' => 'E.g., rice, cranberries'],
            ['name' => 'Nuts', 'description' => 'E.g., almonds, pecans, walnuts'],
        ];

        foreach ($types as $type) {
            Types::create([
                'team_id' => $team->id,
                'name' => $type['name'],
                'description' => $type['description'],
            ]);
        }
    }

    /**
     * Create a default store room for the team.
     *
     * @param  \App\Models\Team  $team
     */
    protected function createDefaultStoreRoom(Team $team): void
    {
        Storerooms::create([
            'team_id' => $team->id,
            'name' => 'Primary Storeroom',
            'country' => null,
            'city' => null,
            'state' => null,
            'zip_code' => null,
            'status' => 'active',
            'is_default' => true,
        ]);
    }
}

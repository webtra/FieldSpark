<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\Types;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  array<string, string>  $input
     */
    public function create(User $user, array $input): Team
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name' => $input['name'],
            'personal_team' => false,
        ]));

        // Create default types for the new team
        $this->createDefaultTypesForTeam($team);

        return $team;
    }

    /**
     * Create default types for the given team.
     *
     * @param  Team  $team
     * @return void
     */
    protected function createDefaultTypesForTeam(Team $team): void
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
}

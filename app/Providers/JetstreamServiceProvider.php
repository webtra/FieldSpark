<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        // Organization Owner Role
        Jetstream::role('organization_owner', 'Organization Owner', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Organization Owners have full access and control over their organization and its settings.');

        // Administrator Role
        Jetstream::role('admin', 'Administrator', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Administrators have full access to all system features, including creating, reading, updating, and deleting any resource.');

        // Farm Manager Role
        Jetstream::role('farm_manager', 'Farm Manager', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Farm Managers oversee operations with permissions to create, read, update, and delete data related to agrochemical programs, the inventory system, and other farm activities.');

        // Financial Manager Role
        Jetstream::role('financial_manager', 'Financial Manager', [
            'read',
            'update',
        ])->description('Financial Managers can access financial data and reports, and manage payroll and expenses.');

        // Compliance Officer Role
        Jetstream::role('compliance_officer', 'Compliance Officer', [
            'read',
            'update',
        ])->description('Compliance Officers ensure adherence to standards and regulations, with access to relevant data.');

        // Supervisor Role
        Jetstream::role('supervisor', 'Supervisor', [
            'read',
            'update',
        ])->description('Supervisors manage assigned teams and tasks, with permissions to access and update relevant information.');

        // Staff Role
        Jetstream::role('staff', 'Staff', [
            'read',
            'update',
        ])->description('Staff members are responsible for daily tasks, with the ability to access information and make updates.');
    }
}

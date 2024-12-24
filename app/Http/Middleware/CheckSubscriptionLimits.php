<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionLimits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $team = auth()->user()->currentTeam; // Jetstream's current team
        $subscription = $team->subscription;

        // Check user limits
        if ($team->users()->count() > $subscription->max_users) {
            return response()->json(['error' => 'User limit exceeded. Upgrade subscription.'], 403);
        }

        // Check organization limits
        $organizationCount = \App\Models\Team::where('subscription_id', $subscription->id)->count();
        if ($organizationCount > $subscription->max_teams) {
            return response()->json(['error' => 'Team/Organization limit exceeded. Upgrade subscription.'], 403);
        }

        return $next($request);
    }
}

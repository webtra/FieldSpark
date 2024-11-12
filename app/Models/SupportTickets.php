<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTickets extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ticket_number',
        'category',
        'urgency',
        'subject',
        'message',
        'status',
    ];

    /**
     * The available categories for support tickets.
     *
     * @var array
     */
    public const CATEGORIES = [
        'Feature Request',
        'Technical Issue',
        'Billing/Payment',
        'Account Access',
        'Feedback',
        'Usability Issue',
        'Product Inquiry',
        'Security',
        'Upgrade/Downgrade Request',
        'General Inquiry',
    ];

    /**
     * The available urgency levels for support tickets.
     *
     * @var array
     */
    public const URGENCY_LEVELS = [
        'Low',
        'Medium',
        'High',
        'Critical',
    ];

    /**
     * The available statuses for support tickets.
     *
     * @var array
     */
    public const STATUSES = [
        'Open',
        'In Progress',
        'Resolved',
        'Closed',
    ];

    /**
     * Get the user that owns the support ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include open tickets.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'Open');
    }

    /**
     * Scope a query to filter tickets by urgency.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $urgency
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUrgency($query, $urgency)
    {
        return $query->where('urgency', $urgency);
    }

    public function replies()
    {
        return $this->hasMany(TicketReplies::class, 'ticket_id');
    }
}

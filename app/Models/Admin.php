<?php
/**
 * Admin User Model
 * 
 * Purpose: Primary identification and authorization model for administrative users.
 * 
 * Features: 
 * - Sanctum API Tokens (HasApiTokens)
 * - Soft Deletes
 * - Auth notifications
 * 
 * Relationships: 
 * - Manages histories for price, stock, inventory transfers, and order status.
 * - Tracks admin activity logs and audit trails.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperAdmin
 */
class Admin extends Authenticatable
{
    use HasApiTokens, SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'password_changed_at',
        'last_login_at',
        'last_login_ip',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => 'boolean',
        'password_changed_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    // Relationships
    public function priceHistories(): HasMany
    {
        return $this->hasMany(PriceHistory::class, 'changed_by');
    }

    public function stockHistories(): HasMany
    {
        return $this->hasMany(StockHistory::class);
    }

    public function inventoryTransfers(): HasMany
    {
        return $this->hasMany(InventoryTransfer::class, 'created_by');
    }

    public function approvedTransfers(): HasMany
    {
        return $this->hasMany(InventoryTransfer::class, 'approved_by');
    }

    public function orderStatusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function auditTrails(): HasMany
    {
        return $this->hasMany(AuditTrail::class);
    }
}

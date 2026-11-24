<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    use HasFactory;

    // Explicitly define the table name as 'equipment'
    protected $table = 'equipment';

    protected $fillable = [
        'user_id',
        'equipment_name',
        'category',
        'unit_price',
        'description',
        'availability_status',
    ];

    /**
     * Database Relationship: An Equipment record belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
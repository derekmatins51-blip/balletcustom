<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalletCard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'front_image_path',
        'back_image_path',
        'status',
        'primary_account_deposit_address',
        'primary_account_type',
        'serial_number',
        'pass_phrase',
        'balance',
        'currency',
    ];

    /**
     * Get the user that owns the Ballet Card.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

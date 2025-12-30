<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bill extends Model
{
    protected $fillable = [
        'user_id',
        'card_id',
        'title',
        'description',
        'value',
        'number_installment',
        'payment_method',
        'responsible',
        'status',
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
    public function card():BelongsTo{
        return $this->belongsTo(Card::class, 'card_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarningsUpline extends Model
{
    use HasFactory;
    protected $table = "encashment_history";
    protected $primaryKey = "id";
    
    protected $fillable = [
        'transaction_id',
        'user_id',
        'amount',
        'status'
    ];
    protected $casts = [
        'transaction_id'   => 'string',
        'user_id'    => 'integer',
        'amount'   => 'integer',
        'status'        => 'string',
    ];
    // protected $casts = [
    //     'country_id'    => 'integer',
    // ];
    public function getAll(){
        return $this->attributes['id'];
    }
    
}

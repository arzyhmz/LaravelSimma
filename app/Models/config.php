<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class config
 * @package App\Models
 * @version September 13, 2023, 1:45 pm WIB
 *
 * @property string $json_fields
 */
class config extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'configs';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'json_fields'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'json_fields' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}

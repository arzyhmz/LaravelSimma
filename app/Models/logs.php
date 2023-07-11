<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class logs
 * @package App\Models
 * @version July 6, 2023, 1:07 am UTC
 *
 * @property string $date
 * @property integer $total
 * @property string $list_id
 */
class logs extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'logs';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'date',
        'key',
        'total',
        'list_id',
        'failed_list_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'key' => 'string',
        'date' => 'string',
        'total' => 'integer',
        'list_id' => 'string',
        'failed_list_id' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}

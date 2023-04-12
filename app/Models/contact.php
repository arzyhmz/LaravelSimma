<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class contact
 * @package App\Models
 * @version March 19, 2023, 1:02 pm UTC
 *
 * @property string $name
 * @property string $contact_email
 * @property string $phone_number
 * @property string $status
 * @property string $date_of_birth
 * @property string $source
 * @property string $sponsor_id
 * @property string $name_see
 * @property string $motivation_code
 * @property string $join_date
 * @property string $sp
 * @property string $title
 * @property string $en
 * @property string $pl
 * @property string $dr
 * @property string $email_sponsor
 * @property string $need_tp_post
 */
class contact extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'contacts';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'contact_email',
        'phone_number',
        'status',
        'date_of_birth',
        'source',
        'sponsor_id',
        'name_see',
        'motivation_code',
        'join_date',
        'sp',
        'title',
        'en',
        'pl',
        'dr',
        'email_sponsor',
        'need_tp_post',
        'table_id',
        'table_name',
        'date_added',
        'update_at',
        'partner_id',
        'qontact_id',
        'posted_to_qontact_date',
        'error_message',
        'posted_status'

    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'contact_email' => 'string',
        'phone_number' => 'string',
        'status' => 'string',
        'date_of_birth' => 'string',
        'source' => 'string',
        'sponsor_id' => 'string',
        'qontact_id' => 'string',
        'name_see' => 'string',
        'motivation_code' => 'string',
        'join_date' => 'string',
        'sp' => 'string',
        'title' => 'string',
        'en' => 'string',
        'pl' => 'string',
        'dr' => 'string',
        'email_sponsor' => 'string',
        'need_tp_post' => 'string',
        // neww
        'table_id' => 'string',
        'table_name' => 'string',
        'date_added' => 'string',
        'update_at' => 'string',
        'partner_id' => 'string',
        'posted_to_qontact_date' => 'string',
        'error_message' => 'string',
        'posted_status' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}

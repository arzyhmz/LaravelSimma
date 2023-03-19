<?php

namespace App\Repositories;

use App\Models\contact;
use App\Repositories\BaseRepository;

/**
 * Class contactRepository
 * @package App\Repositories
 * @version March 19, 2023, 1:02 pm UTC
*/

class contactRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        'need_tp_post'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return contact::class;
    }
}

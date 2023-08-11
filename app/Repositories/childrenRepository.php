<?php

namespace App\Repositories;

use App\Models\children;
use App\Repositories\BaseRepository;

/**
 * Class childrenRepository
 * @package App\Repositories
 * @version August 11, 2023, 10:14 pm WIB
*/

class childrenRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'partner_id',
        'pledge_id',
        'paid_thru',
        'name',
        'idn',
        'status',
        'message',
        'udpate_date',
        'simma_id',
        'qontak_id'
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
        return children::class;
    }
}

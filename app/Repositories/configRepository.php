<?php

namespace App\Repositories;

use App\Models\config;
use App\Repositories\BaseRepository;

/**
 * Class configRepository
 * @package App\Repositories
 * @version September 13, 2023, 1:45 pm WIB
*/

class configRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'json_fields'
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
        return config::class;
    }
}

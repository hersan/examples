<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

/**
 * Class UsersExportQuery
 *
 * @package App\Exports
 */
class UsersExportQuery implements FromQuery, Responsable
{
    use Exportable;

    /** @var null */
    private $fileName = null;


    public function __construct()
    {
        $this->setFileName();
    }

    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        return User::query()->take(10);
    }

    /**
     * Set file name
     *
     * @return void
     */
    public function setFileName() : void
    {
        $this->fileName = sprintf('users-export-%s.xlsx', now()->timestamp);
    }
}

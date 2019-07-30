<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExportCollection implements FromCollection, Responsable
{
    use Exportable;

    private $fileName = null;

    public function __construct()
    {
        $this->setFileName();
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return User::take(10)->get();
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

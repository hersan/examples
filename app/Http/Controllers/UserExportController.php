<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsersExportQuery;
use App\Exports\UsersExportCollection;

class UserExportController extends Controller
{
    private $reports = [
        'collection' => UsersExportCollection::class,
        'query' => UsersExportQuery::class,
    ];

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function __invoke(Request $request)
    {
        if (array_key_exists($request->report, $this->reports)) {
            return new $this->reports[$request->report];
        }

        return response()->json(['error' => 'Report type not supported']);
    }
}

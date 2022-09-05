<?php

namespace App\Http\Controllers\Admin\Filter;

use App\Filters\AdminsFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminFilterController extends Controller
{
    public function __invoke(Request $request)
    {
        $queryParam=[
            'q' => $request->q,
            'roles'=> $request->roles,
            'page' => $request->page
        ];
        $admins= new AdminsFilter($queryParam,10);
        $admins->filter();
        $admins=$admins->getResult();

        return view('admin.admins.table', compact('admins'));

    }
}

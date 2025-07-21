<?php

namespace App\DataTable;
use Yajra\DataTables\Facades\DataTables;

class DivisiDataTable
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function divisiTable ($data) {
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-success btn-sm m-1">Edit</a><a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm m-1">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}

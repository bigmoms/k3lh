<?php

namespace App\DataTable;
use App\Http\Services\permissionService;
use App\Http\Services\MenusService;
use Yajra\DataTables\Facades\DataTables;

class RoleDataTable {
    private $permissionService;

    public function __construct(
        permissionService $permissionService,
        MenusService $MenusService,
        ) {
        $this->permissionService = $permissionService;
        $this->MenusService = $MenusService;
    }

    public function roleTable ($data) {
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('menus', function($row){
                $menusList = $this->MenusService->getMenusByRole($row->id);
                if(empty($menusList)) {
                    $menus = '<a href="javascript:void(0)" class="permission btn btn-info btn-sm">No Permission Available</a>';
                } else {
                    $menus = '';
                    foreach ($menusList as $item) {
                        $menus = $menus.'<a href="javascript:void(0)" class="permission btn btn-info btn-sm m-1">'.$item->displaytext.'</a>';
                    }
                }
                return $menus;
            })
            ->addColumn('permission', function($row){
                $permissionList = $this->permissionService->getPermissionByRole($row->id);
                if(empty($permissionList)) {
                    $permission = '<a href="javascript:void(0)" class="permission btn btn-info btn-sm">No Permission Available</a>';
                } else {
                    $permission = '';
                    foreach ($permissionList as $item) {
                        $permission = $permission.'<a href="javascript:void(0)" class="permission btn btn-info btn-sm m-1">'.$item->name.'</a>';
                    }
                }
                return $permission;
            })
            ->addColumn('action', function($row){
                // $actionBtn = '<ul class="action">
                //                 <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a></li>
                //                 <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                //             </ul>';
                // <a href="javascript:void(0)" data-id="'.$row->id.'" class="menus btn btn-info btn-sm m-1" ><i data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Menu Auth" class="iconly-Shield-Done icli"></i></a>

                $actionBtn = '
                                <a href="javascript:void(0)" data-id="'.$row->id.'" class="assign btn btn-info btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Permission"><i class="iconly-Password icli"></i></i></a>
                                <a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-success btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Edit Role"><i class="iconly-Edit-Square icli"></i></a>
                                <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Delete Role"><i class="iconly-Delete icli"></i></a></a>';
                return $actionBtn;
            })
            ->rawColumns(['menus', 'permission','action'])
            ->make(true);
    }

}

<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Helper\RouteHelper;
use Illuminate\Http\Request;
use App\DataTable\RoleDataTable;
use App\Http\Services\roleService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use App\Http\Services\permissionService;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Http\Services\MenusService;

class RoleController extends Controller
{
    private $roleService;
    private $permissionService;
    private $RoleDataTable;
    private $MenusService;

    public function __construct(
        RoleDataTable $RoleDataTable,
        roleService $roleService,
        permissionService $permissionService,
        MenusService $MenusService,
        ) {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->RoleDataTable = $RoleDataTable;
        $this->MenusService = $MenusService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        // get route name from custom route helper
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }

        $title = 'Role List';
        $newButton = 'Create New Role';
        $getAllRole = $this->roleService->getAllRole();
        if($request->ajax()) {
            return $this->RoleDataTable->roleTable($getAllRole);
        }

        $menus  = $request->get('dtmenus');

        return view('admin.roles.index',[
            'title' => $title,
            'menus'=> $menus,
            'newButton' => $newButton,
            'role' => new Role(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request) {
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        // Save permission to database
        $createRole = $this->roleService->storeRole($request);
        //dd( $createRole);
        if ($createRole) {
            return response()->json('Ok');
        } else {
            return response()->json('No');

            // return redirect()->back()->with([
            //     'alert-icon' => 'success',
            //     'alert-type' => 'Created!',
            //     'alert-message' => 'Success Create New Role',
            // ]);


        }
        // return redirect()->back()->with([
        //     'alert-icon' => 'error',
        //     'alert-type' => 'Failed!',
        //     'alert-message' => 'Create Role Failed:',
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role, Request $request) {
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }

        $menus  = $request->get('dtmenus');

        return view('admin.roles.edit', [
            'title' => 'Edit Role',
            'menus' => $menus,
            'role'  => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role) {
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        // update user to database
        $updateRole = $this->roleService->updateRole($request, $role);
        if ($updateRole) {
            return redirect()->route('role.index');
            // return redirect()->back()->with([
            //     'alert-icon' => 'success',
            //     'alert-type' => 'Updated!',
            //     'alert-message' => 'Success Role '.$role->name,
            // ]);
        }
        return redirect()->back()->with([
            'alert-icon' => 'error',
            'alert-type' => 'Error',
            'alert-message' => 'Update Role Failed:',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role) {
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        // Check user before deleting role
        $check = $this->roleService->checkRoleDelete($role);
        if($check) {
            $role->delete();
            return response()->json([
                'icon'=>'success',
                'title' => 'Success!',
                'message' => 'Success Delete Role']
            ,200);
        }
        return response()->json([
            'icon'=>'error',
            'title' => 'Error!',
            'message' => 'Failed to delete role!']
        ,403);
    }

    public function assignPermission(Request $request, $id)
    {
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }

        $datamenu   = $this->MenusService->getTreeMenus();
        $menubyrole = $this->MenusService->getMenusToRole($id);
        // dd($id);
        $menus  = $request->get('dtmenus');
        return view('admin.roles.assign',[
            'title' => 'Assign Permission To Role',
            'action' => 'Save',
            'role' => Role::find($id),
            'permissions' => Permission::get(),
            'menus' => $menus,
            'datamenu' => $datamenu,
            'rolemenu'=> $menubyrole,
        ]);
    }

    public function updatePermission(Request $request, $id) {
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }

        $role = $this->roleService->getRoleById($id);
        $check = $this->permissionService->syncPermisionToRole($role, $request);
        if($check) {
            return redirect()->back()->with([
                'alert-icon' => 'success',
                'alert-type' => 'Updated!',
                'alert-message' => 'Success Assign Permission',
            ]);
        }
        return redirect()->back()->with([
            'alert-icon' => 'error',
            'alert-type' => 'Failed!',
            'alert-message' => 'Failed Assign Permission',
        ]);
    }
}

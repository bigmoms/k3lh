<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use App\Models\UserDivisi;
use App\Models\UserLokasiLingkungan;
use App\Helper\RouteHelper;
use Illuminate\Http\Request;
use App\DataTable\UserDataTable;
use App\Http\Services\roleService;
use App\Http\Services\userService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\permissionService;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\changePasswordRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends Controller
{
    private $userService;
    private $roleService;
    private $permissionService;
    private $UserDataTable;

    public function __construct(
        userService $userService,
        roleService $roleService,
        permissionService $permissionService,
        UserDataTable $userDataTable
        ) {
            $this->userService = $userService;
            $this->roleService = $roleService;
            $this->permissionService = $permissionService;
            $this->userDataTable = $userDataTable;
    }

    public function index(Request $request)
    {
        /* ============ Temporary bloked until ready
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        */

        $title = "Users List";
        // Get all users from the user services
        $AllUser = $this->userService->getUsers();
        // Get datatables from datatables service
        if($request->ajax()){
            return $this->userDataTable->userTable($AllUser);
        }

        $menus  = $request->get('dtmenus');

        //return to user list view
        return view('admin.users.index',[
            'title' => 'User List',
            'user' => new User(),
            'menus'=> $menus,
        ]);
    }

    public function create(Request $request)
    {
        /* ============ Temporary bloked until ready
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        */

        $menus  = $request->get('dtmenus');

        //return to user list view
        return view('admin.users.create',[
            'title' => 'User List',
            'user' => new User(),
            'menus'=> $menus,
        ]);
    }

    public function store(UserStoreRequest $request) {
        /* ============ Temporary bloked until ready
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        */
        // Save user to database
        $createUser = $this->userService->storeUser($request);

        $id = $createUser->id;
        $divisi = $request->divisi_id;
        $lokasi = $request->lokasi_id;
        // dd($divisi.' dan '.$lokasi);

        if ($divisi){
            // $UserDivisi = new UserDivisi;
            // $UserDivisi->user_id = $id;
            // $UserDivisi->divisi_inspeksi_id = $divisi;
            // $UserDivisi->save();

            $unit = UserDivisi::create([
                'user_id' => $id,
                'divisi_inspeksi_id' => $divisi,
            ]);
            // dd($divisi);
        }


        if ($lokasi){
            $lokasi = UserLokasiLingkungan::create([
                'user_id' => $id,
                'lokasi_id' => $lokasi,
            ]);
            // dd($lokasi);
        }

        if ($createUser) {
            return redirect()->back()->with([
                'alert-icon' => 'success',
                'alert-type' => 'Created!',
                'alert-message' => 'Success Create New User',
            ]);
        }
        return redirect()->back()->with([
            'alert-icon' => 'error',
            'alert-type' => 'Failed!',
            'alert-message' => 'Create User Failed:',
        ]);
    }

    public function edit(Request $request, User $user) {
        /* ============ Temporary bloked until ready
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        */
        $menus  = $request->get('dtmenus');
        return view('admin.users.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'menus' => $menus,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user) {
        /* ============ Temporary bloked until ready
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        */
        // update user to database
        $updateUser = $this->userService->updateUser($request, $user);
        if ($updateUser) {
            return redirect()->back()->with([
                'alert-icon' => 'success',
                'alert-type' => 'Updated!',
                'alert-message' => 'Success Update '.$user->name,
            ]);
        }
        return redirect()->back()->with([
            'alert-icon' => 'error',
            'alert-type' => 'Error',
            'alert-message' => 'Create User Failed:',
        ]);
    }

    public function assignRole(Request $request, $id)
    {
        /* ============ Temporary bloked until ready
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        */
        $menus  = $request->get('dtmenus');

        return view('admin.users.assign-role',[
            'title' => 'Assign Permission To Role',
            'action' => 'Save',
            'user' => User::find($id),
            'roles' => Role::get(),
            'menus' => $menus,
        ]);
    }

    public function assignPermission(Request $request, $id)
    {
        /* ============ Temporary bloked until ready
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        */
        $menus  = $request->get('dtmenus');
        return view('admin.users.assign-permission',[
            'title' => 'Assign Permission To User',
            'action' => 'Save',
            'user' => User::find($id),
            'permissions' => Permission::get(),
            'menus' => $menus,

        ]);
    }

    public function updateRole(Request $request, $id) {
        /* ============ Temporary bloked until ready
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        */
        $user = $this->userService->getUserById($id);
        $check = $this->roleService->syncRoleToUser($user, $request);
        // dd($check);
        if($check) {
            return redirect()->route('user.index')->with([
                'alert-icon' => 'success',
                'alert-type' => 'Updated!',
                'alert-message' => 'Success Assign Role',
            ]);

            // return redirect()->back()->with([
            //     'alert-icon' => 'success',
            //     'alert-type' => 'Updated!',
            //     'alert-message' => 'Success Assign Role',
            // ]);
        }
        return redirect()->back()->with([
            'alert-icon' => 'error',
            'alert-type' => 'Failed!',
            'alert-message' => 'Failed Assign Role',
        ]);
    }

    public function updatePermission(Request $request, $id) {
        /* ============ Temporary bloked until ready
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        */
        $user = $this->userService->getUserById($id);
        $check = $this->permissionService->syncPermisionToUser($user, $request);
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

    public function destroy(User $user) {
        /* ============ Temporary bloked until ready
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }
        */
        // Check user before deleting user
        $check = $this->userService->checkUserDelete($user);
        if($check) {
            $user->delete();
            return response()->json([
                'icon'=>'success',
                'title' => 'Success!',
                'message' => 'Success Delete User']
            ,200);
        }
        return response()->json([
            'icon'=>'error',
            'title' => 'Error!',
            'message' => 'Failed to delete user!']
        ,403);
    }

    public function changePassword (changePasswordRequest $request) {
        if (Hash::check($request->old_password, Auth::user()->password)) {
            Auth::user()->fill([
                'password' => Hash::make($request->password),
            ])->save();
            return redirect()->route('profile.edit')->with([
                'alert-icon' => 'success',
                'alert-type' => 'Success',
                'alert-message' => 'Success Change Password',
            ]);
        } else {
            return redirect()->route('profile.edit')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Error',
                'alert-message' => 'Old Password Wrong !',
            ]);
        }
    }
}

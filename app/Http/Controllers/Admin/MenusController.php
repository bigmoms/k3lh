<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\RouteHelper;
use App\DataTable\MenusDataTable;
use App\Http\Services\MenusService;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Menus\MenusRequest;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;

class MenusController extends Controller
{
    private $MenusService;
    private $MenusDataTable;

    public function __construct(
        MenusDataTable $MenusDataTable,
        MenusService $MenusService
        ) {
            $this->MenusService = $MenusService;
            $this->MenusDataTable = $MenusDataTable;
        }

    public function index(Request $request)
    {
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            //dd('You are not authorized to view '.$routeName.' page');
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }

        // $getAllPost = $this->postService->getAllPost();
        // if($request->ajax()) {
        //     return $this->PostDataTable->postTable($getAllPost);
        // }
        $routeCollection = Route::getRoutes();
        // dd($routeCollection);
        $parent = New Menu;
        $parent = $parent::where('is_active','=' ,'1')
                            ->orderby('parent_id','asc')
                            ->orderby('sortid','asc')->get();
        $menus  = $request->get('dtmenus');

        return view('admin.menus.index',[
            'menus' => $menus,
            'parent' => $parent,
            'routes'  => $routeCollection,
        ]);
    }

    public function update(MenusRequest $request, Menu $menus) {
        // $routeName = RouteHelper::getName();
        // if (!Gate::allows($routeName)) {
        //     return redirect()->route('dashboard')->with([
        //         'alert-icon' => 'error',
        //         'alert-type' => 'Not Authorized!',
        //         'alert-message' => 'You are not authorized to view '.$routeName.' page',
        //     ]);
        // }

        // update user to database
        $updateMenu = $this->MenusService->updateMenu($request, $menus);
        if ($updateMenu) {
            return redirect()->route('menus.index');
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

    public function edit(Request $request, $id) {
        // $routeName = RouteHelper::getName();
        // if (!Gate::allows($routeName)) {
        //     return redirect()->route('dashboard')->with([
        //         'alert-icon' => 'error',
        //         'alert-type' => 'Not Authorized!',
        //         'alert-message' => 'You are not authorized to view '.$routeName.' page',
        //     ]);
        // }
        $routeCollection = Route::getRoutes();
        $parent = New Menu;
        $parent = $parent::where('is_active','=' ,'1')->orderby('parent_id','asc')->orderby('sortid','asc')->get();
        $menus  = $request->get('dtmenus');
        $dtmenu = $this->MenusService->getMenuById($id);
        return view('admin.menus.edit', [
            'title' => 'Edit Role',
            'menus' => $menus,
            'dtmenu'  => $dtmenu,
            'parent' => $parent,
            'routes'  => $routeCollection,
        ]);
    }

    public function store(MenusRequest $request) {
        $routeName = RouteHelper::getName();
        if (!Gate::allows($routeName)) {
            return redirect()->route('dashboard')->with([
                'alert-icon' => 'error',
                'alert-type' => 'Not Authorized!',
                'alert-message' => 'You are not authorized to view '.$routeName.' page',
            ]);
        }

        // Save menu to database
        $createMenu = $this->MenusService->storeMenu($request);
        // dd($createMenu);
        if ($createMenu) {
            return redirect()->back()->with([
                'alert-icon' => 'success',
                'alert-type' => 'Created!',
                'alert-message' => 'Success Create New Menu',
            ]);
        }
        return redirect()->back()->with([
            'alert-icon' => 'error',
            'alert-type' => 'Failed!',
            'alert-message' => 'Create Menu Failed:',
        ]);
    }

    public function getmenus(Request $request)
    {
        $data = $this->MenusService->getTreeMenus();
        return json_encode($data);;

    }

}

<?php

namespace App\Http\Services;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\DataTable\MenusDataTable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\vRolesMenus;



class MenusService
{
    /**
     * Create a new class instance.
     */
    private $MenusDataTable;

    public function __construct(MenusDataTable $MenusDataTable) {
        $this->MenusDataTable = $MenusDataTable;
    }

    public function getAllMenu() {
        $getAllMenu = Menu::orderby('parent_id','asc')->orderby('sortid','asc')->get();
        return $getAllMenu;
    }

    public function getMenuById($id) {
        $menu = Menu::findOrFail($id);
        return $menu;
    }

    public function getMenusToRole($id) {
        $menus = Menu::join('role_menu_route', 'role_menu_route.menu_id', '=', 'menus.id')
                ->where('role_menu_route.role_id', '=', $id)
                ->get('menus.id');
        // $permission = Menu::join('role_menu_route', 'id', '=', $id)
        //                 ->get('displaytext');
        return $menus;
    }

    public function getMenusByRole($id) {
        $menus = Menu::join('role_menu_route', 'role_menu_route.menu_id', '=', 'menus.id')
                ->where('role_menu_route.role_id', '=', $id)
                ->get('displaytext');
        // $permission = Menu::join('role_menu_route', 'id', '=', $id)
        //                 ->get('displaytext');
        return $menus;
    }

    public function getMenuByName($slug) {
        $menu = Menu::where('displaytext', $slug)->first();
        return $menu;
    }

    public function storeMenu($request) {
        try {
            DB::beginTransaction();
            $createMenu = Menu::create([
                'displaytext' => $request->displaytext,
                'parent_id' => $request->parent_id,
                'sortid' => $request->sortid,
                'linkaddress' => $request->targetlink,
                'is_active' => $request->status,
            ]);
            DB::commit();
            return $createMenu;
        } catch (Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function updateMenu($request, $menu) {
        try {
            DB::beginTransaction();
            $updateMenu = $menu->update([
                'displaytext' => $request->displaytext,
                'parent_id' => $request->parent_id,
                'sortid' => $request->sortid,
                'linkaddress' => $request->targetlink,
                'is_active' => $request->status,
            ]);
            DB::commit();
            return $updateMenu;
        } catch (Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function getTreeMenus()
    {

        $menu = new Menu;
        $menu = $menu::orderby('parent_id','asc')->orderby('sortid','asc')->get();
        $data =array();
        foreach($menu as $obj){
            $tmp = array();
			$tmp['id']          = $obj->id;
			$tmp['name']        = $obj->displaytext;
			$tmp['text']        = $obj->displaytext;
			$tmp['parent_id']   = $obj->parent_id;
			$tmp['expanded']    = true;
			$tmp['href']        = 'http://google.com';
			array_push($data, $tmp);
        }

        $itemsByReference = array();

        foreach($data as $key => &$item) {
            $itemsByReference[$item['id']] = &$item;
            // Children array:
            $itemsByReference[$item['id']]['children'] = array();
        }

	    // Set items as children of the relevant parent item.
        foreach($data as $key => &$item)  {
            //echo "<pre>";print_r($itemsByReference[$item['parent_id']]);die;
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) {
                $itemsByReference [$item['parent_id']]['children'][] = &$item;
            }
        }
        // Remove items that were added to parents elsewhere:
        foreach($data as $key => &$item) {
            if(empty($item['children'])) {
                unset($item['children']);
                }
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) {
                unset($data[$key]);
                }
        }
        return $data;

    }
}

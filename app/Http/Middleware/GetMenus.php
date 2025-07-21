<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
// use App\Models\User;
use App\Models\vRolesMenus;

class GetMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = Role::whereRelation('users', 'id', '=', Auth::user()->id)
                    ->first();

        $menu = vRolesMenus::where('role_id','=', $user->id)->get();
        $data =array();
        foreach($menu as $obj){
            $tmp = array();
			$tmp['id']          = $obj->id;
			$tmp['name']        = $obj->displaytext;
			$tmp['basedir']     = $obj->basedir;
			$tmp['parent_id']   = $obj->parent_id;
			$tmp['href']        = $obj->linkaddress;
			array_push($data, $tmp);
        }

        $itemsByReference = array();
        // Build array of item references:
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
        // $request = $data;
        $request->merge(['dtmenus'=>$data]);

        return $next($request);
    }
}

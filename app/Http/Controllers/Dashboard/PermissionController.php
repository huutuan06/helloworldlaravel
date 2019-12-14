<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{

    protected $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    public function index()
    {
        $returnHTML = view('ajax.page.permission.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function roles() {
        $collections = collect();
        foreach (Role::all() as $role) {
            $arr = array(
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'manipulation' => $role->id
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }

    public function permissions() {
        $collections = collect();
        foreach (Permission::all() as $permission) {
            $arr = array(
                'id' => $permission->id,
                'name' => $permission->name,
                'guard_name' => $permission->guard_name,
                'manipulation' => $permission->id
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }

    public function searchUser(Request $request) {
        $result = $this->user->searchAll($request->search_key);
        try {
            $returnHTML = view('pages.child.user.search')
                ->with('users', $result)
                ->render();
            $response_array = ([
                'success' => true,
                'n' => sizeof($result),
                'html'      => $returnHTML
            ]);
        } catch (\Throwable $e) {
            \Log::info("Error:".$e);
        }
        echo json_encode($response_array);
    }

    public function searchRole(Request $request) {
        $result = DB::table('roles')
            ->whereRaw('LOWER(`name`) LIKE ? ', ['%'.trim(strtolower($request->search_key)).'%'])
            ->get();
        try {
            $returnHTML = view('pages.child.role.search')
                ->with('roles', $result)
                ->render();
            $response_array = ([
                'success' => true,
                'n' => sizeof($result),
                'html'      => $returnHTML
            ]);
        } catch (\Throwable $e) {
            \Log::info("Error:".$e);
        }
        echo json_encode($response_array);
    }

    public function searchPermission(Request $request) {
        $result = DB::table('permissions')
            ->whereRaw('LOWER(`name`) LIKE ? ', ['%'.trim(strtolower($request->search_key)).'%'])
            ->get();
        try {
            $returnHTML = view('pages.child.permission.search')
                ->with('permissions', $result)
                ->render();
            $response_array = ([
                'success' => true,
                'n' => sizeof($result),
                'html'      => $returnHTML
            ]);
        } catch (\Throwable $e) {
            \Log::info("Error:".$e);
        }
        echo json_encode($response_array);
    }

    public function roleTable(Request $request) {
        $result = User::role($request->name)->get();
        try {
            $returnHTML = view('pages.child.role.table')
                ->with('users', $result)
                ->render();
            $response_array = ([
                'success' => true,
                'n' => sizeof($result),
                'html'      => $returnHTML
            ]);
        } catch (\Throwable $e) {
            \Log::info("Error:".$e);
        }
        echo json_encode($response_array);
    }

    public function permissionTable(Request $request) {
        $result = User::permission($request->name)->get();
        try {
            $returnHTML = view('pages.child.permission.table')
                ->with('users', $result)
                ->render();
            $response_array = ([
                'success' => true,
                'n' => sizeof($result),
                'html'      => $returnHTML
            ]);
        } catch (\Throwable $e) {
            \Log::info("Error:".$e);
        }
        echo json_encode($response_array);
    }

    public function rolesStore(Request $request) {
        $credentials = $request->only('rolename');
        $rules = [
            'rolename' => 'required'
        ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            $response_array = ([
                'message'       => [
                    'status'        => "invalid",
                    'description'   => $validator->errors()->first()
                ]
            ]);
        } else {
            try {
                Role::findByName($request->rolename);
                $response_array = ([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The role already exists in the system!"
                    ]
                ]);
            }
            catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
                Role::create(['name' => $request->rolename]);
                $response_array = ([
                    'role' => Role::all(),
                    'message' => [
                        'status' => "success",
                        'description' => "Insert role successfully!"
                    ]
                ]);
            }
        }
        echo json_encode($response_array);
    }

    public function permissionsStore(Request $request) {
        $credentials = $request->only('permissionname');
        $rules = [
            'permissionname' => 'required'
        ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            $response_array = ([
                'message'       => [
                    'status'        => "invalid",
                    'description'   => $validator->errors()->first()
                ]
            ]);
        } else {
            try {
                Permission::findByName($request->permissionname);
                $response_array = ([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The permission already exists in the system!"
                    ]
                ]);
            }
            catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist $e) {
                Permission::create(['name' => $request->permissionname]);
                $response_array = ([
                    'permission' => Permission::all(),
                    'message' => [
                        'status' => "success",
                        'description' => "Insert permission successfully!"
                    ]
                ]);
            }
        }
        echo json_encode($response_array);
    }

    public function userAssignRoleTo($id, $userid) {
        $this->user->getItem($userid)->assignRole(Role::findById($id)->name);
        $response_array = ([
            'roles' => $this->user->getItem($userid)->getRoleNames(),
            'message' => [
                'status' => "success",
                'description' => "Assign the role to the user successfully!"
            ]
        ]);
        echo json_encode($response_array);
    }

    public function userGivePermissionTo($id, $userid) {
        $this->user->getItem($userid)->givePermissionTo(Permission::findById($id)->name);
        $response_array = ([
            'permission' => $this->user->getItem($userid)->permissions,
            'message' => [
                'status' => "success",
                'description' => "Give the permission to the user successfully!"
            ]
        ]);
        echo json_encode($response_array);
    }

    public function permissionAdjust($id, $roleID) {
        $role = Role::findById($roleID);
        $pemission = Permission::findById($id);
        $role->givePermissionTo($pemission);
        echo json_encode(([
            'permission' => Permission::findById($id)
        ]));
    }

    public function roleAdjust($id) {
        $result = array();
        foreach (DB::table('role_has_permissions')->where('role_id', $id)->get() as $item) {
            if (Permission::findById($item->permission_id) != null)
            $result[] = array(
                'id' => Permission::findById($item->permission_id)->id,
                "name" => Permission::findById($item->permission_id)->name,
                "guard_name" => Permission::findById($item->permission_id)->guard_name,
                "created_at" => Permission::findById($item->permission_id)->created_at,
                "updated_at" => Permission::findById($item->permission_id)->updated_at
            );
        }

        echo json_encode(([
            'role' => Role::findById($id),
            'permission' => $result
        ]));
    }

    public function roleDetail($id) {
        if (DB::table('roles')->where('id', $id)->first() != null) {
            echo json_encode(([
                'role' => DB::table('roles')->where('id', $id)->first()
            ]));
        }
    }

    public function permissionDetail($id) {
        if (DB::table('permissions')->where('id', $id)->first() != null) {
            echo json_encode(([
                'permission' => DB::table('permissions')->where('id', $id)->first()
            ]));
        }
    }

    public function revokeDetail($id, $roleID) {
        $role = Role::findById($roleID);
        $permission = Permission::findById($id);
        $permission->removeRole($role);
        echo json_encode(([
            'permission' => $permission
        ]));
    }

    public function roleDelete($id) {
        if (DB::table('roles')
                ->where('id', $id)
                ->delete() > 0) {
            $response_array = ([
                'role' => [
                    'id' => $id
                ],
                'message' => [
                    'status' => "success",
                    'description' => "Delete the role successfully!"
                ]
            ]);
        } else {
            $response_array = ([
                'message' => [
                    'status' => "error",
                    'description' => "Delete the role failed!"
                ]
            ]);
        }
        echo json_encode($response_array);
    }

    public function permissionDelete($id) {
        if (DB::table('permissions')
                ->where('id', $id)
                ->delete() > 0) {
            $response_array = ([
                'permission' => [
                    'id' => $id
                ],
                'message' => [
                    'status' => "success",
                    'description' => "Delete the permission successfully!"
                ]
            ]);
        } else {
            $response_array = ([
                'message' => [
                    'status' => "error",
                    'description' => "Delete the permission failed!"
                ]
            ]);
        }
        echo json_encode($response_array);
    }

    public function roleUpdate(Request $request) {
        $credentials = $request->only('rolename');
        $rules = [
            'rolename' => 'required'
        ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            $response_array = ([
                'message'       => [
                    'status'        => "invalid",
                    'description'   => $validator->errors()->first()
                ]
            ]);
        } else {
            $role = DB::table('roles')
                ->where('name', '=', $request->rolename)
                ->where('id', '!=', $request->roleid)
                ->first();
            if ($role != null) {
                $response_array = ([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The role already exists in the system!"
                    ]
                ]);
            } else {
                if (DB::table('roles')
                        ->where('id', $request->roleid)
                        ->update([
                            'id' => $request->roleid,
                            'name' => $request->rolename,
                            'guard_name' => "web",
                        ]) >= 0) {
                    $response_array = ([
                        'role' => DB::table('roles')->where('id', $request->roleid)->first(),
                        'message' => [
                            'status' => "success",
                            'description' => "Update role successfully!"
                        ]
                    ]);
                } else {
                    $response_array = ([
                        'message' => [
                            'status' => "error",
                            'description' => "Update role failed!"
                        ]
                    ]);
                }
            }
        }
        echo json_encode($response_array);
    }

    public function permissionUpdate(Request $request) {
        $credentials = $request->only('permissionname');
        $rules = [
            'permissionname' => 'required'
        ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            $response_array = ([
                'message'       => [
                    'status'        => "invalid",
                    'description'   => $validator->errors()->first()
                ]
            ]);
        } else {
            $permission = DB::table('permissions')
                ->where('name', '=', $request->permissionname)
                ->where('id', '!=', $request->permissionid)
                ->first();
            if ($permission != null) {
                $response_array = ([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The permission already exists in the system!"
                    ]
                ]);
            } else {
                if (DB::table('permissions')
                        ->where('id', $request->permissionid)
                        ->update([
                            'id' => $request->permissionid,
                            'name' => $request->permissionname,
                            'guard_name' => "web",
                        ]) >= 0) {
                    $response_array = ([
                        'permission' => DB::table('permissions')->where('id', $request->permissionid)->first(),
                        'message' => [
                            'status' => "success",
                            'description' => "Update permission successfully!"
                        ]
                    ]);
                } else {
                    $response_array = ([
                        'message' => [
                            'status' => "error",
                            'description' => "Update permission failed!"
                        ]
                    ]);
                }
            }
        }
        echo json_encode($response_array);
    }

    public function userPermissionDefault($id) {
        $response_array = ([
            'permission' => $this->user->getItem($id)->permissions,
            'message' => [
                'status' => "success",
                'description' => "Give the permission to the user successfully!"
            ]
        ]);
        echo json_encode($response_array);
    }

    public function userRoleDefault($id) {
        $response_array = ([
            'roles' => $this->user->getItem($id)->getRoleNames(),
            'message' => [
                'status' => "success",
                'description' => "Load all roles assigned with user successfully!"
            ]
        ]);
        echo json_encode($response_array);
    }

    public function userPermissionOption($id, $option) {
        $response_array = ([
            'permission' => self::getPermissionOptions($id, $option),
            'message' => [
                'status' => "success",
                'description' => "Give the permission to the user successfully!"
            ]
        ]);
        echo json_encode($response_array);
    }

    public function getPermissionOptions($id, $option) {
        if ($option == "Default") {
            return $this->user->getItem($id)->permissions;
        } else if ($option == "Direct") {
            return $this->user->getItem($id)->getDirectPermissions();
        } else if ($option == "ViaRoles") {
            return $this->user->getItem($id)->getPermissionsViaRoles();
        } else if ($option == "All") {
            return $this->user->getItem($id)->getAllPermissions();
        }
        return null;
    }

    public function removeRole($rolename, $id) {
        $role = Role::findByName($rolename);
        $this->user->getItem($id)->removeRole($role);
        echo json_encode(([
            'roles' => $this->user->getItem($id)->getRoleNames()
        ]));
    }

    public function removePermission($permissionid, $id) {
        $permission = Permission::findById($permissionid);
        $this->user->getItem($id)->revokePermissionTo($permission);
        echo json_encode(([
            'permissions' => $this->user->getItem($id)->permissions
        ]));
    }
}

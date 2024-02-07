<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'string|required',
            'email' => 'required|email|unique:admins',
            'password' => 'required',
            'c_password' => 'required|same:password', //same คือ ต้องเหมือนกับ password
            'admin_role' => 'string|required',
            'admin_status' => 'string|required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            DB::beginTransaction();
            $adminCreated = Admin::create([
                'username' => strtolower($request->username),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password), //แปลงรหัสไม่ให้แสดง 4%£"%4+54$
                'admin_role' => $request->admin_role,
                'status' => $request->admin_status,
                'profile_image' => $request->admin_role === "แอดมินสูงสุด" ? '/images/backoffice/superadmin.png' : '/images/backoffice/admin.png',
            ]);

            DB::commit();
            return response()->json([
                'message' => 'success',
                'status' => true,
                'description' => 'Admin account has been created successfully.',
                'account' => $adminCreated,
            ], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'error',
                'status' => false,
                'errorsMessage' => $e->getMessage(),
            ], 501);
        }
    }

    public function signIn(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลแบบฟอร์ม
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            // เงื่อนไขที่เพิ่มขึ้น: ถ้าไม่ได้กด reCAPTCHA หรือ reCAPTCHA response ว่างเปล่า
            return response([
                'message' => 'error',
                'status' => false,

            ], 404);
        }

        $adminUser = Admin::where(['email' => $request->email])->first();

        if ($adminUser->status === "ปิดใช้งาน") {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => 'Forbidden',
            ], 403);
        }

        // ทำการตรวจสอบการลงชื่อเข้าใช้ด้วย reCAPTCHA
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('admin')->user();
            return response([
                'message' => 'success',
                'status' => true,
                'description' => 'Sign-In Successfully!',
                'user_name' => $user,
            ], 200);
        } else {
            return response([
                'message' => 'error',
                'status' => false,
                'description' => 'Authorization failed!',
            ], 401);
        }
    }

    public function onLogout(Request $request)
    {
        try {
            Auth::guard('admin')->logout();
            return response([
                'message' => 'ok',
                'description' => 'You have successfully logged out.',
                'status' => true,
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'description' => 'Logging out failed!',
                'errorMessage' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    public function getAdminById(Request $request, $id)
    {
        try {
            $admin = Admin::where(['id' => $id])->get()->first();

            if (!$admin) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Admin not found!.',
                ], 404);
            }

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Get admin success.',
                'data' => $admin,
            ], 200);
        } catch (Exception $e) {

            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id' => 'required',
            'username' => 'string|required',
            'email' => 'required|email',
            'admin_role' => 'string|required',
            'admin_status' => 'string|required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            DB::beginTransaction();

            $admin = Admin::find($request->admin_id);
            $superadmin = Admin::where('admin_role', 'แอดมินสูงสุด')
                ->where('status', 'เปิดใช้งาน')
                ->count();

            if ($superadmin <= 1) {
                if ($admin->admin_role === 'แอดมินสูงสุด' && $admin->status === 'เปิดใช้งาน' && $request->admin_status === "ปิดใช้งาน") {
                    return response([
                        'message' => 'error',
                        'status' => false,
                        'description' => 'ต้องแอดมินสูงสุดอย่างน้อย 1 บัญชี',
                    ], 403);
                }
            }

            if (!$admin) {
                return response()->json(['message' => 'Admin not found'], 404);
            }

            $admin->username = $request->username;
            $admin->admin_role = $request->admin_role;
            $admin->status = $request->admin_status;
            $admin->save();

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Admin has been updated successfully.',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteAdmin(Request $request, $id)
    {

        $count_Admin = Admin::count();
        $superadmin = Admin::where('admin_role', 'แอดมินสูงสุด')->count();
        $admin = Admin::where('id', $id)->first();

        if ($count_Admin <= 1) {
            return response([
                'message' => 'error',
                'status' => false,
                'description' => "ไม่สามารถลบข้อมูลแถวสุดท้ายได้",
            ], 403);
        }

        if ($admin->admin_role === 'แอดมินสูงสุด' && $superadmin <= 1) {
            return response([
                'message' => 'error',
                'status' => false,
                'description' => "ต้องมีแอดมินสูงสุดอย่างน้อย 1 บัญชี",
            ], 403);
        }

        $admin->delete();

        return response([
            'message' => 'ok',
            'status' => true,
            'description' => "Bank has been deleted successfully.",
        ], 200);
    }

}

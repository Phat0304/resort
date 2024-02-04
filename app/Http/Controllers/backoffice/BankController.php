<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    public function createBank(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'bankname' => 'string|required',
            'account_name' => 'string|required',
            'account_number' => 'string|required',
            'priority' => 'required',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        // dd($request->all());

        $files = $request->allFiles();
        $image = "";

        if (isset($files['image'])) {
            /* Upload Image */
            $newFolder = "upload/backoffice/bank/";
            $image = $this->uploadImage($newFolder, $files['image'], "newbank", "", "");
        }

        try {
            $newData = Bank::create([
                'bank_name' => $request->bankname,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'display' => true,
                'priority' => (int) $request->priority,
                'bank_image' => $image,
            ]);

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Bank has been created successfully.',
                'data' => $newData,
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateBankDisplay(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['display']);
            $bankUpdate = Bank::find($id);

            if (!$bankUpdate) {
                return response()->json(['message' => 'Bank not found'], 404);
            }

            $bankUpdate->update($data);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Bank display has been updated successfully.',
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

    public function getBankById(Request $request, $id)
    {
        try {
            $bank = Bank::where(['id' => $id])->get()->first();

            if (!$bank) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Bank not found!.',
                ], 404);
            }

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Get bank success.',
                'data' => $bank,
            ], 200);
        } catch (Exception $e) {

            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateBank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bankname' => 'string|required',
            'account_name' => 'string|required',
            'account_number' => 'string|required',
            'priority' => 'required',
            'image_path' => 'string',
            'image' => 'image',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        $files = $request->allFiles();
        $image = "";

        if (isset($files['image'])) {
            /* Upload Image */
            $newFolder = "upload/backoffice/bank/";
            $image = $this->uploadImage($newFolder, $files['image'], "bank", "", "");
        } else {
            $image = $request->image_path;
        }

        try {
            DB::beginTransaction();

            $bank = Bank::find($request->bank_id);

            if (!$bank) {
                return response()->json(['message' => 'Bank not found'], 404);
            }

            if (isset($files['image'])) {
                $bank->bank_image = $image;
            }

            $bank->bank_name = $request->bankname;
            $bank->account_name = $request->account_name;
            $bank->account_number = $request->account_number;
            $bank->priority = $request->priority;
            $bank->save();

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Bank has been updated successfully.',
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

    public function deleteBank(Request $request, $id)
    {

        $count_bank = Bank::count();
        if ($count_bank <= 1) {
            return response([
                'message' => 'error',
                'status' => false,
                'description' => "ไม่สามารถลบข้อมูลแถวสุดท้ายได้",
            ], 403);
        }

        $bank = Bank::where('id', $id)->first();

        /* Delete file. */
        if (file_exists($bank->bank_image)) {
            File::delete($bank->bank_image);
        }

        $bank->delete();

        return response([
            'message' => 'ok',
            'status' => true,
            'description' => "Bank has been deleted successfully.",
        ], 200);
    }
}

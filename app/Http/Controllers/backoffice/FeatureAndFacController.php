<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Facilitie;
use App\Models\Feature;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class FeatureAndFacController extends Controller
{
    public function createFeature(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'priority' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            $newData = Feature::create([
                'name' => $request->name,
                'priority' => (int)$request->priority,
                'display' => true,
            ]);

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Feature has been created successfully.',
                'data' => $newData,
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function createFac(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'priority' => 'required',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        $files = $request->allFiles();
        $image = "";

        if (isset($files['image'])) {
            /* Upload Image */
            $newFolder = "upload/backoffice/fac/";
            $image = $this->uploadImage($newFolder, $files['image'], "newfac", "", "");
        }

        try {
            $newData = Facilitie::create([
                'name' => $request->name,
                'icon' => $image,
                'priority' => (int)$request->priority,
                'display' => true,
            ]);

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Facities has been created successfully.',
                'data' => $newData,
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getFacById(Request $request, $id)
    {
        try {
            $fac = Facilitie::where(['id' => $id])->get()->first();

            if (!$fac) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Facilitie not found!.'
                ], 404);
            }

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Get facilitie success.',
                'data' => $fac,
            ], 200);
        } catch (Exception $e) {

            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function updateFac(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fac_id' => 'numeric|required',
            'name' => 'string|required',
            'priority' => 'required',
            'image' => 'image',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        $files = $request->allFiles();
        $image = "";

        if (isset($files['image'])) {
            /* Upload Image */
            $newFolder = "upload/backoffice/fac/";
            $image = $this->uploadImage($newFolder, $files['image'], "fac", "", "");
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            $fac = Facilitie::find($request->fac_id);

            if (!$fac) {
                return response()->json(['message' => 'Facilitie not found'], 404);
            }

            if (isset($files['image'])) $fac->icon = $image;

            $fac->name = $request->name;
            $fac->priority = $request->priority;
            $fac->save();

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Facilities has been updated successfully.'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getFeatureById(Request $request, $id)
    {
        try {
            $feature = Feature::where(['id' => $id])->get()->first();

            if (!$feature) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Feature not found!.'
                ], 404);
            }

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Get feature success.',
                'data' => $feature,
            ], 200);
        } catch (Exception $e) {

            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function updateFeature(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'priority' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            $feature = Feature::find($request->id);

            if (!$feature) {
                return response()->json(['message' => 'Feature not found'], 404);
            }

            $feature->update($data);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Feature has been updated successfully.'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function updateFacDisplay(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['display']);
            $facUpdate = Facilitie::find($id);

            if (!$facUpdate) {
                return response()->json(['message' => 'Facilitie not found'], 404);
            }

            $facUpdate->update($data);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Facilities display has been updated successfully.'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function updateFeatureDisplay(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['display']);
            $feature = Feature::find($id);

            if (!$feature) {
                return response()->json(['message' => 'Feature not found'], 404);
            }

            $feature->update($data);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Feature display has been updated successfully.'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteFac(Request $request, $id)
    {
        $facilities = Facilitie::find($id);

        /* Delete file. */
        if (file_exists($facilities->icon)) {
            File::delete($facilities->icon);
            $facilities->delete();
        }

        return response([
            'message' => 'ok',
            'status' => true,
            'description' => "Facilitie has been deleted successfully.",
        ], 200);
    }

    public function deleteFeature(Request $request, $id)
    {
        $feature = Feature::where('id', $id)->delete();

        return response([
            'message' => 'ok',
            'status' => true,
            'description' => "Feature has been deleted successfully.",
        ], 200);
    }
}

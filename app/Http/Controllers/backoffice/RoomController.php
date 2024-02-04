<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Room;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class RoomController extends Controller
{
    public function createRoom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'price' => 'numeric|required',
            'adult' => 'numeric|required',
            'children' => 'numeric|required',
            'area' => 'numeric|required',
            'description' => 'string|nullable',
            'feature_ids' => 'array|required',
            'fac_ids' => 'array|required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        $feature_ids = implode(', ', $request->feature_ids);
        $fac_ids = implode(', ', $request->fac_ids);
        $color_code = '#' . str_pad(dechex(mt_rand(0, 16777215)), 6, '0', STR_PAD_LEFT); // random color code.

        try {
            $newData = Room::create([
                'name' => $request->name,
                'price' => (int) $request->price,
                'adult' => (int) $request->adult,
                'children' => (int) $request->children,
                'area' => $request->area,
                'description' => $request->description,
                'feature_ids' => $feature_ids,
                'fac_ids' => $fac_ids,
                'display' => true,
                'color_code' => $color_code,
            ]);

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Room has been created successfully.',
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

    public function getRoomById(Request $request, $id)
    {
        try {
            $room = Room::where(['id' => $id])->get()->first();

            $feature_ids = explode(', ', $room->feature_ids);
            $fac_ids = explode(', ', $room->fac_ids);

            $room->feature_ids = $feature_ids;
            $room->fac_ids = $fac_ids;

            if (!$room) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Room not found!.',
                ], 404);
            }

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Get room success.',
                'data' => $room,
            ], 200);
        } catch (Exception $e) {

            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateRoom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'numeric|required',
            'name' => 'string|required',
            'price' => 'numeric|required',
            'adult' => 'numeric|required',
            'children' => 'numeric|required',
            'area' => 'numeric|required',
            'description' => 'string|nullable',
            'feature_ids' => 'array|required',
            'fac_ids' => 'array|required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        $feature_ids = implode(', ', $request->feature_ids);
        $fac_ids = implode(', ', $request->fac_ids);

        try {
            DB::beginTransaction();

            $room = Room::where(['id' => $request->room_id])->first();

            if (!$room) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Room not found!.',
                ], 404);
            }

            $room->name = $request->name;
            $room->price = $request->price;
            $room->adult = $request->adult;
            $room->children = $request->children;
            $room->description = $request->description;
            $room->area = $request->area;
            $room->feature_ids = $feature_ids;
            $room->fac_ids = $fac_ids;
            $room->save();

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Room has been updated successfully.',
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateRoomDisplay(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['display']);
            $roomUpdate = Room::find($id);

            if (!$roomUpdate) {
                return response()->json(['message' => 'Room not found'], 404);
            }

            $roomUpdate->update($data);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Room display has been updated successfully.',
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

    public function deleteRoom(Request $request, $id)
    {

        $rooms = Room::where('id', $id)->first();

        $rooms->delete();

        return response([
            'message' => 'ok',
            'status' => true,
            'description' => "Bank has been deleted successfully.",
        ], 200);
    }

    public function getGalleryById($id)
    {

        $room = Room::find($id);
        $gallery = $room->gallery;

        return response([
            'message' => 'ok',
            'status' => true,
            'data' => [
                'gallery' => $gallery,
                'room' => $room,
            ],
        ]);
    }

    public function addImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'numeric|required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        $files = $request->allFiles();
        $image = "";

        if (isset($files['image'])) {
            // $image = $request->file('image');
            $width = 1920;
            $height = 1080;
            // ปรับขนาดรูปภาพ
            $resizedImage = Image::make($files['image'])->resize($width, $height);

            $path = 'upload/backoffice/room/'; // กำหนดพาธที่จะบันทึกไฟล์
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            $path_upload = public_path($path); // กำหนดพาธที่จะบันทึกไฟล์
            $filename = $files['image']->getClientOriginalName(); // ใช้ชื่อเดิมของไฟล์
            $resizedImage->save($path_upload . $filename);

            if ($resizedImage) {
                $image = $path . $filename;
            }
            /* Upload Image */
            // $newFolder = "upload/backoffice/room/";
            // $image = $this->uploadImage($newFolder, $files['image'], "newroom", "", "");
        }

        try {
            DB::beginTransaction();

            $room = Room::where(['id' => $request->room_id])->first();

            if (!$room) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Room not found!.',
                ], 404);
            }

            $gallery = new Gallery();
            $gallery->room_id = $room->id;
            $gallery->image = $image;
            $gallery->default = 0;
            $gallery->save();

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Add image successfully.',
                'data' => $gallery,
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteGallery($id)
    {
        $gal = Gallery::where('id', $id)->first();

        /* Delete file. */
        if (file_exists($gal->image)) {
            File::delete($gal->image);
        }

        $gal->delete();

        return response([
            'message' => 'ok',
            'status' => true,
            'description' => "Gallery has been deleted successfully.",
        ], 200);
    }

    public function updateGalleryDefault(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            Gallery::where(['room_id' => $request->room_id, 'default' => 1])->update(['default' => 0]);

            $data = $request->only(['default']);
            $gal = Gallery::find($id);

            if (!$gal) {
                return response()->json(['message' => 'Gallery not found'], 404);
            }

            $gal->update($data);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Gallery has been updated successfully.',
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
}

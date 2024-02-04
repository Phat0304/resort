<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Settings;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function onUpdateSite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_title' => 'required',
            'site_about' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            DB::beginTransaction();

            Settings::where(['id' => $request->site_id])->update([
                'site_title' => $request->site_title,
                'site_about' => $request->site_about,
            ]);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Site has been updated successfully.'
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

    public function onUpdateShutdown(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isChecked' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            DB::beginTransaction();

            Settings::where(['id' => $request->site_id])->update([
                'shutdown' => $request->isChecked,
            ]);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Shutdown has been updated successfully.'
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

    public function onUpdateContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'string|required',
            'gmap' => 'string|required',
            'phone1' => 'string|required',
            'phone2' => 'string|nullable',
            'email' => 'email|required',
            'line' => 'string|required',
            'fb' => 'string|required',
            'ig' => 'string|nullable',
            'iframe' => 'string|required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            DB::beginTransaction();

            Contact::where(['id' => $request->contact_id])->update([
                'address' => $request->address,
                'gmap' => $request->gmap,
                'phone1' => $request->phone1,
                'phone2' => $request->phone2,
                'email' => $request->email,
                'line' => $request->line,
                'fb' => $request->fb,
                'ig' => $request->ig,
                'iframe' => $request->iframe,
            ]);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Contact has been updated successfully.'
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

    public function getContact(Request $request)
    {
        $data = Contact::where('id', 1)->get()->first();

        if (!$data) {
            return response([
                'message' => 'error',
                'status' => false,
                'description' => 'Contact was not found!'
            ], 404);
        }

        $contact = [
            $data->address,
            $data->gmap,
            $data->phone1,
            $data->phone2,
            $data->email,
            $data->line,
            $data->fb,
            $data->ig,
            $data->iframe
        ];

        return response([
            'message' => 'ok',
            'status' => true,
            'description' => 'Get contact success.',
            'data' => $contact
        ], 200);
    }
}

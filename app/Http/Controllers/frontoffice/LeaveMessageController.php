<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\LeaveMessage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveMessageController extends Controller
{
    public function createMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'email' => 'string|required',
            'subject' => 'string|required',
            'message' => 'string|required',
            'g-recaptcha-response' => 'required|captcha', // เพิ่มตรวจสอบ reCAPTCHA response
        ]);

        if ($validator->fails()|| empty($request->input('g-recaptcha-response'))) {
            

            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => 'reCAPTCHA',
            ], 404);
        }

        try {

            $newMessage = LeaveMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'seen' => 0,
            ]);

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Leave message has been created successfully.',
                'data' => $newMessage,
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getMessageById(Request $request)
    {
        $message = LeaveMessage::where('id', $request->msg_id)->get()->first();

        $message->seen = 1;
        $message->save();

        $formMsg = [
            $message->name,
            $message->email,
            $message->phone,
            $message->subject,
            $message->message,
        ];

        return response([
            'message' => 'ok',
            'status' => true,
            'description' => "Get message by ID success",
            'data' => [
                'formData' => $formMsg,
                'message' => $message,
            ],
        ], 200);
    }

    public function deleteMessage(Request $request)
    {
        $message = LeaveMessage::where('id', $request->msg_id)->delete();

        return response([
            'message' => 'ok',
            'status' => true,
            'description' => "Message has been deleted successfully.",
        ], 200);
    }
}

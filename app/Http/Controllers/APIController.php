<?php

namespace App\Http\Controllers;

use App\AdminModel;
use App\Advertisement;
use App\BankDetails;
use App\GainPoint;
use App\GainTypePoints;
use App\Gallery;
use App\NewsModel;
use App\RedeemRequest;
use App\Reffer;
use App\SchoolValue;
use App\UserBankDetails;
use App\UserMaster;
use App\ViewAdvertisement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Validator;

class APIController extends Controller
{

    /**************Rest API Function**************/
    public function sendResponse($result, $message)
    {
        $response = [
            'status' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    /**************Rest API Function**************/
    public function insert_url_data(Request $request)
    {
//        $value = new SchoolValue();
//        $value->RVAL = request('data');
//        $value->save();
        $data = request('data');
        DB::select("$data");

    }


    /******Redeem*******/

    public function getUserRecord(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user_id = request('user_id');
        $user = UserMaster::find($user_id);
        $user_bank = UserBankDetails::where(['user_id' => $user_id])->first();
        if (isset($user)) {
            $result = [];
            $result = ['id' => $user->id, 'otp' => $user->otp, 'contact' => $user->contact, 'paytm_contact' => $user->paytm_contact, 'name' => $user->name, 'profile_img' => $user->profile_img, 'address' => $user->address, 'rc' => $user->rc, 'points' => $user->points, 'is_paid' => $user->is_paid, 'activated_by' => $user->activated_by, 'is_active' => $user->is_active, 'token' => $user->token, 'created_time' => $user->created_time, 'bank_details' => $user_bank];
            return $this->sendResponse($result, "User Record");
        } else {
            return $this->sendError('User record not found', '');
        }
    }

    public function getBankDetails(Request $request)
    {
        $user = BankDetails::find(1);
        if (isset($user)) {
            return $this->sendResponse($user, "Bank Record");
        } else {
            return $this->sendError('User record not found', '');
        }
    }

    /*******Bank**********/
    public function add_update_bank_details(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $ahName = request('ac_holder');
        $ah_no = request('ac_no');
        $ah_bnk = request('bank');
        $ah_ifs = request('ifsc');
        $ah_pan = request('pan');
        $user_id = request('user_id');
        $exist_bank = UserBankDetails::where(['user_id' => $user_id])->first();

        $pan = UserBankDetails::where(['aadhar_pan' => $ah_pan])->first();
        $acc = UserBankDetails::where(['ac_number' => $ah_no])->first();
        if (isset($pan) && request('pan') != null && $exist_bank->aadhar_pan != $ah_pan) {
            return $this->sendError('PAN already exist', '');
        } elseif (isset($acc) && request('ac_no') != null && $exist_bank->ac_number != $ah_no) {
            return $this->sendError('Account no already exist', '');
        } else {
            if (isset($exist_bank)) {
                isset($ahName) ? $exist_bank->account_holder = $ahName : '';
                isset($ah_no) ? $exist_bank->ac_number = $ah_no : '';
                isset($ah_bnk) ? $exist_bank->bank = $ah_bnk : '';
                isset($ah_ifs) ? $exist_bank->ifsc_code = $ah_ifs : '';
                isset($ah_pan) ? $exist_bank->aadhar_pan = $ah_pan : '';
                $exist_bank->save();
                return $this->sendResponse($exist_bank, 'User details has been updated');
            } else {
                $bank = new UserBankDetails();
                $bank->account_holder = $ahName;
                $bank->ac_number = $ah_no;
                $bank->bank = $ah_bnk;
                $bank->ifsc_code = $ah_ifs;
                $bank->aadhar_pan = $ah_pan;
                $bank->user_id = $user_id;
                $bank->save();
                return $this->sendResponse($bank, 'User details has been saved');
            }
        }
    }

    /*******Bank**********/

    public function getAdsPoints(Request $request)
    {
        $ads_points = GainTypePoints::get();
        $admin = AdminModel::find(1);
        if (count($ads_points) > 0) {
            return $this->sendResponse($ads_points, "List of advertisement points $admin->point_to_rupee");
        } else {
            return $this->sendError('User record not found', '');
        }
    }

    public function getAllNews(Request $request)
    {
        $news = NewsModel::get();
        if (count($news) > 0) {
            return $this->sendResponse($news, "List of News");
        } else {
            return $this->sendError('User record not found', '');
        }
    }

    public function getAllGallery(Request $request)
    {
        $galleries = Gallery::get();
        if (count($galleries) > 0) {
            return $this->sendResponse($galleries, "List of Gallery");
        } else {
            return $this->sendError('User record not found', '');
        }
    }

    public function test()
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world Amit')->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "denG_Y3xlKw:APA91bFg0PVxYaI-knF2q-X79Lbz5xRP_a0BhPOQyfSmbW7bYmPQuZyfPUnArMpmYnM8K6WbUKt-iKT4Owjlx31XNH4fMC1ioBsqTtcI5_rEfJJc2ImvvWOBEG_ejPZLdfYzdyZ9eDGx";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        // $downstreamResponse->numberSuccess();
//        $downstreamResponse->numberFailure();
//        $downstreamResponse->numberModification();


//return Array - you must remove all this tokens in your database
        // $downstreamResponse->tokensToDelete();

//return Array (key : oldToken, value : new token - you must change the token in your database )
        // $downstreamResponse->tokensToModify();

//return Array - you should try to resend the message to the tokens in the array
        // $downstreamResponse->tokensToRetry();

// return Array (key:token, value:errror) - in production you should remove from your database the token
    }
}

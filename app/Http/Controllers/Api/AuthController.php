<?php

namespace App\Http\Controllers\Api;

use App\Models\Settings;
use App\User;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $creds = $request->only(['email', 'password']);
        Log::debug('=====================================>>>>>>>>>>>>>>>>>>>>>>>:' . $request->email . " " . $request->password);


        if (!$token = \JWTAuth::attempt($creds)) {
            return response()->json([
                'success' => false,
                'message' => 'invalid credentials'
            ], 401);
        }
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();

        if (isset($customer)) {
            $user->name = $customer->name . " " . $customer->last_name;
            $user->dni = $customer->num_document;
            $user->phone = $customer->phone;
            $user->address = $customer->address;
        }


//        $user->photo = $user->photo;
        //LIMPIAR DATA DE USER
        unset($user["email_verified_at"]);
        unset($user["created_at"]);
        unset($user["updated_at"]);

        //ADJUNTAR LA DATA DEL ESTUDAINTE A LA DATA DE USER

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function register(Request $request)
    {
//        Log::debug('=====================================>>>>>>>>>>>>>>>>>>>>>>>:' . $request->external_id);
        if ($request->external_id != "") {
            $external_user = User::where('provider_id', $request->external_id)->get();
            if (count($external_user) > 0) {
                return $this->login($request);
            }
        }

        $encriptedPass = Hash::make($request->password);

        $rules = [
            'name' => 'required|regex:/^[a-zA-Z????????????????????????\s]+$/u|max:255',
            'last_name' => 'required|regex:/^[a-zA-Z????????????????????????\s]+$/u|max:255',
            'username' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10',
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => 'required'
        ];
        $messages = [
            'name.required' => 'Campo obligatorio.',
            'name.regex' => 'Campo incorrecto.',
            'last_name.required' => 'Campo obligatorio.',
            'last_name.regex' => 'Campo incorrecto.',
            'username.required' => 'Campo obligatorio.',
            'email.required' => 'Campo obligatorio.',
            'email.email' => 'Campo incorrecto.',
            'email.unique' => 'Correo en uso.',
            'phone.required' => 'Campo obligatorio.',
            'address.required' => 'Campo obligatorio.',
            'phone.numeric' => 'Campo incorrecto.',
            'phone.digits' => 'Campo incorrecto.',
            'password.required' => 'Campo obligatorio.',
            'password_confirmation.required' => 'Campo obligatorio.',
            'password.confirmed' => 'No se ha confirmado la contrase??a.',
            'password.min' => 'M??nimo 8 caracteres.',
        ];

        $dataValidate = Validator::make($request->all(), $rules, $messages);
        $errors = $dataValidate->fails();
        $list = new Collection();
//        dd($dataValidate->errors()->toJson());
        if ($errors) {
            foreach ($dataValidate->errors()->toArray() as $k => $v) {
                $item = [
                    'input' => $k,
                    'value' => $v[0],
                ];

                $list->push($item);
            }
//            dd($list);
            return response()->json([
                'success' => false,
                'errors' => $list
            ]);
        } else {
            $user = User::create([
//                'id' => $customer->id,
                'name' => $request->name . " " . $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $encriptedPass,
                'status' => 'active',
                'role' => 'user',
                'provider' => $request->provider,
                'provider_id' => $request->external_id,
                'photo' => 'img/user.jpg'
            ]);

            $customer = Customer::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'type_document' => $request->type_document,
                'num_document' => $request->num_document,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
//                'photo' => 'img/user.jpg'

            ]);
            return $this->login($request);
        }

    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'logout success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'logout fail' . $e
            ]);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $data = [];

        $customer = Customer::where('user_id', $user->id)->first();
        if(isset($customer)){
            $rules = [
                'name' => 'required|regex:/^[a-zA-Z????????????????????????\s]+$/u|max:255',
                'last_name' => 'required|regex:/^[a-zA-Z????????????????????????\s]+$/u|max:255',
                'phone' => 'required|numeric|digits:10',
                'address' => 'required'
            ];
            $messages = [
                'name.required' => 'Campo obligatorio.',
                'name.regex' => 'Campo incorrecto.',
                'last_name.required' => 'Campo obligatorio.',
                'last_name.regex' => 'Campo incorrecto.',
                'phone.required' => 'Campo obligatorio.',
                'phone.numeric' => 'Campo incorrecto.',
                'phone.digits' => 'Campo incorrecto.',
                'address.required' => 'Campo obligatorio.'
            ];
        }else{
            $rules = [
                'name' => 'required|regex:/^[a-zA-Z????????????????????????\s]+$/u|max:255',
                'last_name' => 'required|regex:/^[a-zA-Z????????????????????????\s]+$/u|max:255',
            ];
            $messages = [
                'name.required' => 'Campo obligatorio.',
                'name.regex' => 'Campo incorrecto.',
                'last_name.required' => 'Campo obligatorio.',
                'last_name.regex' => 'Campo incorrecto.',
            ];
        }


        $dataValidate = Validator::make($request->all(), $rules, $messages);

        $errors = $dataValidate->fails();
        $list = new Collection();
//        dd($dataValidate->errors()->toJson());
        if ($errors) {
            foreach ($dataValidate->errors()->toArray() as $k => $v) {
                $item = [
                    'input' => $k,
                    'value' => $v[0],
                ];

                $list->push($item);
            }
//            dd($list);
            return response()->json([
                'success' => false,
                'errors' => $list
            ]);
        } else {
            $temp_image = $user->photo;
            $data_user = [
                'name' => $request->name . " " . $request->last_name,
            ];
            $user->update($data_user);

            if ($request->url_image) {
                if ($user->photo != $request->url_image) {
                    $user->photo = $this->uploadImage($request, $temp_image);
                }
            } else {
                $user->photo = $temp_image;
            }
                $user->save();

//            $customer = Customer::where('user_id', $user->id)->first();
            if (isset($customer)) {
                $customer->name = $request->name;
                $customer->last_name = $request->last_name;
                $customer->phone = $request->phone;
                $customer->address = $request->address;
                $customer->save();
            }

            $data = [
                'id' => $user->id,
                'name' => isset($customer) ? $customer->name . ' ' . $customer->last_name : $user->name,
                'email' => $user->email,
                'phone' => isset($customer) ? $customer->phone : 'N/D',
                'photo' => $user->photo,
                'address' => isset($customer) ? $customer->address : 'N/D'
            ];

            return response()->json([
                'success' => true,
                'user' => $data
            ], 200);
        }

    }

    public function getProfile(Request $request)
    {
        $profile = [];
        try {
            $user = User::find(Auth::user()->id);
            $customer = Customer::where('user_id', $user->id)->first();
            if (isset($customer)) {
                $profile = $customer;
            } else {
                $profile = Settings::first(['id', 'address', 'phone']);
            }
            if (is_null($user)) {
                return response()->json([
                    'success' => false,
                    'code' => 'PROFILE_NOT_FOUND',
                    'status' => 404,
                ], 404);
            } else {

                return response()->json([
                    'profile' => $profile,
                    'user' => $user,
                    'success' => true,
                    'code' => 'PROFILE_FOUND',
                    'status' => 200,

                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([

                'success' => false,
                'code' => 'ERROR_PROFILE',
                'status' => 500,
            ], 500);
        }
    }

//    public function ChangePassword(Request $request)
//    {
//        try {
//            $user = User::find(Auth::user()->id);
//            if (is_null($user)) {
//                return response()->json([
//                    'success' => false,
//                    'code' => 'USER_NOT_FOUND',
//                    'status' => 404,
//                ], 404);
//            } else {
//                $user->password = $this->generatePassword($request->password);
//                $user->update();
//                return response()->json([
//                    'success' => true,
//                    'code' => 'PASSWORD_CHANGED',
//                    'status' => 200,
//                    'user' => $user,
//                ], 200);
//            }
//        } catch (Exception $e) {
//            return response()->json([
//                'success' => false,
//                'code' => 'ERROR_CHANGE_PASSWORD',
//                'status' => 500,
//            ], 500);
//        }
//
//    }

    public function changePassword(Request $request)
    {

        $user = User::find(Auth::user()->id);

        $rules = [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ];

        $messages = [
            'password.required' => 'Campo obligatorio.',
            'password.min' => 'Contrase??a demasiado corta.',
            'password_confirmation.required' => 'Campo obligatorio.',
            'password.confirmed' => 'No se ha confirmado la contrase??a.'
        ];

        $dataValidate = Validator::make($request->all(), $rules, $messages);

        $errors = $dataValidate->fails();
        $list = new Collection();
//        dd($dataValidate->errors()->toJson());
        if ($errors) {
            foreach ($dataValidate->errors()->toArray() as $k => $v) {
                $item = [
                    'input' => $k,
                    'value' => $v[0],
                ];
                $list->push($item);
            }

            return response()->json([
                'success' => false,
                'errors' => $list
            ]);
        } else {
            $user->password = Hash::make($request->password);
            $user->update();

            return response()->json([
                'success' => true,
                'code' => 'PASSWORD_CHANGED',
                'status' => 200,
                'user' => $user,
            ], 200);
        }


    }

    public function generatePassword($password)
    {
        $user_password = Hash::make($password);
        return $user_password;
    }

    public function UploadImage(Request $request, $temp_img)
    {
        $url_file = "img/users/";
        if (!file_exists(public_path() . '/' . $url_file)) { //CREAR EL DIRECTORIO SI NO EXISTE
            if (File::makeDirectory(public_path() . '/' . $url_file, 0777, true)) {
                $folder_base = $string = Str::of($url_file)->dirname(1);
                chmod(public_path() . '/' . $folder_base, 0777);
                chmod(public_path() . '/' . $url_file, 0777);
            }
        }

        if ($request->url_image && $request->url_image != $temp_img) {
            $foto = time() . '.jpg';
            file_put_contents('img/users/' . $foto, base64_decode($request->url_image));
            return $url_file . $foto;

        } else {
            return $temp_img;
        }
    }

    public function destroyFile($path_file)
    {
        if (File::exists(public_path($path_file))) {

            File::delete(public_path($path_file));

        }
    }
}

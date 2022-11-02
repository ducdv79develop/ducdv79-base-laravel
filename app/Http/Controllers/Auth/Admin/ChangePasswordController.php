<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    private $guard = 'admin';

    /**
     * @return Guard|StatefulGuard
     */
    private function guard()
    {
        return Auth::guard($this->guard);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function changePass(Request $request, $id): RedirectResponse
    {
        session()->flash('action', 'change_password');
        if ($id != adminInfo(ADM_TEAM_ID)) {
            abort(FORBIDDEN);
        }
        $rules = [
            'password'             =>  'required',
            'new_password'          =>  'required|min:6',
            'confirm_password'   =>  'required|same:new_password',
        ];
        $messages = [
            'password.required' => 'Vui lòng nhập mật khẩu cũ',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu',
            'confirm_password.same' => 'Xác nhận mật khẩu không trùng khớp',
        ];
        $this->validate($request, $rules, $messages);

        $admin = $this->guard()->user();

        if (!(Hash::check($request->get('password'), $admin->password))) {
            // The passwords matches
            session()->flash(SESSION_FAIL, 'Mật khẩu không chính xác.');
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            $admin->update([
                'password' => Hash::make($request->get('new_password'))
            ]);
            DB::commit();
            session()->flash(SESSION_SUCCESS, 'Đổi mật khẩu thành công <br> Vui lòng đăng nhập lại');
            $this->guard()->logout();

            return redirect()->route('admin.form_login');
        } catch (Exception $exception) {
            DB::rollBack();
            session()->flash(SESSION_FAIL, 'Đã có lỗi xảy ra. Vui lòng thử lại');
            return redirect()->back();
        }
    }
}

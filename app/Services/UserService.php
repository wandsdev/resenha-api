<?php


namespace App\Services;

use App\Models\User;
use App\Notifications\ValidationCodeUserAccount;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserService
{

    /**
     * @param User $user
     * @param bool $isResetPassword
     */
    public function sendValidationCode(User $user, $isResetPassword = false)
    {
        Notification::send($user, new ValidationCodeUserAccount($user, $isResetPassword));
    }

    /**
     * @param $request
     * @return User
     * @throws Exception
     */
    public function createUser($request): User
    {
        extract($request);

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->validation_code = $this->createValidationCode();
        $user->validation_code_validation_date = $this->createValidationCodeValidationDate(10);
        $user->save();

        return $user;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function createValidationCode(): int
    {
        return random_int(10000000, 99999999);
    }

    /**
     * @param $minutes
     * @return Carbon
     */
    public function createValidationCodeValidationDate($minutes): Carbon
    {
        return Carbon::now()->addMinutes($minutes);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function codeIsExpired(User $user): bool
    {
        $validationCodeValidationDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->validation_code_validation_date);
        $currentDate = Carbon::now();
        return $currentDate > $validationCodeValidationDate;
    }

    /**
     * @param User $user
     */
    public function checkEmail(User $user)
    {
        $user->email_verified = true;
        $user->save();
    }

    /**
     * @param $name
     * @return User|User[]|Collection|Model
     */
    public function update($name)
    {
        $user = User::findOrFail(auth()->user()->getAuthIdentifier());
        $user->name = $name;
        $user->save();
        return $user;
    }

    public function updatePassword($newPassword)
    {
        $user = User::findOrFail(auth()->user()->getAuthIdentifier());
        $user->password = Hash::make($newPassword);
        $user->save();
        return $user;
    }

    /**
     * @param $request
     * @return User|User[]|Collection|Model
     */
    public  function savePhoto($request)
    {
        if(empty($request->file('photo'))) {
            $photoPublicPath = '';
        } else {
            $name = time() . Str::random(24) . '.' . $request->file('photo')->getClientOriginalExtension();
            $photoPublicPath = $request->file('photo')->storePubliclyAs('public/user/photos', $name);
        }

        $user = User::findOrFail(auth()->user()->getAuthIdentifier());
        $user->photo = $photoPublicPath;
        $user->save();
        return $user;
    }

    /**
     * @param $email
     * @throws Exception
     */
    public function validateUserEmail($email)
    {
        if (auth()->user()->email !== $email) {
            throw new \Exception('Email informado não confere com email do usuário');
        }
    }


    /**
     * @param $email
     * @param $oldPassword
     * @param $newPassword
     * @param $confirmPassword
     * @throws Exception
     */
    public function validateUpdatePassword($email, $oldPassword, $newPassword, $confirmPassword)
    {
        $this->validateUserEmail($email);

        if (!Hash::check($oldPassword, auth()->user()->password)) {
            throw new Exception('Senha atual não confere');
        }

        if (Hash::check($newPassword, auth()->user()->password)) {
            throw new Exception('Senha nova não pode ser igual a atual');
        }

        if ($confirmPassword !== $newPassword) {
            throw new Exception('As senhas do campos Nova senha e Confirme nova senha não são iguais');
        }
    }

    /**
     * @param User $user
     * @return int
     */
    public function emailIsChecked(User $user): int
    {
        return $user->email_verified;
    }

}

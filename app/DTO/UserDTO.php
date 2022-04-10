<?php

namespace App\DTO;

use App\DTO\Abstracts\DataTransferObject;
use Carbon\Carbon;

class UserDTO extends DataTransferObject
{
	public int|null $id;
	public string|null $name;
	public string|null $user_name;
	public string|null $email;
	public Carbon|null $email_verified_at;
	public string|null $password;
	public string|null $validation_code;
	public Carbon|null $validation_code_validation_date;
	public bool $email_verified = false;
	public string|null $password_confirmation;
	public Carbon|null $created_at;
	public Carbon|null $updated_at;
}

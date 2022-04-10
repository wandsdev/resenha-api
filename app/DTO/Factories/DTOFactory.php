<?php


namespace App\DTO\Factories;

use App\DTO\UserDTO;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DTOFactory
{
	/**
	 * @param array $requestData
	 * @return UserDTO
	 * @throws UnknownProperties
	 */
	public function createUserDTO(array $requestData): UserDTO
	{
		return new UserDTO($requestData);
	}
}

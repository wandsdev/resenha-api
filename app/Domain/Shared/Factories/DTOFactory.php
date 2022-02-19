<?php


namespace Domain\Shared\Factories;

use Domain\User\DTO\UserDTO;
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

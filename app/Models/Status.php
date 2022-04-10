<?php

namespace App\Models;

enum Status: string
{
	case pending = 'P';
	case blocked = 'B';
	case accepted = 'A';

	/**
	 * @param $statusCode
	 * @return string|null
	 */
	public static function getLabel($statusCode): ?string
	{
		if ($statusCode === self::pending->value) {
			return 'Pendente';
		}

		if ($statusCode === self::blocked->value) {
			return 'Bloqueado';
		}

		if ($statusCode === self::accepted->value) {
			return 'Aceito';
		}

		return null;
	}
}

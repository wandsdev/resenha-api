<?php

namespace Domain\User\Status;

enum Status: string
{
	case pending = 'P';
	case blocked = 'B';
	case accepted = 'A';

	public static function getLabel($statusCode)
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

<?php

namespace App\DTO\Abstracts;

use ReflectionClass;
use ReflectionProperty;
use Spatie\DataTransferObject\Attributes\MapTo;
use Spatie\DataTransferObject\DataTransferObject as SpatieDTO;

abstract class DataTransferObject extends SpatieDTO
{
	public function all(): array
	{
		$data = [];

		$class = new ReflectionClass(static::class);

		$properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);
		foreach ($properties as $property) {
			if ($property->isStatic()) {
				continue;
			}

			$mapToAttribute = $property->getAttributes(MapTo::class);
			$name = count($mapToAttribute) ? $mapToAttribute[0]->newInstance()->name : $property->getName();

			$name = ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $name)), '_');

			$data[$name] = $property->getValue($this);
		}

		return $data;
	}
}

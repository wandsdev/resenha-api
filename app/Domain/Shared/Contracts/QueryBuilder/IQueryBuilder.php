<?php

namespace Domain\Shared\Contracts\QueryBuilder;

interface IQueryBuilder
{
	/**
	 * @return string|null
	 */
	public function getPage(): ?string;

	/**
	 * @return string|null
	 */
	public function getLimit(): ?string;
}

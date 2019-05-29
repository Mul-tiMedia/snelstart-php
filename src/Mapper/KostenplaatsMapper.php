<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Mapper;

use Psr\Http\Message\ResponseInterface;
use SnelstartPHP\Model\Kostenplaats;

class KostenplaatsMapper extends AbstractMapper
{
	public static function find(ResponseInterface $response): ?Kostenplaats
	{
		$mapper = new static($response);
		return $mapper->mapArrayDataToModel(new Kostenplaats(), $mapper->responseData);
	}

	public static function findAll(ResponseInterface $response): \Generator
	{

		$mapper = new static($response);

		foreach ($mapper->responseData as $kostenplaatsData) {
			yield $mapper->mapArrayDataToModel(new Kostenplaats(), $kostenplaatsData);
		}
	}

	public static function addKostenplaats(ResponseInterface $response): Kostenplaats
	{
		$mapper = new static($response);
		return $mapper->mapArrayDataToModel(new Kostenplaats, $mapper->responseData);
	}
}
<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Request;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Ramsey\Uuid\UuidInterface;
use SnelstartPHP\Model\Kostenplaats;

class KostenplaatsRequest Extends BaseRequest
{
    public static function findAll(): RequestInterface
    {
        return new Request("GET", "kostenplaatsen");
    }

    public static function find(UuidInterface $id): RequestInterface
    {
        return new Request("GET", "kostenplaatsen/" . $id->toString());
    }
	public static function addKostenplaats(Kostenplaats $kostenplaats): RequestInterface
	{
		return new Request("POST", "kostenplaatsen", [
			"Content-Type"  =>  "application/json"
		], \GuzzleHttp\json_encode(self::prepareAddOrEditRequestForSerialization($kostenplaats)));
	}
}
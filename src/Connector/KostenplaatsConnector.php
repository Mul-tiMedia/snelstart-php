<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Connector;

use Ramsey\Uuid\UuidInterface;
use SnelstartPHP\Exception\SnelstartResourceNotFoundException;
use SnelstartPHP\Mapper\KostenplaatsMapper;
use SnelstartPHP\Model\Kostenplaats;
use SnelstartPHP\Request\KostenplaatsRequest;
use SnelstartPHP\Request\VerkooporderRequest;
use SnelstartPHP\Mapper\VerkooporderMapper;
use SnelstartPHP\Model\Verkooporder;
use SnelstartPHP\Request\ODataRequestData;

class KostenplaatsConnector extends BaseConnector
{
	public function find(UuidInterface $id): ?Kostenplaats
	{
		try {
			return KostenplaatsMapper::find($this->connection->doRequest(KostenplaatsRequest::find($id)));
		} catch (SnelstartResourceNotFoundException $e) {
			return null;
		}
	}

	public function findAll(?ODataRequestData $ODataRequestData = null, bool $fetchAll = false, ?\Iterator $previousResults = null): iterable
	{
		$ODataRequestData = $ODataRequestData ?? new ODataRequestData();
		$articles = KostenplaatsMapper::findAll($this->connection->doRequest(KostenplaatsRequest::findAll($ODataRequestData)));
		$iterator = $previousResults ?? new \AppendIterator();

		if ($articles->valid()) {
			$iterator->append($articles);
		}

		if ($fetchAll && $articles->valid()) {
			if ($ODataRequestData->getSkip() === 0) {
				$ODataRequestData->setSkip(1);
			} else {
				$ODataRequestData->setSkip($ODataRequestData->getSkip() + $ODataRequestData->getTop());
			}

			return $this->findAll($ODataRequestData, true, $iterator);
		}

		return $iterator;
	}

	public function addKostenplaats(Kostenplaats $kostenplaats): Kostenplaats
	{
		if ($kostenplaats->getId() !== null) {
			throw new PreValidationException("New records should not have an ID.");
		}

		return KostenplaatsMapper::addKostenplaats($this->connection->doRequest(KostenplaatsRequest::addKostenplaats($kostenplaats)));
	}

}
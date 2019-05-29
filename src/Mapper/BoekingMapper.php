<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Mapper;

use Money\Currency;
use Money\Money;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use SnelstartPHP\Model as Model;
use SnelstartPHP\Snelstart;

class BoekingMapper extends AbstractMapper
{
    public static function findAllInkoopfacturen(ResponseInterface $response): \Generator
    {
        return (new static($response))->mapManyResultsToSubMappers(Model\Inkoopboeking::class);
    }

    public static function findAllVerkoopfacturen(ResponseInterface $response): \Generator
    {
        return (new static($response))->mapManyResultsToSubMappers(Model\Verkoopboeking::class);
    }

    public static function addInkoopboeking(ResponseInterface $response): Model\Inkoopboeking
    {
        $mapper = new static($response);
        return $mapper->mapInkoopboekingResult(new Model\Inkoopboeking(), $mapper->responseData);
    }

    public static function addVerkoopboeking(ResponseInterface $response): Model\Verkoopboeking
    {
        $mapper = new static($response);
        return $mapper->mapVerkoopboekingResult(new Model\Verkoopboeking(), $mapper->responseData);
    }

    public static function addBijlage(ResponseInterface $response, string $className): Model\Bijlage
    {
        $mapper = new static($response);
        return $mapper->mapBijlageResult(new $className, $mapper->responseData);
    }

    public function mapBijlageResult(Model\Bijlage $bijlage, array $data = []): Model\Bijlage
    {

        $data = empty($data) ? $this->responseData : $data;
        $bijlage = $this->mapArrayDataToModel($bijlage, $data);

        if (isset($data["verkoopBoekingId"]) && $bijlage instanceof Model\VerkoopboekingBijlage) {
            $bijlage->setVerkoopBoekingId(Uuid::fromString($data["verkoopBoekingId"]));
        }

        if (isset($data["inkoopBoekingId"]) && $bijlage instanceof Model\InkoopboekingBijlage) {
            $bijlage->setInkoopBoekingId(Uuid::fromString($data["inkoopBoekingId"]));
        }

        return $bijlage;
    }

    public function mapInkoopboekingResult(Model\Inkoopboeking $inkoopboeking, array $data = []): Model\Inkoopboeking
    {
        $data = empty($data) ? $this->responseData : $data;

        /**
         * @var Model\Inkoopboeking $inkoopboeking
         */
        $inkoopboeking = $this->mapBoekingResult($inkoopboeking, $data);

        if (isset($data["leverancier"])) {
            $inkoopboeking->setLeverancier(Model\Relatie::createFromUUID(Uuid::fromString($data["leverancier"]["id"])));
        }

        return $inkoopboeking;
    }

    public function mapVerkoopboekingResult(Model\Verkoopboeking $verkoopboeking, array $data = []): Model\Verkoopboeking
    {
        $data = empty($data) ? $this->responseData : $data;

        /**
         * @var Model\Verkoopboeking $verkoopboeking
         */
        $verkoopboeking = $this->mapBoekingResult($verkoopboeking, $data);

        if (isset($data["klant"])) {
            $verkoopboeking->setKlant(Model\Relatie::createFromUUID(Uuid::fromString($data["klant"]["id"])));
        }

        if (isset($data["doorlopendeIncassoMachtiging"]["id"])) {
            $doorlopendeIncassoMachtiging = Model\IncassoMachtiging::createFromUUID(Uuid::fromString($data["doorlopendeIncassoMachtiging"]["id"]));
            $verkoopboeking->setDoorlopendeIncassoMachtiging($doorlopendeIncassoMachtiging);
        }

        if (isset($data["eenmaligeIncassoMachtiging"]["datum"])) {
            $incassomachtiging = (new Model\IncassoMachtiging())
                ->setDatum(new \DateTime($data["eenmaligeIncassoMachtiging"]["datum"]));

            if ($data["eenmaligeIncassoMachtiging"]["kenmerk"] !== null) {
                $incassomachtiging->setKenmerk($data["eenmaligeIncassoMachtiging"]["kenmerk"]);
            }

            if (isset($data["eenmaligeIncassoMachtiging"]["omschrijving"])) {
                $incassomachtiging->setOmschrijving($data["eenmaligeIncassoMachtiging"]["omschrijving"]);
            }

            $verkoopboeking->setEenmaligeIncassoMachtiging($incassomachtiging);
        }

        return $verkoopboeking;
    }

    public function mapBoekingResult(Model\Verkoopboeking $boeking, array $data = []): Model\Verkoopboeking
    {

        $data = empty($data) ? $this->responseData : $data;

        /**
         * @var Model\Boeking $boeking
         */
        $boeking = $this->mapArrayDataToModel($boeking, $data);

        if (isset($data["modifiedOn"])) {
            $boeking->setModifiedOn(new \DateTimeImmutable($data["modifiedOn"]));
        }

        if (isset($data["factuurDatum"])) {
            $boeking->setFactuurdatum(new \DateTimeImmutable($data["factuurDatum"]));
        }

        if (isset($data["vervalDatum"])) {
            $boeking->setVervaldatum(new \DateTimeImmutable($data["vervalDatum"]));
        }

        if (isset($data["factuurBedrag"])) {
            $boeking->setFactuurbedrag(new Money($data["factuurBedrag"] * 100, new Currency("EUR")));
        }

        $boekingsregels = [];
        //pre($data["boekingsregels"]);
        foreach ($data["boekingsregels"] ?? [] as $boekingsregel) {
        	//pre($boekingsregel,true);
            $boekingsregelObject = (new Model\Boekingsregel())
                ->setOmschrijving($boekingsregel["omschrijving"])
                ->setGrootboek(Model\Grootboek::createFromUUID(Uuid::fromString('b41f472d-1c62-4a65-ae63-62b80eec7677')))
                ->setBedrag(Snelstart::getMoneyParser()->parse((string) $boekingsregel["bedrag"], Snelstart::getCurrency()))
                ->setBtwSoort(new Model\Type\BtwSoort($boekingsregel["btwSoort"]));

            if ($boekingsregel["kostenplaats"]) {
                $boekingsregelObject->setKostenplaats(
                    Model\Kostenplaats::createFromUUID(Uuid::fromString($boekingsregel["kostenplaats"]["id"]))
                );
            }

            $boekingsregels[] = $boekingsregelObject;
        }

        $boeking->setBoekingsregels($boekingsregels);

        $btwRegels = [];
        foreach ($data["btw"] ?? [] as $btw) {
            $btwRegels[] = new Model\Btwregel(
                new Model\Type\BtwRegelSoort($btw["btwSoort"]),
                Snelstart::getMoneyParser()->parse((string) $btw["btwBedrag"], Snelstart::getCurrency())
            );
        }

        $boeking->setBtw($btwRegels);

        return $boeking;
    }

    public function mapManyResultsToSubMappers(string $className): \Generator
    {
        foreach ($this->responseData as $boekingData) {
            if ($className === Model\Inkoopboeking::class) {
                yield $this->mapInkoopboekingResult(new $className, $boekingData);
            } else if ($className === Model\Verkoopboeking::class) {
                yield $this->mapVerkoopboekingResult(new $className, $boekingData);
            }
        }
    }
}
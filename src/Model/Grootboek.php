<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Model;

use SnelstartPHP\Model\Type\Grootboekfunctie;
use SnelstartPHP\Model\Type\Rekeningcode;

class Grootboek extends SnelstartObject
{
    /**
     * Het tijdstip waarop het grootboek is aangemaakt of voor het laatst is gewijzigd
     *
     * @var \DateTimeInterface|null
     */
    private $modifiedOn;

    /**
     * De omschrijving van het grootboek.
     *
     * @var string|null
     */
    private $omschrijving;

    /**
     * Kostenplaats wel of niet verplicht bij het boeken.
     *
     * @var bool
     */
    private $kostenplaatsVerplicht;

    /**
     * Rekening code van het grootboek.
     *
     * @var Rekeningcode
     */
    private $rekeningCode;

    /**
     * Een vlag dat aangeeft of het grootboek niet meer actief is binnen de administratie.
     * Indien true, dan kan het grootboek als "verwijderd" worden beschouwd.
     *
     * @var bool
     */
    private $nonactief;

    /**
     * Het nummer van het grootboek.
     *
     * @var int
     */
    private $nummer;

    /**
     * De grootboekfunctie van het grootboek.
     *
     * @var Grootboekfunctie
     */
    private $grootboekfunctie;

    /**
     * RgsCodes
     *
     * @var RgsCode[]
     */
    private $rgsCode = [];

    public function getModifiedOn(): ?\DateTimeInterface
    {
        return $this->modifiedOn;
    }

    public function setModifiedOn(?\DateTimeInterface $modifiedOn): Grootboek
    {
        $this->modifiedOn = $modifiedOn;

        return $this;
    }

    public function getOmschrijving(): ?string
    {
        return $this->omschrijving;
    }

    public function setOmschrijving(string $omschrijving): Grootboek
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    public function isKostenplaatsVerplicht(): bool
    {
        return $this->kostenplaatsVerplicht;
    }

    public function setKostenplaatsVerplicht(bool $kostenplaatsVerplicht): Grootboek
    {
        $this->kostenplaatsVerplicht = $kostenplaatsVerplicht;

        return $this;
    }

    public function getRekeningCode(): Rekeningcode
    {
        return $this->rekeningCode;
    }

    public function setRekeningCode(Rekeningcode $rekeningCode): Grootboek
    {
        $this->rekeningCode = $rekeningCode;

        return $this;
    }

    public function isNonactief(): bool
    {
        return $this->nonactief;
    }

    public function setNonactief(bool $nonactief): Grootboek
    {
        $this->nonactief = $nonactief;

        return $this;
    }

    public function getNummer(): int
    {
        return $this->nummer;
    }

    public function setNummer(int $nummer): Grootboek
    {
        $this->nummer = $nummer;

        return $this;
    }

    public function getGrootboekfunctie(): Grootboekfunctie
    {
        return $this->grootboekfunctie;
    }

    public function setGrootboekfunctie(Grootboekfunctie $grootboekfunctie): Grootboek
    {
        $this->grootboekfunctie = $grootboekfunctie;

        return $this;
    }

    public function getRgsCode(): array
    {
        return $this->rgsCode;
    }

    public function setRgsCode(array $rgsCode): Grootboek
    {
        foreach ($rgsCode as $rgsCodeElement) {
            if (!$rgsCodeElement instanceof RgsCode) {
                throw new \InvalidArgumentException(sprintf("We only accept instances of '%s'", RgsCode::class));
            }
        }

        $this->rgsCode = $rgsCode;

        return $this;
    }
}
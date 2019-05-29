<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Model;

class Kostenplaats extends SnelstartObject
{
    /**
     * De omschrijving van de kostenplaats.
     *
     * @var string
     */
    private $omschrijving;

    /**
     * Een vlag dat aangeeft of een kostenplaats niet meer actief is binnen de administratie.\r\nIndien <see langword=\"true\" />, dan kan er niet geboekt worden op de kostenplaats.
     *
     * @var bool
     */
    private $nonactief = false;

    /**
     * Het nummer van de kostenplaats.
     *
     * @var int
     */
    private $nummer;

	public static $editableAttributes = [
		"omschrijving",
		"nummer",
		"nonactief",
	];
    public function setOmschrijving(string $omschrijving): self
	{
		$this->omschrijving = $omschrijving;
		return $this;
	}

    public function getOmschrijving(): string
	{
		return $this->omschrijving;
	}

	public function setNummer(int $nummer): self
	{
		$this->nummer = $nummer;
		return $this;
	}

	public function getNummer(): int
	{
		return $this->nummer;
	}
	
	public function setNonactief(bool $nonactief): self
	{
		$this->nonactief = $nonactief;
		return $this;
	}

}
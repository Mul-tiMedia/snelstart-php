<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Model;
use SnelstartPHP\Exception\BookingNotInBalanceException;

use Money\Money;
class Verkoopboeking extends SnelstartObject
{
    /**
     * De klant/debiteur aan wie de factuur is gericht.
     *
     * @var Relatie
     */
    private $klant;
	private $boekingsregels;
	private $factuurDatum;
	private $factuurnummer;
	private $factuurbedrag;
	private $vervalDatum;
	private $btw;
	private $modifiedOn;
	private $openstaandSaldo;
    /**
     * De betalingstermijn (in dagen) van de verkoopboeking.
     *
     * @var int|null
     */
    private $betalingstermijn;

    /**
     * De (optionele) eenmalige incassomachtiging waarmee deze factuur kan worden geïncasseerd.
     *
     * @var IncassoMachtiging|null
     */
    private $eenmaligeIncassoMachtiging;

    /**
     * De (optionele) doorlopende incassomachtiging waarmee deze factuur kan worden geïncasseerd.
     *
     * @var IncassoMachtiging|null
     */
    private $doorlopendeIncassoMachtiging;

    /**
     * @var VerkoopboekingBijlage[]
     */
    protected $bijlagen;
	protected $boekstuk;
	protected $omschrijving;
    public static $editableAttributes = [
        "klant",
        "betalingstermijn",
        "eenmaligeIncassoMachtiging",
        "doorlopendeIncassoMachtiging",
		"id",
		"boekstuk",
		"gewijzigdDoorAccountant",
		"markering",
		"factuurDatum",
		"factuurnummer",
		"omschrijving",
		"factuurBedrag",
		"boekingsregels",
		"vervalDatum",
		"btw",
	];
    public static function getEditableAttributes(): array
    {
        return \array_unique(
            \array_merge(parent::$editableAttributes, parent::getEditableAttributes(), static::$editableAttributes, self::$editableAttributes)
        );
    }

    public function getKlant(): ?Relatie
    {
        return $this->klant;
    }

    public function setKlant(Relatie $klant): self
    {
        $this->klant = $klant;

        return $this;
    }

    public function getBetalingstermijn(): ?int
    {
        return $this->betalingstermijn;
    }

    public function setBetalingstermijn(int $betalingstermijn): self
    {
        $this->betalingstermijn = $betalingstermijn;

        return $this;
    }

    public function getEenmaligeIncassoMachtiging(): ?IncassoMachtiging
    {
        return $this->eenmaligeIncassoMachtiging;
    }

    public function setEenmaligeIncassoMachtiging(?IncassoMachtiging $eenmaligeIncassoMachtiging): self
    {
        $this->eenmaligeIncassoMachtiging = $eenmaligeIncassoMachtiging;

        return $this;
    }

    public function getDoorlopendeIncassoMachtiging(): ?IncassoMachtiging
    {
        return $this->doorlopendeIncassoMachtiging;
    }

    public function setDoorlopendeIncassoMachtiging(?IncassoMachtiging $doorlopendeIncassoMachtiging): self
    {
        $this->doorlopendeIncassoMachtiging = $doorlopendeIncassoMachtiging;

        return $this;
    }
	public function setBoekingsRegels(array $regels): self
	{
		foreach ($regels as $regel) {
			if (!$regel instanceof Boekingsregel) {
				throw new \InvalidArgumentException(sprintf("Should be a type of '%s'", Boekingsregel::class));
			}
		}

		$this->boekingsregels = $regels;
		return $this;
	}
	public function getBoekingsregels(): array
	{
		return $this->boekingsregels;
	}
	public function getOmschrijving(): ?string
	{
		return $this->omschrijving;
	}

	public function setOmschrijving(?string $omschrijving): self
	{
		$this->omschrijving = $omschrijving;

		return $this;
	}
	public function getBoekstuk(): ?string
	{
		return $this->boekstuk;
	}

	public function setBoekstuk(?string $boekstuk): self
	{
		$this->boekstuk = $boekstuk;

		return $this;
	}
	public function getFactuurdatum(): ?\DateTimeInterface
	{
		return $this->factuurDatum;
	}

	public function setFactuurdatum(?\DateTimeInterface $factuurDatum): self
	{
		$this->factuurDatum = $factuurDatum;

		return $this;
	}
	public function getFactuurnummer(): string
	{
		return $this->factuurnummer;
	}
	public function getOpenstaandsaldo()
	{
		return $this->openstaandSaldo;
	}
	public function setOpenstaandsaldo($openstaandSaldo): self
	{
		$this->openstaandSaldo = $openstaandSaldo;
		return $this;
	}
	public function setFactuurnummer(string $factuurnummer): self
	{
		$this->factuurnummer = $factuurnummer;

		return $this;
	}
	public function getFactuurbedrag(): Money
	{
		return $this->factuurbedrag;
	}

	public function setFactuurbedrag(Money $factuurbedrag): self
	{
		$this->factuurbedrag = $factuurbedrag;

		return $this;
	}
	public function getVervaldatum(): ?\DateTimeInterface
	{
		return $this->vervalDatum;
	}

	public function setVervaldatum(?\DateTimeInterface $vervalDatum): self
	{
		$this->vervalDatum = $vervalDatum;

		return $this;
	}
	public function getBtw(): array
	{
		return $this->btw ?? [];
	}

	public function setBtw(array $btw): self
	{
		foreach ($btw as $btwRegel) {
			if (!$btwRegel instanceof Btwregel) {
				throw new \InvalidArgumentException(sprintf("Should be a type of '%s'", Btwregel::class));
			}
		}

		$this->btw = $btw;

		return $this;
	}
	public function assertInBalance(): void
	{
		$targetAmount = $this->getFactuurbedrag();

		/**
		 * @var Boekingsregel $boekingsregel
		 */
		foreach ($this->getBoekingsregels() as $boekingsregel) {
			$targetAmount->subtract($boekingsregel->getBedrag());
		}
		if ($targetAmount->isZero()) {
			throw new BookingNotInBalanceException();
		}
	}
	public function getModifiedOn(): ?\DateTimeInterface
	{
		return $this->modifiedOn;
	}

	public function setModifiedOn(?\DateTimeInterface $modifiedOn): self
	{
		$this->modifiedOn = $modifiedOn;

		return $this;
	}
}
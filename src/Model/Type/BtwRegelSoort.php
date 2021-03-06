<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Model\Type;

use MyCLabs\Enum\Enum;

/**
 * @method static BtwRegelSoort GEEN()
 * @method static BtwRegelSoort VERKOPENLAAG()
 * @method static BtwRegelSoort VERKOPENHOOG()
 * @method static BtwRegelSoort VERKOPENOVERIG()
 * @method static BtwRegelSoort INKOPENLAAG()
 * @method static BtwRegelSoort INKOPENHOOG()
 * @method static BtwRegelSoort INKOPENOVERIG()
 * @method static BtwRegelSoort INKOPENVERLEGD()
 */
class BtwRegelSoort extends Enum
{
    private const GEEN              = 'Geen';
    private const VERKOPENLAAG      = 'VerkopenLaag';
    private const VERKOPENHOOG      = 'VerkopenHoog';
    private const VERKOPENOVERIG    = 'VerkopenOverig';
    private const INKOPENLAAG       = 'InkopenLaag';
    private const INKOPENHOOG       = 'InkopenHoog';
    private const INKOPENOVERIG     = 'InkopenOverig';
    private const INKOPENVERLEGD    = 'InkopenVerlegd';
}
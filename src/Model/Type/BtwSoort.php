<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Model\Type;

use MyCLabs\Enum\Enum;

/**
 * @method static BtwSoort GEEN()
 * @method static BtwSoort LAAG()
 * @method static BtwSoort HOOG()
 * @method static BtwSoort OVERIG()
 */
class BtwSoort extends Enum
{
    private const GEEN      = 'Geen';
    private const LAAG      = 'Laag';
    private const HOOG      = 'Hoog';
    private const OVERIG    = 'Overig';
}
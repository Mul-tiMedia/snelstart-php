<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Model\Type;

use MyCLabs\Enum\Enum;

/**
 * @method static Relatiesoort LEVERANCIER()
 * @method static Relatiesoort KLANT()
 * @method static Relatiesoort EIGEN()
 */
class Relatiesoort extends Enum
{
    private const LEVERANCIER       = 'Leverancier';
    private const KLANT             = 'Klant';
    private const EIGEN             = 'Eigen';
}
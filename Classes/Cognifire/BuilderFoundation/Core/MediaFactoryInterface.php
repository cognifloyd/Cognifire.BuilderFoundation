<?php
namespace Cognifire\BuilderFoundation\Core;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cognifire.BuilderBase". *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */


use TYPO3\Flow\Annotations as Flow;

/**
 * This is the contract for various media. Typically, a media is a file of a specific type.
 * Possible Factories include:
 * - Text (Plain text file would be edited via regex)
 * - Fluid
 * - PHP
 * - TypoScript
 * - YAML
 * - CSS (& variants: SASS/SCSS, LESS)
 */
interface MediaFactoryInterface {

}
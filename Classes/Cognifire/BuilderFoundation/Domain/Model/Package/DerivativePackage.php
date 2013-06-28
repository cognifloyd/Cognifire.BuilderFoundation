<?php
namespace Cognifire\BuilderFoundation\Domain\Model\Package;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package                          *
 * "Cognifire.BuilderFoundation".                                         *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */


use TYPO3\Flow\Annotations as Flow;

/**
 * Derivatives aren't always Flow Packages
 * TODO[cognifloyd] This needs DerivativePackageStrategies so that both TYPO3 Flow and TYPO3CMS Deriatives are supported
 */
class DerivativePackage extends AbstractPackage {

}
<?php
namespace Cognifire\BuilderFoundation\Package\Irregular;

/*                                                                        *
 * This script belongs to the TYPO3 Flow framework.                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Cognifire\BuilderFoundation\Package\PackageInterface;

/**
 * Interface for a Flow Package class
 *
 * @api
 */
interface IrregularPackageInterface extends PackageInterface {

	/**
	 * Gets the directory layout
	 *
	 * @return string
	 */
	public function getPackageKeyPattern();

	/**
	 * Gets the directory layout
	 *
	 * @return array
	 */
	public function getDirectoryLayout();

	/**
	 * Needs the strategy related stuff:
	 * - PATTERN_MATCH_PACKAGEKEY
	 * - Directory Layout
	 * - Which directories should contain what?
	 * - setStrategy...
	 */

}
?>
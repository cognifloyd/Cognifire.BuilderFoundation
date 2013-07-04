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

/**
 * Interface for the Package Managers that don't work with Flow Packages
 *
 * @api
 */
interface IrregularPackageManagerInterface {

	/**
	 * Initializes the package manager.
	 *
	 * @param \TYPO3\Flow\Core\Bootstrap $bootstrap
	 * @return void
	 */
	public function initialize(\TYPO3\Flow\Core\Bootstrap $bootstrap);

	/**
	 * Returns TRUE if a package is available (the package's files exist in the packages directory)
	 * or FALSE if it's not. If a package is available it doesn't mean necessarily that it's active!
	 *
	 * @param string $packageKey The key of the package to check
	 * @return boolean TRUE if the package is available, otherwise FALSE
	 * @api
	 */
	public function isPackageAvailable($packageKey);

	/**
	 * Returns a \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface object for the specified package.
	 * A package is available, if the package directory contains valid meta information.
	 *
	 * @param string $packageKey
	 * @return \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface
	 * @api
	 */
	public function getPackage($packageKey);

	/**
	 * Returns an array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface objects of all available packages.
	 * A package is available, if the package directory contains valid meta information.
	 *
	 * @return array Array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface
	 * @api
	 */
	public function getAvailablePackages();

	/**
	 * Returns an array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface objects of all packages that match
	 * the given package state, path, **and** type filters. All three filters must match.
	 *
	 * @param string $packageState defaults to available
	 * @param string $packagePath
	 * @param string $packageType
	 *
	 * @return array Array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface
	 * @api
	 */
	public function getFilteredPackages($packageState = 'available', $packagePath = '', $packageType = '');

	/**
	 * Returns the upper camel cased version of the given package key or FALSE
	 * if no such package is available.
	 *
	 * @param string $unknownCasedPackageKey The package key to convert
	 * @return mixed The upper camel cased package key or FALSE if no such package exists
	 * @api
	 */
	public function getCaseSensitivePackageKey($unknownCasedPackageKey);

	/**
	 * Check the conformance of the given package key
	 *
	 * @param string $packageKey The package key to validate
	 * @api
	 */
	public function isPackageKeyValid($packageKey);

	/**
	 * Create a new package, given the package key
	 *
	 * @param string $packageKey The package key to use for the new package
	 * @param \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageMetaData $packageMetaData Package metadata
	 * @param string $packagesPath If specified, the package will be created in this path
	 * @param string $packageType If specified, the package type will be set
	 * @return Cognifire\BuilderFoundation\Package\Irregular\IrregularPackage The newly created package
	 * @api
	 */
	public function createPackage($packageKey, \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageMetaData $packageMetaData = NULL, $packagesPath = '', $packageType = '');

	/**
	 * Removes a package from registry and deletes it from filesystem
	 *
	 * @param string $packageKey package to delete
	 * @return void
	 * @api
	 */
	public function deletePackage($packageKey);

}
?>
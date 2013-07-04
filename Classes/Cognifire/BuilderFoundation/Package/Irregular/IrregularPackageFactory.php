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

use TYPO3\Flow\Utility\Files;

/**
 * Class for building Packages
 */
class IrregularPackageFactory {

	/**
	 * @var IrregularPackageManagerInterface
	 */
	protected $packageManager;

	/**
	 * Constructor
	 *
	 * @param \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageManagerInterface $packageManager
	 */
	public function __construct(IrregularPackageManagerInterface $packageManager) {
		$this->packageManager = $packageManager;
	}

	/**
	 * Returns a package instance.
	 *
	 * @param string $packagesBasePath the base install path of packages,
	 * @param string $packagePath path to package, relative to base path
	 * @param string $packageKey key / name of the package
	 * @return \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface
	 *
	 * @throws \Cognifire\BuilderFoundation\Package\Exception\CorruptPackageException
	 */
	public function create($packagesBasePath, $packagePath, $packageKey) {
		$packagePath = Files::concatenatePaths(array($packagesBasePath, $packagePath)) . '/';

		$package = new IrregularPackage($this->packageManager, $packageKey, $packagePath);

		return $package;
	}

}
?>
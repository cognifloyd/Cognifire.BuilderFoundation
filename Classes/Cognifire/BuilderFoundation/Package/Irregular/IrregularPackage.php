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
 * A Package
 *
 * @api
 */
class IrregularPackage implements IrregularPackageInterface {

	/**
	 * Unique key of this package. Example for the Flow package: "TYPO3.Flow"
	 * @var string
	 */
	protected $packageKey;

	/**
	 * Full path to this package's main directory
	 * @var string
	 */
	protected $packagePath;

	/**
	 * Meta information about this package
	 * @var \TYPO3\Flow\Package\MetaData
	 */
	protected $packageMetaData;

	/**
	 * The namespace of the classes contained in this package
	 * @var string
	 */
	protected $namespace;

	/**
	 * @var \TYPO3\Flow\Package\PackageManager
	 */
	protected $packageManager;

	/**
	 * Constructor
	 *
	 * @param \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageManager $packageManager the package manager which knows this package
	 * @param string                                                                 $packageKey     Key of this package
	 * @param string                                                                 $packagePath    Absolute path to the location of the package
	 *
	 * @throws \Cognifire\BuilderFoundation\Package\Exception\InvalidPackagePathException if an invalid package path was passed
	 * @throws \Cognifire\BuilderFoundation\Package\Exception\InvalidPackageKeyException if an invalid package key was passed
	 */
	public function __construct(\Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageManager $packageManager, $packageKey, $packagePath) {
		if (preg_match($this->getPackageKeyPattern(), $packageKey) !== 1) {
			throw new \Cognifire\BuilderFoundation\Package\Exception\InvalidPackageKeyException('"' . $packageKey . '" is not a valid package key.', 1217959510);
		}
		if (!(is_dir($packagePath) || (Files::is_link($packagePath) && is_dir(Files::getNormalizedPath($packagePath))))) {
			throw new \Cognifire\BuilderFoundation\Package\Exception\InvalidPackagePathException(sprintf('Tried to instantiate a package object for package "%s" with a non-existing package path "%s". Either the package does not exist anymore, or the code creating this object contains an error.', $packageKey, $packagePath), 1166631889);
		}
		if (substr($packagePath, -1, 1) !== '/') {
			throw new \Cognifire\BuilderFoundation\Package\Exception\InvalidPackagePathException(sprintf('The package path "%s" provided for package "%s" has no trailing forward slash.', $packagePath, $packageKey), 1166633720);
		}

		$this->packageManager = $packageManager;
		$this->packageKey = $packageKey;
		$this->packagePath = Files::getNormalizedPath($packagePath);
	}

	/**
	 * Returns the package meta data object of this package.
	 *
	 * @return \TYPO3\Flow\Package\MetaData
	 */
	public function getPackageMetaData() {
		if ($this->packageMetaData === NULL) {
			$this->packageMetaData = new MetaData($this->getPackageKey());
			$this->packageMetaData->setDescription($this->description);
			$this->packageMetaData->setVersion($this->version);
		}
		return $this->packageMetaData;
	}

	/**
	 * Returns the package key of this package.
	 *
	 * @return string
	 * @api
	 */
	public function getPackageKey() {
		return $this->packageKey;
	}

	/**
	 * Returns the PHP namespace of classes in this package.
	 *
	 * @return string
	 * @throws \TYPO3\Flow\Package\Exception\InvalidPackageStateException
	 * @api
	 */
	public function getNamespace() {
		if (!$this->namespace) {
			$namespace = str_replace('.', '\\', $this->getPackageKey());
			$this->namespace = $namespace;
		}
		return $this->namespace;
	}

	/**
	 * Returns the full path to this package's main directory
	 *
	 * @return string Path to this package's main directory
	 * @api
	 */
	public function getPackagePath() {
		return $this->packagePath;
	}

	/**
	 * Gets the directory layout
	 *
	 * @return string
	 */
	public function getPackageKeyPattern() {
		return '';
	}

	/**
	 * Gets the directory layout
	 *
	 * @return array
	 */
	public function getDirectoryLayout() {
		return array();
	}

}
?>
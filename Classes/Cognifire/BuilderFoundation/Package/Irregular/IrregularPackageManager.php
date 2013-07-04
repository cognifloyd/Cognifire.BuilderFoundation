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
use TYPO3\Flow\Annotations as Flow;

/**
 * The default TYPO3 Package Manager
 *
 * TODO[cognifloyd] figure out the logger embedding
 * TODO[cognifloyd] redo the exceptions
 *
 * @api
 * @Flow\Scope("singleton")
 */
class IrregularPackageManager implements IrregularPackageManagerInterface {

	/**
	 * @var \TYPO3\Flow\Core\Bootstrap
	 */
	protected $bootstrap;

	/**
	 * @var IrregularPackageFactory
	 */
	protected $packageFactory;

	/**
	 * Array of available packages, indexed by package key
	 * @var array
	 */
	protected $packages = array();

	/**
	 * A translation table between lower cased and upper camel cased package keys
	 * @var array
	 */
	protected $packageKeys = array();

	/**
	 * Absolute path leading to the various package directories
	 * @var string
	 */
	protected $packagesBasePath;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var \TYPO3\Flow\Log\SystemLoggerInterface
	 */
	protected $systemLogger;

	/**
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * @param \TYPO3\Flow\Log\SystemLoggerInterface $systemLogger
	 * @return void
	 */
	public function injectSystemLogger(\TYPO3\Flow\Log\SystemLoggerInterface $systemLogger) {
		if ($this->systemLogger instanceof \TYPO3\Flow\Log\EarlyLogger) {
			$this->systemLogger->replayLogsOn($systemLogger);
			unset($this->systemLogger);
		}
		$this->systemLogger = $systemLogger;
	}

	/**
	 * Initializes the package manager
	 *
	 * @param \TYPO3\Flow\Core\Bootstrap $bootstrap        The current bootstrap
	 * @param mixed|string               $packagesBasePath Absolute path of the Packages directory
	 * @param string                     $packageStatesPathAndFilename
	 *
	 * @return void
	 */
	public function initialize(\TYPO3\Flow\Core\Bootstrap $bootstrap, $packagesBasePath = FLOW_PATH_PACKAGES, $packageStatesPathAndFilename = '') {
		$this->packagesBasePath = $packagesBasePath;
		$this->packageFactory = new IrregularPackageFactory($this);
	}

	/**
	 * Returns TRUE if a package is available (the package's files exist in the packages directory)
	 * or FALSE if it's not. If a package is available it doesn't mean necessarily that it's active!
	 *
	 * @param string $packageKey The key of the package to check
	 * @return boolean TRUE if the package is available, otherwise FALSE
	 * @api
	 */
	public function isPackageAvailable($packageKey) {
		return (isset($this->packages[$packageKey]));
	}

	/**
	 * Returns the base path for packages
	 *
	 * @return string
	 */
	public function getPackagesBasePath() {
		return $this->packagesBasePath;
	}

	/**
	 * Returns a PackageInterface object for the specified package.
	 * A package is available, if the package directory contains valid MetaData information.
	 *
	 * @param string $packageKey
	 * @return \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface The requested package object
	 * @throws \TYPO3\Flow\Package\Exception\UnknownPackageException if the specified package is not known
	 * @api
	 */
	public function getPackage($packageKey) {
		if (!$this->isPackageAvailable($packageKey)) {
			throw new \TYPO3\Flow\Package\Exception\UnknownPackageException('Package "' . $packageKey . '" is not available. Please check if the package exists and that the package key is correct (package keys are case sensitive).', 1166546734);
		}
		return $this->packages[$packageKey];
	}

	/**
	 * Returns an array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackage objects of all available packages.
	 * A package is available, if the package directory contains valid meta information.
	 *
	 * @return array Array of \Cognifire\BuilderFoundation\Package\IrregularPackageInterface
	 * @api
	 */
	public function getAvailablePackages() {
		return $this->packages;
	}

	/**
	 * Returns an array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackage objects of all packages that match
	 * the given package state, path, **and** type filters. All three filters must match.
	 *
	 * @param string $packageState defaults to available
	 * @param string $packagePath
	 * @param string $packageType
	 *
	 * @return array Array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface
	 * @throws \TYPO3\Flow\Package\Exception\InvalidPackageStateException
	 * @api
	 */
	public function getFilteredPackages($packageState = 'available', $packagePath = '', $packageType = '') {
		$packages = array();
		switch (strtolower($packageState)) {
			case 'available':
				$packages = $this->getAvailablePackages();
			break;
			default:
				throw new \TYPO3\Flow\Package\Exception\InvalidPackageStateException('The package state "' . $packageState . '" is invalid', 1372458274);
		}
		if($packagePath !== '') {
			$packages = $this->filterPackagesByPath($packages,$packagePath);
		}
		if($packageType !== '') {
			$packages = $this->filterPackagesByType($packages,$packageType);
		}
		return $packages;
	}

	/**
	 * Returns an array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackage objects in the given array of packages
	 * that are in the specified Package Path
	 *
	 * @param array $packages Array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface to be filtered
	 * @param string $filterPath Filter out anything that's not in this path
	 *
	 * @return array Array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface
	 */
	protected function filterPackagesByPath(&$packages, $filterPath) {
		$filteredPackages = array();
		foreach ($packages as $package) {
			$packagePath = substr($package->getPackagePath(), strlen(FLOW_PATH_PACKAGES));
			$packageGroup = substr($packagePath, 0, strpos($packagePath, '/'));
			if ($packageGroup === $filterPath) {
				$relevantPackages[$package->getPackageKey()] = $package;
			}
		}
		return $filteredPackages;
	}

	/**
	 * Returns an array of \TYPO3\Flow\Package objects in the given array of packages
	 * that are of the specified package type.
	 *
	 * @param array $packages Array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface to be filtered
	 * @param string $packageType Filter out anything that's not of this packageType
	 *
	 * @return array Array of \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface
	 */
	protected function filterPackagesByType(&$packages, $packageType) {
		$filteredPackages = array();
		foreach ($packages as $package) {
			if ($package->getPackageType() === $packageType) {
				$relevantPackages[$package->getPackageKey()] = $package;
			}
		}
		return $filteredPackages;
	}

	/**
	 * Returns the upper camel cased version of the given package key or FALSE
	 * if no such package is available.
	 *
	 * @param string $unknownCasedPackageKey The package key to convert
	 * @return mixed The upper camel cased package key or FALSE if no such package exists
	 * @api
	 */
	public function getCaseSensitivePackageKey($unknownCasedPackageKey) {
		$lowerCasedPackageKey = strtolower($unknownCasedPackageKey);
		return (isset($this->packageKeys[$lowerCasedPackageKey])) ? $this->packageKeys[$lowerCasedPackageKey] : FALSE;
	}

	/**
	 * Check the conformance of the given package key
	 *
	 * @param string $packageKey The package key to validate
	 * @return boolean If the package key is valid, returns TRUE otherwise FALSE
	 * @api
	 */
	public function isPackageKeyValid($packageKey) {
		return preg_match(IrregularPackageInterface::PATTERN_MATCH_PACKAGEKEY, $packageKey) === 1;
	}

	/**
	 * Create a package, given the package key
	 *
	 * @param string $packageKey The package key of the new package
	 * @param \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageMetaData $packageMetaData If specified, this package meta object is used for writing the Package.xml file, otherwise a rudimentary Package.xml file is created
	 * @param string $packagesPath If specified, the package will be created in this path, otherwise the default "Application" directory is used
	 * @param string $packageType If specified, the package type will be set, otherwise it will default to "typo3-flow-package"
	 * @return \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageInterface The newly created package
	 * @throws \TYPO3\Flow\Package\Exception
	 * @throws \TYPO3\Flow\Package\Exception\PackageKeyAlreadyExistsException
	 * @throws \TYPO3\Flow\Package\Exception\InvalidPackageKeyException
	 * @api
	 */
	public function createPackage($packageKey, \Cognifire\BuilderFoundation\Package\Irregular\IrregularPackageMetaData $packageMetaData = NULL, $packagesPath = '', $packageType = 'typo3-flow-package') {
		if (!$this->isPackageKeyValid($packageKey)) {
			throw new \TYPO3\Flow\Package\Exception\InvalidPackageKeyException('The package key "' . $packageKey . '" is invalid', 1220722210);
		}
		if ($this->isPackageAvailable($packageKey)) {
			throw new \TYPO3\Flow\Package\Exception\PackageKeyAlreadyExistsException('The package key "' . $packageKey . '" already exists', 1220722873);
		}

		if ($packagesPath === '') {
			if (is_array($this->settings['package']['packagesPathByType']) && in_array($packageType, $this->settings['package']['packagesPathByType'], TRUE)) {
				$packagesPath = $this->settings['package']['packagesPathByType'][$packageType];
			} else {
				$packagesPath = 'Application';
			}
			$packagesPath = Files::getUnixStylePath(Files::concatenatePaths(array($this->packagesBasePath, $packagesPath)));
		}

		$packagePath = Files::concatenatePaths(array($packagesPath, $packageKey)) . '/';
		Files::createDirectoryRecursively($packagePath);

		foreach (
			array(
				IrregularPackageInterface::DIRECTORY_METADATA,
				IrregularPackageInterface::DIRECTORY_CLASSES,
				IrregularPackageInterface::DIRECTORY_CONFIGURATION,
				IrregularPackageInterface::DIRECTORY_DOCUMENTATION,
				IrregularPackageInterface::DIRECTORY_RESOURCES,
				IrregularPackageInterface::DIRECTORY_TESTS_UNIT,
				IrregularPackageInterface::DIRECTORY_TESTS_FUNCTIONAL,
			) as $path) {
			Files::createDirectoryRecursively(Files::concatenatePaths(array($packagePath, $path)));
		}

		$packagePath = str_replace($this->packagesBasePath, '', $packagePath);
		$package = $this->packageFactory->create($this->packagesBasePath, $packagePath, $packageKey, IrregularPackageInterface::DIRECTORY_CLASSES);

		$this->packages[$packageKey] = $package;
		foreach (array_keys($this->packages) as $upperCamelCasedPackageKey) {
			$this->packageKeys[strtolower($upperCamelCasedPackageKey)] = $upperCamelCasedPackageKey;
		}

		return $package;
	}

	/**
	 * Removes a package from registry and deletes it from filesystem
	 *
	 * @param string $packageKey package to remove
	 * @return void
	 * @throws \TYPO3\Flow\Package\Exception\UnknownPackageException if the specified package is not known
	 * @throws \TYPO3\Flow\Package\Exception\ProtectedPackageKeyException if a package is protected and cannot be deleted
	 * @throws \TYPO3\Flow\Package\Exception
	 * @api
	 */
	public function deletePackage($packageKey) {
		if (!$this->isPackageAvailable($packageKey)) {
			throw new \TYPO3\Flow\Package\Exception\UnknownPackageException('Package "' . $packageKey . '" is not available and cannot be removed.', 1166543253);
		}

		$package = $this->getPackage($packageKey);
		if ($package->isProtected()) {
			throw new \TYPO3\Flow\Package\Exception\ProtectedPackageKeyException('The package "' . $packageKey . '" is protected and cannot be removed.', 1220722120);
		}

		$packagePath = $package->getPackagePath();
		try {
			Files::removeDirectoryRecursively($packagePath);
		} catch (\TYPO3\Flow\Utility\Exception $exception) {
			throw new \TYPO3\Flow\Package\Exception('Please check file permissions. The directory "' . $packagePath . '" for package "' . $packageKey . '" could not be removed.', 1301491089, $exception);
		}
	}

	/**
	 * Scans all directories in the packages directories for available packages.
	 * For each package a Package object is created and stored in $this->packages.
	 *
	 * @return void
	 * @throws \TYPO3\Flow\Package\Exception\DuplicatePackageException
	 */
	protected function scanAvailablePackages() {
		$previousPackageStatesConfiguration = $this->packageStatesConfiguration;

		if (isset($this->packageStatesConfiguration['packages'])) {
			foreach ($this->packageStatesConfiguration['packages'] as $packageKey => $configuration) {
				if (!file_exists($this->packagesBasePath . $configuration['packagePath'])) {
					unset($this->packageStatesConfiguration['packages'][$packageKey]);
				}
			}
		} else {
			$this->packageStatesConfiguration['packages'] = array();
		}

		$packagePaths = array();
		foreach (new \DirectoryIterator($this->packagesBasePath) as $parentFileInfo) {
			$parentFilename = $parentFileInfo->getFilename();
			if ($parentFilename[0] !== '.' && $parentFileInfo->isDir()) {
				$packagePaths = array_merge($packagePaths, $this->scanPackagesInPath($parentFileInfo->getPathName()));
			}
		}

		foreach ($packagePaths as $packagePath => $packagePathValue) {
			$relativePackagePath = substr($packagePath, strlen($this->packagesBasePath));
			$packageKey = substr($relativePackagePath, strpos($relativePackagePath, '/') + 1, -1);
		}

	}

	/**
	 * Scans all sub directories of the specified directory and collects the package keys of packages it finds.
	 *
	 * The return of the array is to make this method usable in array_merge.
	 *
	 * @param string $startPath
	 * @param array $collectedPackagePaths
	 * @return array
	 */
	protected function scanPackagesInPath($startPath, array &$collectedPackagePaths = array()) {
		foreach (new \DirectoryIterator($startPath) as $fileInfo) {
			if (!$fileInfo->isDir()) {
				continue;
			}
			$filename = $fileInfo->getFilename();
			if ($filename[0] !== '.') {
				$currentPath = Files::getUnixStylePath($fileInfo->getPathName());
				//find the packages in this path
			}
		}
		return $collectedPackagePaths;
	}

}
?>
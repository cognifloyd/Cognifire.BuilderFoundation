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
use TYPO3\Flow\Package\Package;

/**
 * A Flow Package
 * This wraps an instance of TYPO3\Flow\Package\PackageInterface
 */
abstract class AbstractFlowPackage extends AbstractPackage {

	/**
	 * @var \TYPO3\Flow\Package\PackageManagerInterface
	 * @Flow\Inject
	 */
	protected $packageManager;

	/**
	 * @var \TYPO3\Flow\Package\PackageInterface
	 */
	protected $flowPackage;

	/**
	 * @param $packageKey string
	 */
	public function __construct($packageKey) {
		//TODO[cognifloyd] What do I do if the package doesn't exist yet?
		$this->flowPackage = $this->packageManager->getPackage($packageKey);
	}

	/**
	 * Returns the package key of this package.
	 *
	 * @return string
	 * @api
	 */
	public function getPackageKey() {
		return $this->flowPackage->getPackageKey();
	}

	/**
	 * Returns the full path to this package's main directory
	 *
	 * @return string Path to this package's main directory
	 * @api
	 */
	public function getPackagePath() {
		return $this->flowPackage->getPackagePath();
	}

	/**
	 * Returns the PHP namespace of classes in this package.
	 *
	 * @return string
	 * @api
	 */
	public function getNamespace() {
		$this->flowPackage->getNamespace();
	}

}
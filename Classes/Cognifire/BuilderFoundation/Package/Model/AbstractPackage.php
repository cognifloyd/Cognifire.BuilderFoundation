<?php
namespace Cognifire\BuilderFoundation\Package\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cognifire.BuilderFoundation". *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 */
abstract class AbstractPackage implements PackageInterface {

	/**
	 * @var string
	 */
	protected $packageKey;

	/**
	 * @var string
	 */
	protected $packagePath;


	/**
	 * @return string
	 */
	public function getPackageKey() {
		return $this->packageKey;
	}

	/**
	 * @param string $packageKey
	 * @return void
	 */
	public function setPackageKey($packageKey) {
		$this->packageKey = $packageKey;
	}

	/**
	 * @return string
	 */
	public function getPackagePath() {
		return $this->packagePath;
	}

	/**
	 * @param string $packagePath
	 * @return void
	 */
	public function setPackagePath($packagePath) {
		$this->packagePath = $packagePath;
	}

}
?>
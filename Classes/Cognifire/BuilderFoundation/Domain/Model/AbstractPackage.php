<?php
namespace Cognifire\BuilderFoundation\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cognifire.BuilderFoundation". *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Cognifire\BuilderFoundation\Annotations as Builder;

/**
 * @Builder\Entity
 */
abstract class AbstractPackage implements PackageInterface {

	/**
	 * @Builder\Config
	 * @var string
	 */
	protected $packageKey;

	/**
	 * @var string
	 */
	protected $packagePath;

	/**
	 * Directory structure of a package (DefinitiveGuide Part II / View)
	 *
	 * Classes/				All php files
	 * Documentation/		Package manual and other docs
	 * Meta/				package meta info like license files
	 * Resources/			Top folder for resources
	 * Resources/Public/	Public resources will be mirrored to the Web directory
	 * Resources/Private/	Private resources won't be mirrored to the Web directory
	 */

}
?>
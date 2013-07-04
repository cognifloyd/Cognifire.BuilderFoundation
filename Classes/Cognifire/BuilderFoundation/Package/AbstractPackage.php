<?php
namespace Cognifire\BuilderFoundation\Package;

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
 * Packages consist of a DirectoryIterator and a bunch of blobs (a blob can be a file, or a portion of a file)
 */
abstract class AbstractPackage implements PackageInterface {

	//TODO[cognifloyd] Add directory iterator

	/**
	 * @var array<\Cognifire\BuilderFoundation\Domain\Model\Blob\BlobInterface>
	 */
	protected $blobs = array();

}
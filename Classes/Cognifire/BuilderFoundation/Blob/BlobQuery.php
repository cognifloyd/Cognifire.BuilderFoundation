<?php
namespace Cognifire\BuilderFoundation\Blob;

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
 * BlobQuery is a FlowQuery factory.
 *
 * Some of the methods of this class should be exposed as FlowQuery operations to
 * modify which files are being worked with.
 */
class BlobQuery {

	/**
	 * The stack of filters
	 *
	 * @var array
	 */
	protected $filters = array();

	/**
	 * @param $blobFilter
	 * @throws Exception
	 */
	public function __construct($blobFilter) {
		if(!is_string($blobFilter)) {
			throw new Exception('BlobQuery requires a string, but '. gettype($blobFilter) . ' was received.', 1375743984);
		}
		$this->filters[] = $blobFilter;
	}

}
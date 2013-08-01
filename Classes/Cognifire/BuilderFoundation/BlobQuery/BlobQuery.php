<?php
namespace Cognifire\BuilderFoundation\BlobQuery;

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
 * The methods here should be named so that you can tell at a glance which
 * are the BlobQuery context (selecting a set of Blobs), and which operations
 * to an individual blob.
 *
 * 1) get blob collection
 * 2) filter them (each() requires blobs be of the same type)
 * 3) do something with the selected blob via eachBlob or other operations that
 * a blob instead of a blobQuery
 *
 * once you're in the Blob context, you can recurse through the blob tree and do
 * you want...
 *
 * except that a blob may have more than one child blob, and they may be of
 * types (fluid may contain html and vice versa)
 */
class BlobQuery {

	/**
	 * serves the purpose of $context in FlowQuery, and is passed to FlowQuery
	 * the initial set is created.
	 *
	 * @var array
	 */
	protected $blobs = array();

	/**
	 *
	 *
	 * @param  string $blobSelector
	 * @return mixed
	 */
	public function __construct($blobSelector) {
		$path = $this->getPathFromSelector($blobSelector);
		$blobObjects = $this->scanForBlobs($path);
		$this->flowQuery = new \TYPO3\Eel\FlowQuery\FlowQuery($blobObjects);
	}

	/**
	 *
	 *
	 * @param  string $path
	 * @return mixed
	 */
	protected function scanForBlobs($path) {

	}

	/**
	 *
	 *
	 * @param  string $blobSelector
	 * @return mixed
	 */
	protected function getPathFromSelector($blobSelector) {

	}

	/**
	 *
	 *
	 * @param  string $method
	 * @param  array $arguments
	 * @return \TYPO3\Eel\FlowQuery\_FlowQuery
	 */
	public function __call($method, $arguments) {
		$return = null;
		$this->flowQuery->$method($arguments);
		return $return;
	}

}
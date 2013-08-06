<?php
namespace Cognifire\BuilderFoundation\Domain\Model\Blob;

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
use TYPO3\Eel\FlowQuery\FlowQuery;

/**
 * This is the contract for various media types or file types (ie blobs).
 * **Instead of implementing this interface, sub-classing {@link AbstractBlob} is more appropriate
 * in most cases**.
 *
 * @api
 */
interface BlobInterface {

	/**
	 * makes a new FlowQuery with the children blobs as context
	 * This is used to provide custom BlobType-specific FlowQuery Operations
	 * that are defined in the Blob class instead of an external FlowQuery Operation Class.
	 *
	 * @param  string $method
	 * @param  array  $arguments
	 * @return FlowQuery
	 */
	public function __call($method, $arguments);

    /**
	 * returns the BlobType string
	 *
	 * @return string BlobType
	 */
    public function getBlobType();

    /**
	 * Part of the initialization of a Blob. Once set, a blobType cannot be changed.
	 * However, a blob may be cloned and converted into a different blobType.
	 * If you need to change a blobType, you'll have to destruct this Blob and construct
	 * another in its place.
	 *
	 * @param  string $blobType
	 * @return void
	 */
    public function setBlobType($blobType);

    /**
	 * Retrieves the current contents as a string.
	 * This should trigger compiling whatever abstract syntax tree into a valid document.
	 *
	 * @return string
	 */
    public function __toString();

    /**
	 * Use this to set the contents of this blob. This may be used to either initialize the blob, or overwrite its
	 * contents after some kind of processing. This should overwrite the entire string.
	 *
	 * Using this should, essentially, remove any subBlobs that were derived from the contents string.
	 * Next time those subBlobs are accessed, they should be regenerated.
	 *
	 * @param  $string
	 * @return void
	 */
    public function setContents($string);

}
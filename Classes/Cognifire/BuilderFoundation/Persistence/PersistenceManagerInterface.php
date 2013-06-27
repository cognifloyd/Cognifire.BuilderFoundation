<?php
namespace Cognifire\BuilderFoundation\Persistence;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package                          *
 * "Cognifire.BuilderFoundation".                                         *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Note: PersistenceIdentifier can be a file name, or anything else depending on the
 * currently active Persistence Manager
 */
interface PersistenceManagerInterface {

	/**
	 * Load the object identified by $persistenceIdentifier, and return it as a string
	 *
	 * @param string $persistenceIdentifier
	 * @return array
	 */
	public function load($persistenceIdentifier);

	/**
	 * Save the blob identified by $persistenceIdentifier
	 *
	 * @param string $persistenceIdentifier
	 * @param array $blobContents
	 */
	public function save($persistenceIdentifier, array $blobContents);

	/**
	 * Check whether a file or stream with the specified $persistenceIdentifier exists
	 *
	 * @param string $persistenceIdentifier
	 * @return boolean TRUE if a blob with the given $persistenceIdentifier can be loaded, otherwise FALSE
	 */
	public function exists($persistenceIdentifier);

}
?>
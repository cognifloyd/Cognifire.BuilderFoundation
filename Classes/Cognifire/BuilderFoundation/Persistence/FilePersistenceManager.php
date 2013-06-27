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

use TYPO3\Flow\Annotations as Flow;

/**
 * persistence identifier is some resource:// uri probably
 *
 * @Flow\Scope("singleton")
 */
class FilePersistenceManager implements PersistenceManagerInterface {

	/**
	 * Load the file identified by $persistenceIdentifier, and return it
	 *
	 * @param string $persistenceIdentifier
	 * @return string
	 * @throws \Cognifire\BuilderFoundation\Exception\PersistenceManagerException
	 */
	public function load($persistenceIdentifier) {
		if (!$this->exists($persistenceIdentifier)) {
			throw new \Cognifire\BuilderFoundation\Exception\PersistenceManagerException(sprintf('The file identified by "%s" could not be loaded.', $persistenceIdentifier), 1372305155);
		}
		return file_get_contents($persistenceIdentifier);
	}

	/**
	 * Save the file identified by $persistenceIdentifier
	 *
	 * @param string $persistenceIdentifier
	 * @param array $fileDefinition
	 */
	public function save($persistenceIdentifier, array $fileDefinition) {
		file_put_contents($persistenceIdentifier, $fileDefinition);
	}

	/**
	 * Check whether a file with the specified $persistenceIdentifier exists
	 *
	 * @param string $persistenceIdentifier
	 * @return boolean TRUE if a file with the given $persistenceIdentifier can be loaded, otherwise FALSE
	 */
	public function exists($persistenceIdentifier) {
		return is_file($persistenceIdentifier);
	}

}
?>
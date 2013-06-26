<?php
namespace Cognifire\BuilderFoundation\Persistence;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cognifire.BuilderFoundation". *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */
use Cognifire\BuilderFoundation\Persistence\Aspect\PersistenceMagicInterface;

/**
 * The File Manager interface
 */
interface PersistenceManagerInterface {

	/**
	 * Injects the Flow settings, called by Flow.
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings);

	/**
	 * Initializes the file manager, called by Flow.
	 *
	 * @return void
	 */
	public function initialize();

	/**
	 * Commits new objects and changes to objects in the current persistence
	 * session into the fileManager backend
	 *
	 * @return void
	 */
	public function persistAll();

	/**
	 * Clears the in-memory state of the persistence session.
	 *
	 * Managed instances become detached, any fetches will
	 * return data directly from the fileManager "backend".
	 *
	 * @return void
	 */
	public function clearState();

	/**
	 * Checks if the given object has ever been persisted.
	 *
	 * @param object $object The object to check
	 * @return boolean TRUE if the object is new, FALSE if the object exists in the repository
	 */
	public function isNewObject($object);

	/**
	 * Registers an object which has been created or cloned during this request.
	 *
	 * The given object must contain the Persistence_Object_Identifier property, thus
	 * the PersistenceMagicInterface type hint. A "new" object does not necessarily
	 * have to be known by any repository or be persisted in the end.
	 *
	 * Objects registered with this method must be known to the getObjectByIdentifier()
	 * method.
	 *
	 * @param PersistenceMagicInterface $object The new object to register
	 * @return void
	 */
	public function registerNewObject(PersistenceMagicInterface $object);

	/**
	 * Adds an object to the persistence session.
	 *
	 * @param object $object The object to add
	 * @return void
	 */
	public function add($object);

	/**
	 * Removes an object from the persistence session.
	 *
	 * @param object $object The object to remove
	 * @return void
	 */
	public function remove($object);

	/**
	 * Update an object in the persistence session.
	 *
	 * @param object $object The modified object
	 * @return void
	 * @throws \TYPO3\Flow\Persistence\Exception\UnknownObjectException
	 */
	public function update($object);

}

?>
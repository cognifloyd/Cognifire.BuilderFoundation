<?php
namespace Cognifire\BuilderFoundation\Persistence\Aspect;

/*                                                                        *
 * This script belongs to the TYPO3 Flow framework.                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Cognifire\BuilderFoundation\Annotations as Builder;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Aop\JoinPointInterface;
use TYPO3\Flow\Reflection\ObjectAccess;
use TYPO3\Flow\Utility\Algorithms;

/**
 * Adds the aspect of persistence magic to relevant objects
 *
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 * @Flow\Introduce("Cognifire\BuilderFoundation\Persistence\Aspect\PersistenceMagicAspect->isEntityOrValueObject", interfaceName="Cognifire\BuilderFoundation\Persistence\Aspect\PersistenceMagicInterface")
 */
class PersistenceMagicAspect {

	/**
	 * If the extension "igbinary" is installed, use it for increased performance
	 *
	 * @var boolean
	 */
	protected $useIgBinary;

	/**
	 * TODO[cognifloyd] Figure out how to do my own "persistenceManager" which is a combo ConfigurationManager and FileManager
	 * @Flow\Inject
	 * @var \Cognifire\BuilderFoundation\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * @Flow\Pointcut("classAnnotatedWith(Cognifire\BuilderFoundation\Annotations\Entity)")
	 */
	public function isEntity() {}

	/**
	 * @Flow\Pointcut("Cognifire\BuilderFoundation\Persistence\Aspect\PersistenceMagicAspect->isEntity || classAnnotatedWith(Cognifire\BuilderFoundation\Annotations\ValueObject)")
	 */
	public function isEntityOrValueObject() {}

	/**
	 * If there's ever a time where we need multiple properties that combine into one identity, then copy
	 * -Doctrine\ORM\Mapping\Id to Cognifire\BuilderFoundation\Annotations\Id and use Builder\Id instead of Flow\Identity
	 *
	 * @var string
	 * @Builder\Id
	 * @Flow\Introduce("Cognifire\BuilderFoundation\Persistence\Aspect\PersistenceMagicAspect->isEntityOrValueObject")
	 */
	protected $Persistence_Object_Identifier;

	/**
	 * Initializes this aspect
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->useIgBinary = extension_loaded('igbinary');
	}

	/**
	 * After returning advice, making sure we have an UUID for each and every entity.
	 *
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint The current join point
	 * @return void
	 * @Flow\Before("Cognifire\BuilderFoundation\Persistence\Aspect\PersistenceMagicAspect->isEntity && method(.*->(__construct|__clone)())")
	 */
	public function generateUuid(JoinPointInterface $joinPoint) {
		/** @var $proxy \Cognifire\BuilderFoundation\Persistence\Aspect\PersistenceMagicInterface */
		$proxy = $joinPoint->getProxy();
		ObjectAccess::setProperty($proxy, 'Persistence_Object_Identifier', Algorithms::generateUUID(), TRUE);
		/** @noinspection PhpParamsInspection */
		$this->persistenceManager->registerNewObject($proxy);
	}

	/**
	 * After returning advice, generates the value hash for the object
	 *
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint The current join point
	 * @return void
	 * @Flow\Before("classAnnotatedWith(Cognifire\BuilderFoundation\Annotations\ValueObject) && method(.*->__construct())")
	 */
	public function generateValueHash(JoinPointInterface $joinPoint) {
		$proxy = $joinPoint->getProxy();
		$hashSource = get_class($proxy);
		if (property_exists($proxy, 'Persistence_Object_Identifier')) {
			$hashSource .= ObjectAccess::getProperty($proxy, 'Persistence_Object_Identifier', TRUE);
		}
		foreach ($joinPoint->getMethodArguments() as $argumentValue) {
			if (is_array($argumentValue)) {
				/** @noinspection PhpUndefinedFunctionInspection */
				$hashSource .= ($this->useIgBinary === TRUE) ? igbinary_serialize($argumentValue) : serialize($argumentValue);
			} elseif (!is_object($argumentValue)) {
				$hashSource .= $argumentValue;
			} elseif (property_exists($argumentValue, 'Persistence_Object_Identifier')) {
				$hashSource .= ObjectAccess::getProperty($argumentValue, 'Persistence_Object_Identifier', TRUE);
			} elseif ($argumentValue instanceof \DateTime) {
				$hashSource .= $argumentValue->getTimestamp();
			}
		}
		$proxy = $joinPoint->getProxy();
		ObjectAccess::setProperty($proxy, 'Persistence_Object_Identifier', sha1($hashSource), TRUE);
	}

	/**
	 * Mark object as cloned after cloning.
	 *
	 * Note: this is not used by anything in the Flow base distribution,
	 * but might be needed by custom backends (like TYPO3.CouchDB).
	 *
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
	 * @return void
	 * @Flow\AfterReturning("Cognifire\BuilderFoundation\Persistence\Aspect\PersistenceMagicAspect->isEntityOrValueObject && method(.*->__clone())")
	 */
	public function cloneObject(JoinPointInterface $joinPoint) {
		/** @noinspection PhpUndefinedFieldInspection */
		$joinPoint->getProxy()->Flow_Persistence_clone = TRUE;
	}

}
?>

<?php
namespace Cognifire\BuilderFoundation\Persistence\Mapping\Driver;

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
use TYPO3\Flow\Persistence\Doctrine\Mapping\Driver\FlowAnnotationDriver;

/**
 * Uses the FlowAnnotationDriver as Base but overrides the methods to make it Builder specific.
 */
class BuilderAnnotationDriver extends FlowAnnotationDriver {

	/**
	 * Loads the metadata for the specified class into the provided container.
	 *
	 * @param string $className
	 * @param \Doctrine\Common\Persistence\Mapping\ClassMetadata $metadata
	 * @return void
	 * @throws \Doctrine\ORM\Mapping\MappingException
	 * @throws \UnexpectedValueException
	 * @todo adjust when Doctrine 2 supports value objects, see http://www.doctrine-project.org/jira/browse/DDC-93
	 */
	public function loadMetadataForClass($className, \Doctrine\Common\Persistence\Mapping\ClassMetadata $metadata) {
		$class = $metadata->getReflectionClass();
		$classSchema = $this->getClassSchema($class->getName());
		$classAnnotations = $this->reader->getClassAnnotations($class);

			// Evaluate Entity annotation
		if (isset($classAnnotations['Cognifire\BuilderFoundation\Annotations\Entity'])) {
			$entityAnnotation = $classAnnotations['Cognifire\BuilderFoundation\Annotations\Entity'];
			if ($entityAnnotation->repositoryClass !== NULL) {
				$metadata->setCustomRepositoryClass($entityAnnotation->repositoryClass);
			}
			if ($entityAnnotation->readOnly) {
				$metadata->markReadOnly();
			}
		} elseif ($classSchema->getModelType() === \TYPO3\Flow\Reflection\ClassSchema::MODELTYPE_VALUEOBJECT) {
				// also ok... but we make it read-only
			$metadata->markReadOnly();
		} else {
			throw \Doctrine\ORM\Mapping\MappingException::classIsNotAValidEntityOrMappedSuperClass($className);
		}

			// Evaluate annotations on properties/fields
		$this->evaluatePropertyAnnotations($metadata);

			// Evaluate AssociationOverrides annotation
		$this->evaluateOverridesAnnotations($classAnnotations, $metadata);

			// Evaluate @HasLifecycleCallbacks annotation
		$this->evaluateLifeCycleAnnotations($class, $metadata);
	}

	/**
	 * Evaluate the property annotations and amend the metadata accordingly.
	 *
	 * @param \Doctrine\ORM\Mapping\ClassMetadataInfo $metadata
	 * @return void
	 * @throws \Doctrine\ORM\Mapping\MappingException
	 */
	protected function evaluatePropertyAnnotations(\Doctrine\ORM\Mapping\ClassMetadataInfo $metadata) {
//		$className = $metadata->name;

//		$class = $metadata->getReflectionClass();
//		$classSchema = $this->getClassSchema($className);

		/*foreach ($class->getProperties() as $property) {
			if (!$classSchema->hasProperty($property->getName())
					|| $metadata->isMappedSuperclass && !$property->isPrivate()
					|| $metadata->isInheritedField($property->getName())
					|| $metadata->isInheritedAssociation($property->getName())) {
				continue;
			}

			$propertyMetaData = $classSchema->getProperty($property->getName());

			if (!isset($mapping['type'])) {
				switch ($propertyMetaData['type']) {
					case 'DateTime':
						$mapping['type'] = 'datetime';
						break;
					case 'string':
					case 'integer':
					case 'boolean':
					case 'float':
					case 'array':
						$mapping['type'] = $propertyMetaData['type'];
						break;
					default:
						if (strpos($propertyMetaData['type'], '\\') !== FALSE) {
							if ($this->reflectionService->isClassAnnotatedWith($propertyMetaData['type'], 'Cognifire\BuilderFoundation\Annotations\ValueObject')) {
								$mapping['type'] = 'object';
							} elseif (class_exists($propertyMetaData['type'])) {

								throw \Doctrine\ORM\Mapping\MappingException::missingRequiredOption($property->getName(), 'OneToOne', sprintf('The property "%s" in class "%s" has a non standard data type and doesn\'t define the type of the relation. You have to use one of these annotations: @OneToOne, @OneToMany, @ManyToOne, @ManyToMany', $property->getName(), $className));
							}
						} else {
							throw \Doctrine\ORM\Mapping\MappingException::propertyTypeIsRequired($className, $property->getName());
						}
				}
			}

			$metadata->mapField($mapping);
		}*/
	}

	/**
	 * Evaluate the association overrides annotations and amend the metadata accordingly.
	 *
	 * @param array $classAnnotations
	 * @param \Doctrine\ORM\Mapping\ClassMetadataInfo $metadata
	 * @return void
	 */
	protected function evaluateOverridesAnnotations(array $classAnnotations, \Doctrine\ORM\Mapping\ClassMetadataInfo $metadata) {}

	/**
	 * Evaluate the lifecycle annotations and amend the metadata accordingly.
	 *
	 * @param \ReflectionClass $class
	 * @param \Doctrine\ORM\Mapping\ClassMetadataInfo $metadata
	 * @return void
	 */
	protected function evaluateLifeCycleAnnotations(\ReflectionClass $class, \Doctrine\ORM\Mapping\ClassMetadataInfo $metadata) {}

	/**
	 * Whether the class with the specified name should have its metadata loaded.
	 * This is only the case if it is either mapped as an Entity or a
	 * MappedSuperclass (i.e. is not transient).
	 *
	 * @param string $className
	 * @return boolean
	 */
	public function isTransient($className) {
		return strpos($className, \TYPO3\Flow\Object\Proxy\Compiler::ORIGINAL_CLASSNAME_SUFFIX) !== FALSE ||
			   (
				   !$this->reflectionService->isClassAnnotatedWith($className, 'Cognifire\BuilderFoundation\Annotations\Entity') &&
				   !$this->reflectionService->isClassAnnotatedWith($className, 'Cognifire\BuilderFoundation\Annotations\ValueObject')
			   );
	}

	/**
	 * Returns the names of all mapped (non-transient) classes known to this driver.
	 *
	 * @return array
	 */
	public function getAllClassNames() {
		if (is_array($this->classNames)) {
			return $this->classNames;
		}

		$this->classNames = array_merge(
			$this->reflectionService->getClassNamesByAnnotation('Cognifire\BuilderFoundation\Annotations\ValueObject'),
			$this->reflectionService->getClassNamesByAnnotation('Cognifire\BuilderFoundation\Annotations\Entity')
		);
		$this->classNames = array_filter($this->classNames,
			function ($className) {
				return !interface_exists($className, FALSE)
					   && strpos($className, \TYPO3\Flow\Object\Proxy\Compiler::ORIGINAL_CLASSNAME_SUFFIX) === FALSE;
			}
		);

		return $this->classNames;
	}

}
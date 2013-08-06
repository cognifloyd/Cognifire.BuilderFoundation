<?php
namespace Cognifire\BuilderFoundation\BlobQuery\Aspect;

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


use TYPO3\Eel\FlowQuery\FlowQueryException;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Eel\FlowQuery\OperationResolver;
use Cognifire\BuilderFoundation\BlobQuery\Operations\BlobTypeSpecificOperations;

/**
 *
 *
 * @Flow\Aspect
 */
class BlobTypeSpecificOperationsAspect {


	/**
	 * The currentOperationName gets lost when $op->evaluate() is called.
	 * This should help make it accessible again.
	 *
	 * @Flow\Introduce("class(TYPO3\Eel\FlowQuery\FlowQuery)")
	 * @var string
	 */
	protected $currentOperationName;

	/**
	 * evaluate in my BlobTypeSpecificOperations class needs access to the operationName used to call it.
	 * This is a first attempt at making it accessible, though I'm not sure it will actually work this way.
	 *
	 * @Flow\Before("method(TYPO3\Eel\FlowQuery\FlowQuery->__call())"
	 * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
	 */
	public function addOperationName(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {
		$joinPoint->getProxy()->currentOperationName = $joinPoint->getMethodArgument('operationName');
	}

	/**
	 * a map of shortName (in FlowQuery), methodName (on Blob), and whether or
	 * it is a final operation.
	 *
	 * @var array
	 */
	protected $blobMethodMap = array(
		/*shortOperationName => array(
			operationPriority => array(
				'blobType' => blobType,
				'final' => final,
				'methodAlias' => methodAlias
					//if the methodName is different from the operationShortName, specify it here
					//by default the methodName is the same as the operationName
					//This allows for aliases to provide a more fluent interface, while retaining more descriptive function names.
					//and each operation can have its own priority.
			),
		)*/
	);

	/**
	 * Inject settings array
	 *
	 * @param  array $configuration
	 * @return void
	 */
	public function injectSettings(array $configuration) {
		$this->blobMethodMap = $configuration['methods'];
	}

	/**
	 * modifies the
	 *
	 * @Flow\Before("method(TYPO3\Eel\FlowQuery\OperationResolver->initializeObject())"
	 * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
	 * @throws \TYPO3\Eel\FlowQuery\FlowQueryException
	 * @return void
	 */
	public function injectBlobTypeSpecificOperationsInResolver(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {
		/** @var TYPO3\Eel\FlowQuery\OperationResolver $thisProxy */
		$thisProxy = $joinPoint->getProxy();
		// I'm not sure if this is the right way to access properties in the target class...

		if(isset($thisProxy->operations['blob-type-specific'])) {
			unset($thisProxy->operations['blob-type-specific']);
		}
		foreach($this->blobMethodMap as $shortOperationName => $operationPriorities) {
			foreach($operationPriorities as $operationPriority => $operationOptions) {
				$isFinalOperation = $operationOptions['final'];
				// $blobType and $methodName is not important to the operationResolver, but it is very important to the BlobTypeSpecificOperations
				//$blobType = $operationOptions['blobType'];
				//$methodName = isset($operationOptions['methodAlias']) ? $operationOptions['methodAlias'] : $shortOperationName;

				if (!isset($thisProxy->operations[$shortOperationName])) {
					$thisProxy->operations[$shortOperationName] = array();
				}

				if (isset($thisProxy->operations[$shortOperationName][$operationPriority])) {
					throw new FlowQueryException(sprintf('Operation with name "%s" and priority %s is already defined in class %s, and the class %s has the same priority and name.', $shortOperationName, $operationPriority, $this->operations[$shortOperationName][$operationPriority], $operationClassName), 1332491678);
					/**
					 * TODO[cognifloyd] how can I ensure that the same priority doesn't get used across blobTypes?
					 * Perhaps the priority should be set with some kind of specificity algorithm instead of having
					 * developers choose the priority, which would mean I would be using
					 * $blobMethodMap[$shortOperationName][$blobType] with a generated priority instead of
					 * $blobMethodMap[$shortOperationName][$blobPriority][$blobOptionName]
					 * I don't like specifying the priority in the settings file. It feels wrong.
					 */
				}

				$thisProxy->operations[$shortOperationName][$operationPriority] = 'Cognifire\BuilderFoundation\BlobQuery\Operations\BlobTypeSpecificOperations';

				if ($isFinalOperation) {
					$thisProxy->finalOperationNames[$shortOperationName] = $shortOperationName;
				}
			}
		}
	}
}
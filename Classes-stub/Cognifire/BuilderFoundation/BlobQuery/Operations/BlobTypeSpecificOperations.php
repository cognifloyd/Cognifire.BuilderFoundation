<?php
namespace Cognifire\BuilderFoundation\BlobQuery\Operations;

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


use TYPO3\Eel\FlowQuery\FlowQuery;
use TYPO3\Flow\Annotations as Flow;

/**
 * What do I do about getShortName(), getPriority() and isFinal()?
 *
 * the OperationResolver expects simple values for this, but I have one class
 * many different operations...
 */
class BlobTypeSpecificOperations extends AbstractBlobOperation {

	/**
	 * a map of shortName (in FlowQuery), methodName (on Blob), and whether or
	 * it is a final operation.
	 *
	 * @var array
	 */
	protected $blobMethodMap = array();
	//$blobType = $this->blobMethodMap[$shortOperationName][$operationPriority]['blobType']
	//$isFinal = $this->blobMethodMap[$shortOperationName][$operationPriority]['final']
	//$methodAlias = $this->blobMethodMap[$shortOperationName][$operationPriority]['methodAlias']

	/**
	 * {@inheritdoc}
	 *
	 * @var integer
	 */
	protected static $priority = 0;

	/**
	 * {@inheritdoc}
	 *
	 * @var string
	 */
	protected static $shortName = 'blob-type-specific';

	/**
	 * {@inheritdoc}
	 *
	 * @var bool
	 */
	protected static $final = true;

	/**
	 * {@inheritdoc}
	 *
	 * @var array
	 */
	protected $supportedBlobTypes = array();

	/**
	 * {@inheritdoc}
	 *
	 * @var array
	 */
	protected $unsupportedBlobTypes = array();

	/**
	 * {@inheritdoc}
	 *
	 * @param FlowQuery $flowQuery
	 * @param array     $arguments
	 * @return FlowQuery
	 */
	public function evaluate(FlowQuery $flowQuery, array $arguments) {
		//Once evaluate is called, I have no way of knowing what operationName was used to refer to this class.
		//I might need to add that to FlowQuery
		$method = $flowQuery->currentOperationName;
		//There's already a __call method... I could add getCurrentOperationName as an operation, but that still
		//doesn't give me access to the shortOperationName. What if I injected this functionality through an aspect?
		//Can aspects add methods to a class? I can introduce a property.

		//So it looks like I might have to either extend FlowQuery somehow to get access to the operation name,
		//Or I have to require adding a blob operation class for every operation...

		$blobSelection = $flowQuery->getContext();

		foreach($blobSelection as $blob) {
			$blob->$method($arguments);
		}
	}

	/**
	 * {@inheritdoc}
	 *
	 * @param  array $context
	 * @return bool
	 */
	public function canEvaluate($context) {
		return FALSE;
	}

	/**
	 * Inject settings array
	 *
	 * @param  array $configuration
	 * @return void
	 */
	public function injectSettings(array $configuration) {
		$this->blobMethodMap = $configuration['methods'];
	}

}
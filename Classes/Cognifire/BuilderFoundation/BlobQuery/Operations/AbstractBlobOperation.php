<?php
namespace Cognifire\BuilderFoundation\BlobQuery\Operations;

/*																		*
 * This script belongs to the TYPO3 Flow package						  *
 * "Cognifire.BuilderFoundation".										 *
 *																		*
 * It is free software; you can redistribute it and/or modify it under	*
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.						*
 *																		*
 * The TYPO3 project - inspiring people to share!						 *
 *																		*/


use TYPO3\Eel\FlowQuery\Operations\AbstractOperation;
use TYPO3\Flow\Annotations as Flow;

/**
 *
 */
class AbstractBlobOperation extends AbstractOperation {

	/**
	 * {@inheritdoc}
	 *
	 * @var string
	 * @api
	 */
	static protected $shortName = '';

	/**
	 * array(
	 *     static::$shortName => array(
	 *         $blobType, $blobType, $blobType
	 *     )
	 * )
	 *
	 * @var array
	 */
	protected $supportedBlobTypes = array();

	/**
	 * array(
	 *     static::$shortName => array(
	 *         $blobType, $blobType, $blobType
	 *     )
	 * )
	 *
	 * @var array
	 */
	protected $unsupportedBlobTypes = array();

	/**
	 * {@inheritdoc}
	 *
	 * uses getSupportedBlobTypes to see which blobTypes are supported for this operation and returns TRUE
	 * if this blobType is in the list of supported blobTypes.
	 *
	 * It's like a built-in filter to make sure that any domain operations are only run on domainBlobs.
	 *
	 * @param  array   $context
	 * @return boolean
	 */
	public function canEvaluate($context) {
		return FALSE;
	}

	/**
	 *
	 *
	 * @param  string $shortName
	 * @return array
	 */
	public function getSupportedBlobTypes($shortName) {
		$return = array();
		//check $this->getSupportedBlobTypes to see if this one is supported
		return $return;
	}

	/**
	 * Short description of method getUnsupportedBlobTypes
	 *
	 * @param  string $shortName
	 * @return array
	 */
	public function getUnsupportedBlobTypes($shortName) {
		$return = array();
		//check $this->getSupportedBlobTypes to see if this one is supported
		return $return;
	}

	/**
	 * Evaluate the operation on the objects inside $flowQuery->getContext(),
	 * taking the $arguments into account.
	 * The resulting operation results should be stored using $flowQuery->setContext().
	 * If the operation is final, evaluate should directly return the operation result.
	 *
	 * @param \TYPO3\Eel\FlowQuery\FlowQuery $flowQuery the FlowQuery object
	 * @param array						  $arguments the arguments for this operation
	 *
	 * @return mixed|null if the operation is final, the return value
	 */
	public function evaluate(\TYPO3\Eel\FlowQuery\FlowQuery $flowQuery, array $arguments) {
		self::$shortName;
	}
}

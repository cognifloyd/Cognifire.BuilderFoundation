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


use TYPO3\Flow\Annotations as Flow;

/**
 *
 */
class ReplaceBlobOperation {

	/**
	 * @var string
	 */
	protected static $shortName = 'replace';

	/**
	 * @var integer
	 */
	protected static $priority = 0;

	/**
	 * @var boolean
	 */
	protected static $final = FALSE;

	/**
	 * @var array
	 */
	protected $supportBlobTypes = array();

	/**
	 * @var array
	 */
	protected $unsupportedBlobTypes = array();

	/**
	 *
	 *
	 * @param \TYPO3\Eel\FlowQuery\FlowQuery $flowQuery
	 * @param  array $arguments
	 * @return void
	 */
	public function evaluate(\TYPO3\Eel\FlowQuery\FlowQuery $flowQuery, $arguments) {

	}
}
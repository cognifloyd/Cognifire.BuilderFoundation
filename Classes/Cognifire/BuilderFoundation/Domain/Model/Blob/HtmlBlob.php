<?php
namespace Cognifire\BuilderFoundation\Domain\Model\Blob;
// This will be in the TemplateBuilder package, but I'm putting it in BuilderFoundation for now for demo purposes.

/*                                                                        *
 * This script belongs to the TYPO3 Flow package                          *
 * "Cognifire.TemplateBuilder".                                           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */


use Cognifire\BuilderFoundation\Annotations as Blob;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\Core\Parser\ParsedTemplateInterface;
use TYPO3\Fluid\Core\Parser\SyntaxTree\NodeInterface;
use TYPO3\Fluid\Core\Parser\TemplateParser;

/**
 * This should manipulate fluid files by using the fluid parser to modify the abstract syntax tree.
 *
 * @Blob/Entity
 */
class HtmlBlob {

	/**
	 * A DOM Syntax Node (one node per HtmlBlob)
	 *
	 * @var \DOMNode
	 */
	protected $currentNode;

	/**
	 * $this->currentNode->
	 *   appendNode
	 *   childNodes
	 *
	 * subBlobs should be generated on the fly using the ChildNodes from Html.
	 *
	 * node types:
	 */

	/**
	 * @var QueryPath the QueryPath object
	 */
	protected $htmlqp;

	/**
	 * @var string
	 */
	protected $rawContents = '';

	public function test() {
		$this->currentNode;
	}

	/**
	 * An array of Text, HTML, and Fluid Blobs.
	 *
	 * @var array
	 */
	protected $childBlobs = array();

	/**
	 * @param $stringContents string
	 */
	public function __construct($stringContents) {
		$this->rawContents = $stringContents;
	}

	/**
	 *
	 */
	public function __toString() {
		$stringOutput = '';
		//TODO[cognifloyd] logic to convert parsed template back into a string
		return $stringOutput;
	}

	/**
	 * This passes the calls on to the wrapped QueryPath object.
	 *
	 * @param string $operationName
	 * @param array  $arguments
	 */
	public function __call($operationName, array $arguments) {
		//maybe this should be specified in Settings.yaml...
		//Working out the list of operations in the QueryPath worksheet here:
		// http://bit.ly/blobquery-apicomparison
		switch($operationName) {
			case '':
				return $this->htmlqp->$operationName($arguments);
			//This is a blacklist of the unsupported querypath operations
			default:
				throw UnsupportedOperationException('stupid');
		}
	}
}
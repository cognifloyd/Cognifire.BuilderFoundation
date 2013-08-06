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
class FluidBlob {

	/**
	 * A Fluid Syntax Node (one node per FluidBlob)
	 * When loading a template, the RootNode is extracted from the ParsedTemplate.
	 * And each childNode is added as a a FluidBlob.
	 * TextNodes are converted into HTML (though, they aren't guaranteed to
	 * be html. There are times where PHP code is rammed through Fluid, so
	 * there needs to be a way to say that a particular textnode can be converted
	 * into HTML. Also, what do I do when the fluid tags are embedded in HTML?
	 * How do I go back and forth?
	 *
	 * @var NodeInterface
	 */
	protected $currentNode;

	/**
	 * $this->currentNode->
	 *   evaluateChildNodes
	 *   getChildNodes
	 *   addChildNode
	 *   evaluate
	 *
	 * subBlobs should be generated on the fly using the ChildNodes from Fluid.
	 *
	 * node types:
	 *   Array
	 *   Boolean
	 *   Numeric
	 *   ObjectAccessor
	 *   Root
	 *   Text
	 *   ViewHelper
	 */

	/**
	 * @var string
	 */
	protected $rawContents = '';

	/**
	 * @Flow\Inject
	 * @var TemplateParser
	 */
	protected $parser;

	/**
	 * @var ParsedTemplateInterface
	 */
	protected $parsedTemplate = NULL;



	/**
	 * An array of Text, HTML, and Fluid Blobs.
	 *
	 * @var array
	 */
	protected $childBlobs = array();

	/**
	 *
	 */
	protected $filterEngine;

	/**
	 * @param $stringContents string
	 */
	public function __construct($stringContents) {
		$this->rawContents = $stringContents;
		$this->parsedTemplate = $this->parser->parse($this->rawContents);
	}

	/**
	 *
	 */
	public function __toString() {
		if($this->parsedTemplate === NULL) {
			return $this->rawContents;
		}
		$stringOutput = '';
		//TODO[cognifloyd] logic to convert parsed template back into a string
		return $stringOutput;
	}
	/**
	 * ParsingState->
	 * getRootNode/setRootNode
	 * render
	 *
	 * so i take the rootNode from the parsedTemplate and that is the contents
	 * of this FluidBlob, and then each subNode is another Blob
	 */
	/**
	 * Node properties:
	 *
	 * nodeData
	 * context
	 * nodeDataIsMatchingContext
	 * nodeDataRepository
	 * nodeFactory
	 *
	 */
	/**
	 * Node Functions:
	 *
	 * Path:
	 *   getContextPath
	 *   get/set Path
	 *   get Depth
	 *   ParentPath
	 *
	 * get
	 >*   Name
	 *   Label
	 *   Abstract
	 *   Workspace
	 >*   Index (location info)
	 >*   Parent
	 >*   Property (attribute)
	 *   ContentObject
	 >*   NodeType
	 >*   Node
	 >*   childNodes
	 *   numberOfChildNodes
	 *   accessRoles
	 *   context
	 *   nodeData
	 *
	 * is
	 * 	 removed
	 *   hidden
	 *   visible
	 *   accessible
	 *
	 >* move/copy
	 *   Before
	 *   After
	 *   Into
	 *
	 * create
	 >*   singleNode
	 *   NodeFromTemplate
	 >*   recursiveCopy
	 */
}
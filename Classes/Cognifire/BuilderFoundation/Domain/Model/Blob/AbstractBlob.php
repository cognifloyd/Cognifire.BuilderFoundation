<?php
namespace Cognifire\BuilderFoundation\Domain\Model\Blob;

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
 * You should extend this if you want to allow a builder to handle an additional media type or file type (ie a blob).
 *
 * **This class is meant to be subclassed by developers.**
 *
 * Potential possible Blobs include:
 * - Text (Plain text file would be edited via regex)
 * - Fluid
 * - PHP
 * - TypoScript
 * - YAML
 * - CSS (& variants: SASS/SCSS, LESS)
 *
 * This is not called a File or a Stream on purpose. It is a string that can be edited as a particular mediaType.
 * Blobs can contain other blobs and do not have to be part of a package, though they are generally just package files.
 * A blob could be:
 * - a file in a package
 * - part of a file in a package (like a file that acts like a snippet library)
 * - a stream (like a snippet from some snippet service on a remote server somewhere)
 * - a part of a stream (a multi-part mime email perhaps)
 *
 * @api
 */
abstract class AbstractBlob implements BlobInterface {

	/**
	 * This is the raw contents of the file.
	 *
	 * TODO[cognifloyd] I'd like this to be lazy loaded, but I'm not sure how to do that.
	 * For now, do I load the contents through a setter, a constructor, or ...?
	 *
	 * @var string
	 */
	protected $contents = '';

	/**
	 * The parser for this fileType, used to interact with the contents of the blob
	 * (generally via some kind of syntaxTree)
	 * **Classes that subclass this class should override this var's type with a parser object**
	 *
	 * Ideally, the parser should preserve whitespace when writing this back to a file.
	 *
	 * @var mixed
	 */
	protected $parser;

	/**
	 * Generally, interact with the syntaxTree (probably an array or a special object)
	 * to add or remove something in a blob.
	 * **Classes that subclass this class should override this var's type with a parser object**
	 * @var mixed
	 */
	protected $syntaxTree;

}
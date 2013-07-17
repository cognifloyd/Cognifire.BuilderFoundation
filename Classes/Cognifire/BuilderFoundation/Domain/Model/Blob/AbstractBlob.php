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
 * A blob may also serve as a kind of generic syntax tree used to build blobs. For example, the PackageBuilder
 * might create a DomainBlob that is a more abstract version of a PhpBlob
 *
 * This is not called a File or a Stream on purpose. It is a string that can be edited as a particular mediaType.
 * Blobs can contain other blobs and do not have to be part of a package, though they are generally just package files.
 * A blob could be:
 * - a file in a package
 * - part of a file in a package (like a file that acts like a snippet library)
 * - a stream (like a snippet from some snippet service on a remote server somewhere)
 * - a part of a stream (a multi-part mime email perhaps)
 *
 * Blobs are not explicitly part of a package, so there is not packageKey.
 * to get blobs from a package, you use BlobQuery to get the initial set of
 * from a given package.
 *
 * subBlobs should be stored in whatever properties make sense for the domain.
 * TODO[cognifloyd] Need something to autodetect which injected objects are @Blob/Entity to make selecting subBlobs easier
 *
 * also, this needs some kind of identity
 * TODO[cognifloyd] Probably using a magic identity aspect like Flow's persistence layer does
 *
 * also, the contents could be extracted to a blobData class to act as a proxy
 * only load the contents if they are accessed.
 * TODO[cognifloyd] Implement the BlobData class. For now, it's just a $contents string.
 *
 * @api
 */
abstract class AbstractBlob implements BlobInterface {

    /**
	 * This is a string that must be defined in every Blob. One Blob Class = One BlobType.
	 * A blob may have sub-types, but that is not implemented right now.
	 *
	 * **Classes that subclass this class should use this var to specify the BlobType**
     *
     * @var string
	 * @api
     */
    protected $blobType = '';

	/**
	 * This is the raw contents of the file/snippet/stream (blob).
	 *
	 * TODO[cognifloyd] I'd like this to be lazy loaded possibly through a BlobData object
	 * For now, load the contents through setContents($contents);
	 *
	 * @var string
	 */
	protected $contents = '';

	/**
	 * {@inheritdoc}
     *
     * @param  string $method
     * @param  array $arguments return new FlowQuery()->$method($arguments)
     * @return \TYPO3\Eel\FlowQuery\FlowQuery
	 * @api
     */
    public function __call($method, $arguments) {
        $returnValue = null;

        return $returnValue;
    }

    /**
	 * {@inheritdoc}
     *
     * @return string
	 * @api
     */
    public function getBlobType() {
        return $this->blobType;
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $blobType
     * @return void
     */
    public function setBlobType($blobType) {
		$this->blobType = $blobType;
    }

    /**
	 * {@inheritdoc}
	 *
	 * **Classes that subclass this class should override this method**
     *
     * @return string
	 * @api
     */
    public function __toString() {
		return $this->contents;
	}

    /**
	 * {@inheritdoc}
     *
	 * **Classes that subclass this class should override this method**
     *
     * @param  $string
     * @return void
	 * @api
     */
    public function setContents($string) {
		$this->contents = $string;
	}
}
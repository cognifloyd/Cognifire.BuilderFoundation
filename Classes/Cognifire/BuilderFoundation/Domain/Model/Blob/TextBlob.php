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
 * This should manipulate text files with regex. It is the simplest kind of media to edit.
 * This serves as an example of how to write a blob.
 * @api
 */
class TextBlob extends AbstractBlob {
/**
     * Short description of attribute $blobType
     *
     * @access public
     * @var string
     */
    public static $blobType = 'text';

    /**
     * {@inheritdoc}
     *
     * @param  $string
     * @return void
	 * @api
     */
    public function setContents($string) {
		$this->contents = $string;
    }

	/**
	 * {@inheritdoc}
	 *
	 * @return string
	 * @api
	 */
	public function __toString() {
		return $this->contents;
	}

}
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
 * Register your BlobFactory by
 * TODO[cognifloyd] Create some kind of BlobFactoryRegistry to pick how to deal with each blob based on mediaType
 * The BlobFactoryRegistry expects singleton classes for each mediaType.
 *
 * Potential possible Factories include:
 * - Text (Plain text file would be edited via regex)
 * - Fluid
 * - PHP
 * - TypoScript
 * - YAML
 * - CSS (& variants: SASS/SCSS, LESS)
 *
 * @api
 */
abstract class AbstractBlob implements BlobInterface {

}
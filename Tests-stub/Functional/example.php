<?php
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

$df = new \Cognifire\BuilderFoundation\BlobQuery\BlobQuery('Cognifire.Example:<FluidHtml>');

$df->integrateBoilerplate('Cognifire.EmptyBoilerplate','presetName',array('optionKey'=>'optionValue'))
	/**
	 * uses the selector (other than the package key) from the current selection,
	 * and selects everything from the indicated Boilerplate that matches that selector,
	 * then copies them into the derivative (always focus on the derivative)
	 * And the current selection returned in the FlowQuery object is all of the cloned files
	 * that were just copied into the derivative.
	 *
	 * Some magic boilerplate processing may occur at this point, based on the options and the
	 * derivative packageKey. For example, instances of a magic string like Vendor.PackageKey, or
	 * the Boilerplate's packageKey could automatically be replaced with the derivative PackageKey.
	 * (using some string magic, maybe, or automatically inserting some additional package steps
	 * as defined in the boilerplate)
	 * In other words, the Boilerplate should have a way to tie into this function and say:
	 * Given these options, copy these files this way.
	 * It could also, maybe, say that certain files are required. It would be at this point that you
	 * would set a "preset"... Not sure how that works exactly.
	 */

	->replacePreg
;
<?php
namespace Cognifire\BuilderFoundation\Domain\Model\Package;

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


use Cognifire\BuilderFoundation\Package\Flow\AbstractFlowPackage;
//use Cognifire\BuilderFoundation\Package\AbstractPackage;
use TYPO3\Flow\Annotations as Flow;

/**
 * Derivatives aren't always Flow Packages
 * TODO[cognifloyd] This needs DerivativePackageStrategies so that both TYPO3 Flow and TYPO3CMS Deriatives are supported
 */
class DerivativePackage extends AbstractFlowPackage {
//class DerivativePackage extends AbstractPackage {
/*
 * Eventually, the kind of package in use needs to move up a level. I suspect that AbstractPackage will be an important
 * location that will help to choose which package type to use (Flow or Irregular). So, this will end up extending
 * AbstractPackage instead of AbstractFlowPackage.
 *
 * Somehow, there needs to be a way to have a strategy for different kinds of Derivative Packages, so that it extends
 * the AbstractFlowPackage if it's a Flow Package, or the appropriate Abstract[Type]IrregularPackage. I'm not sure how
 * to do that at this point, even though I think the IrregularPackageManager will be an integral component in that.
 *
 * When someone wants to add a strategy, they'll need to (1) provide an Abstract[Type]IrregularPackage that fleshes out
 * some important set of methods (I don't know what those methods might include yet), the implementation of which
 * depends on the strategy at hand; (2) Configure the IrregularPackageManager so that it knows the general layout of
 * where different files go in the package structure; and (3) add/extend the IrregularPackageFactory of the
 * IrregularPackageManager to help in the creation of these IrregularPackages.
 *
 * Initial work on this IrregularPackageManager stuff is in the irregular-package branch.
 *
 * For now, I'm going to ignore this, and just assume that the derivative is a valid Flow Package as well. Before I
 * felt safe making this assumption I wanted to explore how the Irregular Package stuff might work out, because this is
 * a very important *planned* extension point, and I don't want to make it impossible to go down that path when the
 * time comes.
 */


}
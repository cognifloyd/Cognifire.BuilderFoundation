<?php
namespace Cognifire\BuilderFoundation;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cognifire.BuilderBase". *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */


use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Configuration\ConfigurationManager;
use TYPO3\Flow\Package\Package as BasePackage;

/**
 * The Cognifire.BuilderFoundation package
 */
class Package extends BasePackage {

	/**
	 * Invokes custom PHP code directly after the package manager has been initialized.
	 *
	 * @param \TYPO3\Flow\Core\Bootstrap $bootstrap The current bootstrap
	 * @return void
	 */
	public function boot(\TYPO3\Flow\Core\Bootstrap $bootstrap) {
		$dispatcher = $bootstrap->getSignalSlotDispatcher();
		$dispatcher->connect(
			'TYPO3\Flow\Configuration\ConfigurationManager',
			'configurationManagerReady',
			function($configurationManager) {
				$configurationManager->registerConfigurationType(
					'Builder',
					ConfigurationManager::CONFIGURATION_PROCESSING_TYPE_DEFAULT,
					TRUE //allowSplitSource
				);
			}
		);
	}
}
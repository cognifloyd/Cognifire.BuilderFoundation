<?php

$derivative = new BlobQuery('Cognifire.SweetSitePackage');

$derivative->integrateBoilerplate('Cognifire.EmptyBoilerplate','presetName',array('optionKey'=>'optionValue'))

$derivative->branch()->find('title')->replaceWithFluidViewHelper('base');
$fluidTemplate = $derivative->branch()->selectBlob($sourceTemplateFilename);
$fluidTemplate->addFluidNamespace('neos','TYPO3.Neos')
              ->addFluidLayout('default')
              ->branch()->find('#sidebar')->replaceWithFluidRenderSection('sidebar')->addFluidSection();
$fluidTemplate->branch()->find('#menu')->replaceWithFluidViewHelper('menu','neos');
$fluidSection = $fluidTemplate->branch()->find('#sidebar')
								              ->replaceWithFluidRenderSection('sidebar')->addFluidSection();
$fluidPartial = $fluidSection->branch()->find('.author')
                             ->replaceWithFluidRenderPartial('author')->first()->writeFluidPartial();


$derivative->branch()->cloneFromBoilerplate('Cognifire.EmptyBoilerplate:resources/templates/menu/vertical.html')
					 ->replacePreg( 'stupid text', 'better text' );
$derivative->branch()->selectBlobs( 'templates/*.html' )->find( '#fantasticMenu' )
					 ->replaceWithFluidRenderSection('verticalMenu'); //This uses the menu cloned above.

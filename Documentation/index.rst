API Description
===============

All of these examples are looking at each user story from within the code. This is what the API could
look/feel like. I'm trying to make this Flow as much as possible. I assume that once there is a UI,
the UI will send some kind of payload to the backend that runs each of these... I'm not sure how a
resource-centric web-api might look for this yet. Again: I'm trying to get everything working from
within PHP first.

As an integrator I want to
--------------------------

Create a set of fluid templates from a source template
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The source template was probably made by a designer.


.. code:: php

    $derivative = new Derivative( 'Cognifire.SweetSitePackage' );

    $derivative->branch()->find('title')->replaceWithFluidViewHelper('base');
    $fluidTemplate = $derivative->branch()->selectBlob($sourceTemplateFilename);
    $fluidTemplate->addFluidNamespace('neos','TYPO3.Neos')
            ->addFluidLayout('default')
            ->branch()->find('#sidebar')->replaceWithFluidRenderSection('sidebar')->addFluidSection();
    $fluidTemplate->branch()->find('#menu')->replaceWithFluidViewHelper('menu','neos');
    $fluidSection = $fluidTemplate->branch()->find('#sidebar')
            ->replaceWithFluidRenderSection('sidebar')->addFluidSection();
    $fluidPartial = $fluidSection->branch()->find('#contet > .section > div.author')
            ->replaceWithFluidRenderPartial('author')->first()->writeFluidPartial();


.. note::

  maybe instead calling branch() all the time, I should make BlobQuery callable by default, and whenever called,
  like in `$derivative()`, it automatically branches so that $derivative is alwasys clean, but you can set
  another variable to something in a BlobQuery, and that won't be callable. (not quite sure on this one...)

Create a set of fluid templates from a boilerplate
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

`integrateBoilerplate()` uses the selector (other than the package key) from the current selection,
and selects everything from the indicated Boilerplate that matches that selector,
then copies them into the derivative (always focus on the derivative)
And the current selection returned in the FlowQuery object is all of the cloned files
that were just copied into the derivative.

This is a planned extension point. Builders (and highly specialized boilerplates) may define additonal
steps/operations that need to be carried out to "integrate" these files from the boilerplate.
The builder might use a builder-specific preset (such as a "theme" for the TemplateBuilder) to modify
what steps are part of the integration.

For example, a builder might insert the derivative's packageKey at certain points in the files.

One of the operations that should be carried out by `integrateBoilerplate()` is `cloneFilesFromBoilerplate()`.

.. code:: php

    $derivative = new Derivative( 'Cognifire.SweetSitePackage' );
    
    $derivative->integrateBoilerplate( 'Cognifire.EmptyBoilerplate', 'emptyLayoutPreset' );

.. code:: php

    public class Derivative {
    
        public function integrateBoilerplate( $packageKey, $presetName = '',$options = array() ) {
        
            $this->preCloneSteps(); //not sure how builders will tie in here
            $this->cloneFromBoilerplate( $packageKey, $presetName, $options );
            $this->postCloneSteps(); //not sure how builders will tie in here
        
        }
    }

Migrate my fluid templates from one boilerplate version to the next
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
or from one source template version to the next
'''''''''''''''''''''''''''''''''''''''''''''''

.. code:: php

    //comment

A a Content Manager I want to
-----------------------------

Add a fluid widget from a boilerplate into my fluid templates
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

like a menu or a hero unit

.. code:: php

    $derivative = new Derivative('Cognifire.SweetSitePackage');

    $derivative->branch()->cloneFromBoilerplate('Cognifire.EmptyBoilerplate:resources/templates/menu/vertical.html')
	       ->replacePreg( 'stupid text', 'better text' );
    $derivative->branch()->selectBlobs( 'templates/*.html' )->find( '#fantasticMenu' )
	       ->replaceWithFluidRenderSection('verticalMenu'); //This uses the menu cloned above.

Change options in my fluid templates and my styles
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

(in the builder)
Options like which class to use (fixed or fluid layouts in bootstrap).
Styles like colors or font-size.

.. code:: php

    /**
     * I'm not sure what modifying the options layer looks like in PHP yet...
     * though I'm pretty sure I want to have an annotation to allow automatically injecting them
     * from the relevant derivative.yaml or boilerplate.yaml (injectSettings() won't work for these)
     *
     * @Blob/Config('path.to.some.relevant.setting')
     * @var array
     */
    protected relevantSetting;
    
    //TODO: Figure out what interacting with "options" looks like, including presets and overriding presets...

As a PHP Developer I want to
----------------------------

Edit Fluid Templates externally and in Template Builder at the same time
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

I like to use vim and PhpStorm

.. code:: php

    //TODO: After basic template editing is in place
    
.. note::
    
    Once basic fluid editing is in place via BlobQuery and BlobOperations, then I plan on keeping track
    of those operations in the derivatives.yaml file. Then, I'll use Flow's file monitor (if, for example
    a Builder is running) to watch for file changes and trigger a new RoundTrip service that should be
    able to detect the changes in the file (semantically, not just a textual diff) and add those changes
    as Builder steps in the deriatives.yaml file.

Create a fluid template for my new action controller
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: php

    //instead of just kickstarting it, clone a template from a boilerplate, and insert the default action controller stuff
    $template = new ( 'Cognifire.SweetSitePackage' )->selectTemplateForController('coolController');
    
    $template->find('#content')->cloneFromBoilerplate('PackageBuilder:resources/templates/actionController.html:#content');

Change options by hand
~~~~~~~~~~~~~~~~~~~~~~

The same options that the content manager wants to change in the builder,
I want to be able to just change them in a settings file without dealing with a UI.

.. code:: php

    //see above. I don't know about the options layer from within php yet, though I have an idea about
    //how it might look in the yaml file: It will be something like the presets of TYPO3.Form.

As a Designer I want to
-----------------------

mock up new templates quickly using a set of pre-made template widgets
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: php

    //temporary template
    $temp = new Derivative(,,array('withTemporaryFiles'=>'true'));//or do it in a derivative...
    
    //maybe I don't need to say "clone" but just say "from"... that makes it feel more fluent
    $temp->fromBoilerplate('Zurb.Foundation','Grid')
        ->find('footer')->replacePreg('no one at all','Agency Awesome Sauce')
        ->find('div:last-of-type')->replaceWithFluidRenderSection('footerLinks');

Declare which components are available in my boilerplate / used in my derivative
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: php

    //see 'reuse a set of fluid templates' for talk on building a boilerplate. I don't know what this API looks like.

As a Project Manager I want to
------------------------------

Reuse a set of fluid templates across multiple sites
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

basically for this one, you'll create a boilerplate and then clone the relevant templates and widgets
from the boilerplate into each site package. 


.. code:: php

    //no idea if a special boilerplate kickstarter is needed.
    someClassSomewhere->kickstartBoilerplate('Agency.AwesomeSauceBoilerplate');
    
    $boilerplate = new Derivative( 'Agency.AwesomeSauceBoilerplate' );
    $boilerplate->???;
    
.. note::
    
    will this be done programatically? I think a lot of boilerplates will be kickstarted with the packageKickstarter,
    and then someone will put the template files in here (possibly treating it like a derivative and cloning them from
    a package that already exists), and then manually defining the presets that are available. A builder should probably
    offer helpful functions to assist with generating the presets in a boilerplate... This requires more thought.
    

migrate the fluid templates in all of my sites to use my latest widget
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

(such as a menu, or a youtube plugin)

Continuing story from above: Then, as long as you maintain your migration scripts, you'll be able to
update each site package with the updated widgets fairly automatically.

.. code:: php

    //I haven't figured out the migration API yet, but hopefully, by keeping track of the steps used to
    //create different files, I can do something like git and "replay" those changes on derivative files
    //Which means that boilerplates will end up with a derivatives.yaml as well, to track the changes
    //to their files, even if those changes don't come from other boilerplates, they come from manual
    //changes


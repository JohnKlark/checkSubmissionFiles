<?php
import('lib.pkp.classes.plugins.GenericPlugin');
class checkSubmissionFilesPlugin extends GenericPlugin {
	public function register($category, $path, $mainContextId = NULL) {

		// Register the plugin even when it is not enabled
		$success = parent::register($category, $path);

		if ($success && $this->getEnabled()) {
			// Do something when the plugin is enabled
			HookRegistry::register('submissionsubmitstep2form::validate', function($hookName, $params) {
				$form = $params[0];
				$files = Services::get('submissionFile')->getMany(['submissionIds' => [$form->submissionId]]);
				$reqFiles = ['1','2','3'];
				
				foreach ($files as $file) {
					$genreIDs[] += $file->getData('genreId');
				}
				
				$say = count($genreIDs);
				if($say > 1)
				{
					$genreIDs;
				}
				else
				{
					$form->addError('missingFileComponent', 'You are missing a required file component.');
				}

				foreach ($reqFiles as $rFile) {
					if(in_array($rFile,$genreIDs) === false)
				{
					$form->addError('missingFileComponent', 'You are missing a required file component.');
				}

				}

				});
			
		}

		return $success;
	}

	/**
	 * Provide a name for this plugin
	 *
	 * The name will appear in the Plugin Gallery where editors can
	 * install, enable and disable plugins.
	 */
	public function getDisplayName() {
		return 'checkSubmissionFiles';
	}

	/**
	 * Provide a description for this plugin
	 *
	 * The description will appear in the Plugin Gallery where editors can
	 * install, enable and disable plugins.
	 */
	public function getDescription() {
		return 'This plugin controls submissions files by genreID.';
	}
}

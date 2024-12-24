<?php

/**
 * SkinTemplate class for ScratchWikiSkin
 *
 * @file
 * @ingroup Skins
 */

require_once __DIR__ . '/consts.php';

class SkinScratchWikiSkin extends SkinTemplate {
	var $skinname = 'scratchwikiskin2', $stylename = 'ScratchWikiSkin2',
		$template = 'ScratchWikiSkinTemplate', $useHeadElement = true;

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param OutputPage $out
	 */

	public function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( array(
			'mediawiki.skinning.interface', 'skins.scratchwikiskin2'
		) );
		// make Chrome mobile testing work
		$out->addMeta('viewport', 'user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height');
	}
}

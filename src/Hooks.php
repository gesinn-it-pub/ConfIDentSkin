<?php

namespace ConfIDentSkin;

use MediaWiki\Hook\BeforeInitializeHook;
use MediaWiki\Hook\BeforePageDisplayHook;
use MediaWiki\Hook\MediaWikiServicesHook;
use MediaWiki\MediaWikiServices;

class Hooks implements MediaWikiServicesHook, BeforePageDisplayHook {

	private $scssFiles = [
		'extension-PageForms',
		'skin-ContentHeader',
		'skin-enableShowAllFieldsToggle',
	];

	public function __construct( $scssFiles = null ) {
		if ($scssFiles !== null)
			$this->scssFiles = $scssFiles;
	}

	/**
	 * @inheritDoc
	 */
	public function onMediaWikiServices( $services ) {
		$this->setChameleonLayoutFile();
		$this->setChameleonExternalStyleModules();
	}

	private function setChameleonLayoutFile() {
		global $egChameleonLayoutFile;
		$egChameleonLayoutFile = __DIR__ . '/../layouts/standard.xml';
	}

	private function setChameleonExternalStyleModules() {
		global $egChameleonExternalStyleModules;
		$styles =
			array_map( fn( $s ) => __DIR__ . '/../resources/styles/' . $s . '.scss',
				$this->scssFiles );

		$egChameleonExternalStyleModules =
			array_merge( $styles, $egChameleonExternalStyleModules ?? [] );
	}

	/**
	 * @inheritDoc
	 */
	public function onBeforePageDisplay( $out, $skin ): void {
		$out->addModules( 'ext.ConfIDentSkin' );
	}
}

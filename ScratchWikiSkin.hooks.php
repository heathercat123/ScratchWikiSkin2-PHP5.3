<?php

use MediaWiki\Hook\OutputPageBodyAttributesHook;
use MediaWiki\Preferences\Hook\GetPreferencesHook;
use MediaWiki\User\UserOptionsLookup;

require_once __DIR__ . '/consts.php';

class HTMLColorField extends HTMLFormField {

    public function getInputHTML($value) {

        $attribs = array(
            'id' => $this->mID,
            'name' => $this->mName,
            'value' => $value,
            'dir' => $this->mDir,
            'pattern' => '#[0-9A-Fa-f]{6}',
        );

        if ($this->mClass !== '') {
            $attribs['class'] = $this->mClass;
        }

        $allowedParams = array(
            'type',
            'pattern',
            'title',
            'disabled',
            'required',
            'autofocus',
            'readonly',
        );

        $attribs += $this->getAttributes($allowedParams);
        return Html::input($this->mName, $value, 'color', $attribs);
    }

    public function validate($value, $alldata) {
        if (preg_match('%^#[a-fA-F0-9]{6}$%', $value) === 0) {
            return $this->msg('htmlform-invalid-input');
        }
        return parent::validate($value, $alldata);
    }
}

class ScratchWikiSkinHooks {
    private $userOptionsLookup;

    public function __construct(UserOptionsLookup $userOptionsLookup) {
        $this->userOptionsLookup = $userOptionsLookup;
    }

    public static function onOutputPageBodyAttributes($out, $skin, &$bodyAttrs) {
        global $wgUser;
        if ($wgUser->getOption(DARK_THEME_PREF)) {
            $bodyAttrs['class'] .= ' dark-theme';
        }
    }

    public static function onGetPreferences($user, &$preferences) {
		global $wgUser;
        $origpref = $wgUser->getOption(HEADER_COLOR_PREF);
        $preferences[HEADER_COLOR_PREF] = array(
            'type' => 'text',
            'pattern' => '#[0-9A-Fa-f]{6}',
            'label-message' => 'scratchwikiskin-pref-color',
            'section' => 'rendering/skin',
            // Only expose background color preference when the skin is selected
            'default' => ($origpref ? $origpref : '#7953c4'),
            'hide-if' => array('!==', 'wpskin', 'scratchwikiskin2'),
        );
        $preferences[DARK_THEME_PREF] = array(
            'type' => 'check',
            'label-message' => 'scratchwikiskin-pref-dark',
            'section' => 'rendering/skin',
            'hide-if' => array('!==', 'wpskin', 'scratchwikiskin2'),
        );
    }
}

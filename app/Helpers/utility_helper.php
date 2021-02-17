<?php
if(!function_exists('gen_uuid')){
    function gen_uuid(){
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ));
    }
}

if(!function_exists('sanatize_input')){
    function sanatize_input ($val) {
        $stripVal = defined('FILTER_SANITIZE_ADD_SLASHES') ? FILTER_SANITIZE_ADD_SLASHES : FILTER_SANITIZE_MAGIC_QUOTES;
        return strip_slashes(filter_var(filter_var($val, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES), $stripVal));
    }
}


if(!function_exists('load_css')) {
    function load_css( $name = 'css_assets' )
    {
        $session = \Config\Services::session();
        $cssmodules = new App\Libraries\CSS\CSSModules();
        $asset = [];
        foreach ($cssmodules->manifest_json as $key => $value) {

            $asset[$key] =
            "<link type='text/css' rel='stylesheet' href='" . base_url("assets/css/" . $value ) . "'>\n";
        }

        $session->setFlashdata($name, $asset);
    }
}

if(!function_exists('className')) {
    function className($stylesheet = '', $classes = [])
    {
        $cssmodules = new App\Libraries\CSS\CSSModules();
        $styles = $cssmodules->getClasses($stylesheet);
        foreach($classes as $class) {
            $output[] = $styles[$class] ?? $class;
        }
        return 'class="'.implode(' ', $output).'"';
    }
}

if (!function_exists('print_assets')) {
    /**
     * Print Assets
     *
     * This function prints JavaScript/CSS assets.
     *
     * @param array $assets
     *
     * @author Cyro Dubeux
     */
        function print_assets($assets = [])
        {

            if (!empty($assets)) {
                foreach ($assets as $asset) {
                    echo $asset;
                }
            }
        }
    }
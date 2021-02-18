<?php
if(!function_exists('load_css')) {
    function load_css( $name = 'css_assets' )
    {
        $session = \Config\Services::session();
        $asset = [];
        if(ENVIRONMENT === 'production') {
            $cssmodules = new App\Libraries\CSS\CSSModules();
            foreach ($cssmodules->manifest_json as $key => $value) {
                $asset[$key] =
                "<link type='text/css' rel='stylesheet' href='" . base_url("assets/css/" . $value ) . "'>\n";
            }
        } else {
            $asset['styles.css'] = "<link type='text/css' rel='stylesheet' href='" . base_url("assets/css/styles.css") . "'>";
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
if (!function_exists('rsearch')) {
    function rsearch($folder, $pattern) {
        $dir = new RecursiveDirectoryIterator($folder);
        $ite = new RecursiveIteratorIterator($dir);
        $files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
        $fileList = array();
        foreach($files as $file) {
          $fileList[] = $file[0];
        }
        return $fileList;
      }
}
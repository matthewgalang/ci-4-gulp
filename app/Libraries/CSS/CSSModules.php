<?php

/** 
 *
 * Class CSSModules
 */

namespace App\Libraries\CSS;

class CSSModules
{
   private $path;
   private $file_manifest;
   public $manifest_json;

   public function __construct() {
      $this->path = ROOTPATH . 'scss/';
      $this->file_manifest = file_get_contents(ROOTPATH . "/scss/manifest.json");
      $this->manifest_json = json_decode($this->file_manifest, true);
   }
   public function getClasses(string $file): array
   {
      // get styles manifest
      $file_glob = rsearch($this->path,"/^.*".$file."\.css.json$/");
      $json = file_get_contents($file_glob[0]);
      $classes = json_decode($json);

      return (array) $classes;
   }
}

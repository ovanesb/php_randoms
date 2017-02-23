<?php

    class Autoloader {
        
        /**
         * Add directory the must be auto loaded
         * 
         * @var array mix 
         */
        private $dir = array(
            '../app/Controllers/',
            '../app/Models/',
            '../lib/',
            'assets/'
        );
        
        public function __construct() {
            spl_autoload_register(array($this, 'loader'));
        }
        
        private function loader($class) {
            $this->dirFind($class);
        }
        
        /**
         * Check if file exists
         * 
         * @param string $file
         * @return boolean
         */
        private function fileExists($file){
            return ( file_exists($file)? true: false );
        }
        
        /**
         * Loop throughout the directories that must be loaded in Autoload.
         */
        private function dirFind($class){
            foreach ($this->dir as $k => $files){
                $fileToBeLoaded = $files .  str_replace('\\', '/', $class) . ".php";
                if( $this->fileExists($fileToBeLoaded) ){
                    require_once $fileToBeLoaded;
                }
            }
        }
        
        
        
    }
    
    new Autoloader();
    



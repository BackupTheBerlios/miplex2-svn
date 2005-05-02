<?php


    class M2Translator
    {
        
        var $translations = array();
        var $content;
        var $langDir = "lang/";
        
        /**
        * Load Translation from File
        * @param String $langCode The international language Code
        *
        */
        function M2Translator($langCode = null)
        {
            if ($langCode != null)
            {
                $this->loadTranslationFile($this->langDir."$langCode.lang.php");
                $this->processLanguage();
            }    
             
        }
        
        /**
        * Load Translation File
        *
        */
        function loadTranslationFile($path)
        {
            if (is_readable($path))
            {
                $content = file_get_contents($path);
                $this->content = $content;
                
            } else 
                return false;
        }
        
        /**
        * Process the content of the language file to retreive the correct
        * translations
        *
        */
        function processLanguage()
        {
            $entries = explode("\n", $this->content);
            
            foreach ($entries as $line) {
            	
                //Right part is translation, left part is section category
                $vals = explode("=", $line);
                //Ignore comments
                $tmp = trim($line);
                if ($tmp{0} != "#" && !empty($line))
                    $this->translations[trim($vals[0])] = trim($vals[1]);
            }
            
        }
        
        /**
        * Translate requestet element
        * @param String $element element to be translated
        */
        function translate($element)
        {
            if (!key_exists($element, $this->translations))
            {
                return "*".$element."*";
            } else 
                return $this->translations[$element];
        }
        
        /**
        * Translate requestet element. Dummy function for this->translate
        * @param String $element element to be translated
        */
        function get($element)
        {
            return $this->translate($element);
        }
        
        
        /**
        * This method is meant to make getting the right element easier.
        * Therefore you give the beginning of the disrired path and now you
        * will get a new M2Translator Object only with desired elements.
        */
        function getSection($path)
        {
            
            //Find all Elements that start with $path
            foreach ($this->translations as $key => $val) {
                //echo $key;
                $tmp = strpos($key, $path);
                if (is_int($tmp) && $tmp == 0)
                {
                    $tmpArr = explode(".",$key);
                    
                    $tmpArr = array_reverse($tmpArr);
                    $cnt = substr_count($path, ".");
                    for ($i=0; $i <=$cnt; $i++)
                    {
                        array_pop($tmpArr);
                    }
                    $tmpArr = array_reverse($tmpArr);
                    $string = join(".", $tmpArr);
                    
                    $return[$string] = $val;
                    
                }
            }
            
            $section = new M2Translator;
            $section->translations = $return;
            
            return $section;
        }
        
        
    }


?>
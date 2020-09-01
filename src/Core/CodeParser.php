<?php

namespace KKomelin\TranslatableStringExporter\Core;

class StringExtractor
{
    private $finder;
    private $parser;
    public $log = "";

    public function __construct()
    {
        $this->finder = new FileFinder();
        $this->parser = new CodeParser();
    }

    /**
     * Extract translatable strings from the project files.
     */
    public function extract() {

        $strings = [];

        $files = $this->finder->find();
        foreach ($files as $file) {
            $tmp = $this->parser->parse($file);
            $strings = array_merge($strings, $tmp);
            if(!empty($tmp)){
                foreach ($tmp as $val) {
                    $this->log .= "[{$val}]\n".$file->getRelativePath()."\n";
                }
            }
        }

        return $this->formatArray($strings);
    }

    /**
     * Convert an array of extracted strings to an associative array where each string becomes key and value.
     *
     * @param array $strings
     * @return array
     */
    protected function formatArray(array $strings) {

        $result = [];

        foreach ($strings as $string) {
            $result[$string] = $string;
        }

        return $result;
    }
}

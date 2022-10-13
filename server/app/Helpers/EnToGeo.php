<?php
    namespace App\Helpers;
    
    class CharTranslator {
        private $english;
        private $georgian;

        public function __construct() {
            $this->english = [
                'a', 'b', 'g', 'd', 'e', 'v', 'z', 't', 'i', 'k', 'l', 'm', 'n', 'o', 'p',
                'zh', 'r', 's', 't', 'u', 'f', 'q', 'gh', 'y', 'sh', 'ch', 'c', 'dz', 'w',
                'W', 'x', 'j', 'h'
            ];

            $this->georgian = [
                'ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'ლ', 'მ', 'ნ', 'ო', 'პ',
                'ჟ', 'რ', 'ს', 'ტ', 'უ', 'ფ', 'ქ', 'ღ', 'ყ', 'შ', 'ჩ', 'ც', 'ძ', 'წ',
                'ჭ', 'ხ', 'ჯ', 'ჰ'
            ];
        }

        public function english_to_georgian($target_string) {
            return @str_replace($this->english, $this->georgian, $target_string);
        }
    }
?>
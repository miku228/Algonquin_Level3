<?php
    class Program{
        private $programCode;
        private $programTitle;
        private $programDescription;
        
        private $messages;

        
        public function __construct($programCode, $programTitle, $programDescription)
        {
            $this->programCode = $programCode;
            $this->programTitle = $programTitle;
            $this->programDescription = $programDescription;

            $this->messages = array();
        }

        public function getProgramCode() {
            return $this->programCode;
        }

        public function getProgramTitle() {
            return $this->programTitle;
        }

        public function getProgramDiscription() {
            return $this->programDescription;
        }
        
    }
    
    
    class Course{
        private $code;
        private $title;
        private $description;
        private $hoursPerWeek;
        private $programCode;

        private $messages;

        public function __construct($code, $title, $description, $hoursPerWeek, $programCode)
        {
            $this->code = $code;
            $this->title = $title;
            $this->description = $description;
            $this->hoursPerWeek = $hoursPerWeek;
            $this->programCode = $programCode;

            $this->messages = array();
        }

        public function getCode() {
            return $this->code;
        }

        public function getTitle() {
            return $this->title;
        }

        public function getDescription() {
            return $this->description;
        }
        
        public function getHoursPerWeek() {
            return $this->hoursPerWeek;
        }
        
        public function getProgramCode() {
            return $this->programCode;
        }
        
    }
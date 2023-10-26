<?php
    class Student{
        private $studentId;
        private $name;
        private $phone;
        // private $password;

        private $messages;

        public function __construct($studentId, $name, $phone)
        {
            $this->studentId = $studentId;
            $this->name = $name;
            $this->phone = $phone;
            // $this->password = $password;

            $this->messages = array();
        }

        public function getStudentId() {
            return $this->studentId;
        }

        public function getName() {
            return $this->name;
        }

        public function getPhone() {
            return $this->phone;
        }
        
        /*
        public function getPassword() {
            return $this->password;
        }
         */
    }

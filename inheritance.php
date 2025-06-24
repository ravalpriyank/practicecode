<?php 
    class employee{
        public $name = "Priyank Raval", $age = 19;
    }

    class salary extends employee{
        public $department = "Backend",$salary = 4000,$new_age;

        public function __construct(){
            $this->new_age = $this->age + 10;
        }
        public function display(){
            echo "<h3>Employee Information</h3>";
            echo $this->name."<br>";
            echo $this->department."<br>";
            echo $this->new_age."<br>";
            echo $this->salary."<br>";
        }
    }

    $s1 = new salary();
    $s1->display();
?>
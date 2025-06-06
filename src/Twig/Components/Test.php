<?php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent ('Test')]
final class Test
{
    public function petlafor(): string
    {
        $output = "";
        for ($i = 0; $i < 10; $i++) {
            $output .= 2 * $i . '</br>';
        }
        return $output;
    }
    public function petlafor01(): string
    {
        $output = '';
        for ($i = 0, $k=5; $i < 10; $i++,$k+=3) {
            $output .= $k . '</br>';
        }
        return $output;
    }
    public function petlafor2(): string
    {
        $output = '';
        for ($i = 0; $i < 10; $i++) {
            $output .=  $i . '</br>';
            if ($i == 5) break;
        }
        return $output;
    }
    public function petlafor3(): string
    {
        $output = '';
        $i = 0;
        while ($i <10) {
            $output .=  $i . "/";
           $i++;
        }
        return $output;
    }
    public function petlafor4(): string
    {
        $output = '';
        $i = 1;
        while(1) {
            $output .= $i." | " ;
            if($i == 25) break;
            $i++;
        } 
        return $output;
    }
    public function warunek(): void
    {
        $pracownicy = array(
            "szef" => "Nowak",
            "sekretariat" => "Kowalski",
            "biuro" => "Barański" 
            );
            echo $pracownicy["szef"]."<br>";
            foreach ($pracownicy as $sta => $naz) {
              echo "$sta  to  $naz<br>";
            }
    }

    // public ?string $result = null;

    // public function checkNumber(int $number): string
    // {
    //     return ($number % 2 == 0) 
    //         ? "Liczba $number jest parzysta." 
    //         : "Liczba $number jest nieparzysta.";
    // }

    public function test5(): void
    {
        $tablica = array(
            "szef" =>"Grzegorz",
            "pacholek" =>"Jacek"
           
        );
       echo $tablica["szef"]."<br>";
        
    }
    public function test6(): void
    {
        
      $tablica2D = array();
for($i = 0; $i < 5; $i++) {
    for($j = 0; $j < 5; $j++) {
        $tablica2D[$i][$j] = $i + $j;
    }
}
for($i = 0; $i < 5; $i++) {
    for($j = 0; $j < 5; $j++) {
        echo $tablica2D[$i][$j] . " ";
    }
    echo "<br>";
}
    }

public function test7(): void
    {

        $tablica = array(
            "szef" =>"Grzegor",
            "pacholek" =>"Jacek"
           
        );
        if($tablica["szef"] == "Grzegorz") {
        echo "szef to Grzegorz";
      } else {
        echo "szef to nie Grzegorz"."</br>";
      } 
     echo 'Dzisiaj mamy: '.date('d.m.Y').'<br/>';
    
   $czas = time();
   echo "Aktualny czas w sekundach: $czas sek.";
   echo (float) 10;
    }
    public function test8(): void
    {
        $tablica = array(
            0 => 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,
            26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,);
           echo 'losowanie liczby '. $tablica[rand(0, 45)] .'<br/>';
        
    }
       
}


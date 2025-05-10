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
}
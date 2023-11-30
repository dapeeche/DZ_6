<?php
//code for pull requests
class Logger
{

    private $format;
    private $delivery;

    public function __construct(ToFormat $format, ToDeliver $delivery)
    {
        $this->format   = $format;
        $this->delivery = $delivery;
    }

    public function log($string)
    {
        $formatString = $this->format->format($string);
        $this->delivery->deliver($formatString);
    }
}

interface ToFormat{
    public function format($string);
}

class RawFormat implements ToFormat{
    public function format($string)
    {
        return $string;
    }
}

class WithDateFormat implements ToFormat{
    public function format($string)
    {
        return date('Y-m-d H:i:s') . $string;
    }
}

class WithDateAndDetails implements ToFormat{
    public function format($string)
    {
        return date('Y-m-d H:i:s') . $string . ' - With some details';
    }
}

interface ToDeliver {
    public function deliver($format);
}

class SmsDeliver implements ToDeliver{
    public function deliver($format)
    {
        echo "Вывод формата ({$format}) в смс";
    }
}

class EmailDeliver implements ToDeliver{
    public function deliver($format)
    {
        echo "Вывод формата ({$format}) по имейл";
    }
}

class ConsoleDeliver implements ToDeliver{
    public function deliver($format)
    {
        echo "Вывод формата ({$format}) в консоль";
    }
}

$someLog = new Logger(new WithDateFormat(), new ConsoleDeliver());
$someLog->log(' Some log ');

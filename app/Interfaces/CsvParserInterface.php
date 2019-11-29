<?php

namespace App\Interfaces;


interface CsvParserInterface {
    public function parse(): void;
    public function saveToDatabase(): void;
}
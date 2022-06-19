<?php

use PHPUnit\Framework\TestCase;
use App\Entity\Book;
use Symfony\Component\Process\Exception\InvalidArgumentException;

class BookTest extends TestCase{

    private $book;

    public function setUp(): void{

        $this->book = new Book();

    }

    public function testStockAdditionWithObjAndValue_OK(){

        $receivedStockQuantity = 4;

        $newBook = new Book();

        $newBook->setStock(5);

        $this->assertEquals(9,$this->book->addStock($newBook,$receivedStockQuantity));

    }

    public function testStockAdditionWithObjAndValue_KO(){

        $receivedStockQuantity = 4;

        $newBook = new Book();

        $newBook->setStock(5);

        $this->assertEquals(9,$this->book->addStock($newBook,$receivedStockQuantity));

    }

    public function testStockAdditionWithObjAndValue_InvalidObject(){

        $receivedStockQuantity = null;

        $newBook = new Book();

        $newBook->setStock(5);

        $this->expectException(Symfony\Component\Process\Exception\InvalidArgumentException::class);

        $this->book->addStock($newBook,$receivedStockQuantity);

    }

}

?>
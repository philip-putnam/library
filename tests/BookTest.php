<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    require_once 'src/Book.php';


    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $title = 'A Game of Thrones';
            $id = 32;
            $new_book = new Book($title, $id);

            //Act
            $result = $new_book->getId();

            //Assert
            $this->assertEquals(32, $result);

        }

        function test_getTitle()
        {
            //Arrange
            $title = 'A Game of Thrones';
            $new_book = new Book($title);

            //Act
            $result = $new_book->getTitle();

            //Assert
            $this->assertEquals('A Game of Thrones', $result);
        }

        function test_setTitle()
        {
            //Arrange
            $title = 'A Game of Thrones';
            $new_title = 'AGoT';
            $new_book = new Book($title);

            //Act
            $new_book->setTitle($new_title);
            $result = $new_book->getTitle();

            //Assert
            $this->assertEquals('AGoT', $result);
        }

        function test_save()
        {
            //Arrange
            $title = 'A Game of Thrones';
            $new_book = new Book($title);
            $new_book->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$new_book], $result);
        }

        function test_getAll()
        {
            //Arrange
            $title = 'A Game of Thrones';
            $new_book = new Book($title);
            $new_book->save();

            $title2 = 'A Feast of Crows';
            $new_book2 = new Book($title2);
            $new_book2->save();

            $title3 = 'The Name of the Wind';
            $new_book3 = new Book($title3);
            $new_book3->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$new_book, $new_book2, $new_book3], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $title = 'A Game of Thrones';
            $new_book = new Book($title);
            $new_book->save();

            $title2 = 'A Feast of Crows';
            $new_book2 = new Book($title2);
            $new_book2->save();

            $title3 = 'The Name of the Wind';
            $new_book3 = new Book($title3);
            $new_book3->save();

            //Act
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $title = 'A Game of Thrones';
            $new_book = new Book($title);
            $new_book->save();

            $title2 = 'A Feast of Crows';
            $new_book2 = new Book($title2);
            $new_book2->save();

            $title3 = 'The Name of the Wind';
            $new_book3 = new Book($title3);
            $new_book3->save();

            //Act
            $result = Book::find($new_book2->getId());

            //Assert
            $this->assertEquals($new_book2, $result);
        }
        function test_delete()
        {
            //Arrange
            $title = 'A Game of Thrones';
            $new_book = new Book($title);
            $new_book->save();

            $title2 = 'A Feast of Crows';
            $new_book2 = new Book($title2);
            $new_book2->save();

            $title3 = 'The Name of the Wind';
            $new_book3 = new Book($title3);
            $new_book3->save();

            //Act
            $new_book2->delete();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$new_book, $new_book3], $result);
        }
    }
?>

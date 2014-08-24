<?php

use src\DirectoryManager;

class DirectoryManagerTest extends \Codeception\TestCase\Test
{
   /**
    * @var \UnitTester
    */
    protected $tester;
    
    protected $directoryManager;
    
    protected $dir      = 'normalTest/testDirectory';
    
    protected $newDir   = 'newTest/testNewDirectory';
    
    protected $file     = '/testFile.ini';    

    protected function _before()
    {
        $this->directoryManager = new DirectoryManager();
        
        $this->directoryManager->setDirectoryIterator($this->dir);
    }

    protected function _after()
    {
    }

    public function testIfFolderHasBeenCreated()
    {
        $this->assertTrue(is_dir($this->dir));
    }    
    
    public function testCreateFile()
    {
        $file   = $this->dir . $this->file;
        $datas  = 'Hello';
        
        $handle = fopen($file, 'w+');
        if (fwrite($handle, $datas)) {
            fclose($handle);
        }        
        
        $this->assertTrue(file_exists($file));
    }
    
    public function testMoveFileToNewDirectory()
    {
        $this->directoryManager->move($this->newDir);
        
        $newFile = $this->newDir . $this->file;
        $this->assertTrue(file_exists($newFile));
    }
    
    
    public function testDeleteDirectoriesAndContent()
    {
        $this->directoryManager->delete();
        
        $this->assertFalse(is_readable($this->dir));
    }   
}
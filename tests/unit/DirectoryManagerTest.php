<?php

use src\DirectoryManager;

class DirectoryManagerTest extends \Codeception\TestCase\Test
{
   /**
    * @var \UnitTester
    */
    protected $tester;
    
    protected $directoryManager;
    
    protected $dir          = 'normalTest/testDirectory/';
    
    protected $newDir       = 'newTest/testNewDirectory/';
    
    protected $file         = 'testFile.ini';
    
    protected $secondFile   = 'testFile2.ini';
    
    protected $thirdFile    = 'testFile3.ini';     

    protected function _before()
    {
        $this->directoryManager = new DirectoryManager();
        
        $this->directoryManager->setDirectoryIterator($this->dir);
    }

    protected function _after()
    {       
    }

    /**
     * We test if main directory specified has been created
     */
    public function testIfFolderHasBeenCreated()
    {
        return $this->assertTrue(is_dir($this->dir));
    }    
    
    /**
     * We create three false files into this doirectory
     */    
    public function testFilesHaveBeenCreated()
    {
        $files   = array(
            $this->dir.$this->file, 
            $this->dir.$this->secondFile,
            $this->dir.$this->thirdFile,            
        );
        $datas  = 'Hello';
        
        foreach ($files as $file) {
            $handle = fopen($file, 'w+');
            if (fwrite($handle, $datas)) {
                fclose($handle);
            }            
        }        
        
        return $this->assertTrue(file_exists($this->dir.$this->thirdFile));
    }
    
    public function testBrowseContent()
    {
        $content = $this->directoryManager->getContent();
    
        return $this->assertArrayHasKey('testFile2.ini', $content);
        
    }
    
    /**
     * We ccpy the first file into another directory
     * The two other files are not copied yet
     */     
    public function testMoveFirstFileToNewDirectory()
    {
        $move = $this->directoryManager->move($this->newDir, $this->file);
        
        return $this->assertTrue($move);         
    }

    public function testIfFirstFileHasBeenMoved()
    {
        $file = $this->newDir . $this->file;
        return $this->assertFileExists($file);   
    }    
    
    public function testIfSecondFileHasNotBeenMoved()
    {
        $secondFile = $this->newDir . $this->secondFile;
        return $this->assertFileNotExists($secondFile);   
    }
    
    public function testIfThirdFileHasNotBeenMoved()
    {
        $thirdFile  = $this->newDir . $this->thirdFile;
        return $this->assertFileNotExists($thirdFile);   
    }    
    
    /**
     * We copy all files to new directory
     * We test all files are copied
     */
    public function testMoveAllFilesToNewDirectory()
    {
        $this->directoryManager->move($this->newDir);

        $secondFile = $this->newDir . $this->secondFile;               
        
        return $this->assertFileExists($secondFile);      
    }   
    
    public function testIfThirdFileHasBeenMoved()
    {
        $thirdFile  = $this->newDir . $this->thirdFile;
        return $this->assertFileExists($thirdFile);   
    }     
    
    /**
     * Just delete one file in directory
     */
    public function testDeleteOneFileInDirectory()
    {
        $this->directoryManager->delete($this->file);
        
        return $this->assertFileNotExists($this->dir . $this->file);
    } 
    
    /**
     * Just delete one file in directory
     */
    public function testIfDeletedFIleHasBeenRemovedFromFileNamesProperty()
    {
        $fileNames = $this->directoryManager->fileNames;
        
        return $this->assertArrayNotHasKey($this->file, $fileNames);
        
    }     
    
    /**
     * Now delete everyting in this directory
     */
    public function testDeleteDirectoriesAndContent()
    {
        $this->directoryManager->delete();
        
        $this->assertFalse(is_readable($this->dir));
        
        $this->cleanAll();
    }
    
    private function cleanAll()
    {
        $this->directoryManager = null;
        
        @rmdir($this->dir);
        @rmdir('normalTest'); 
        
        unlink($this->newDir . $this->file);
        unlink($this->newDir . $this->secondFile);
        unlink($this->newDir . $this->thirdFile);
        @rmdir($this->newDir);
        @rmdir('newTest');       
    }
    
}
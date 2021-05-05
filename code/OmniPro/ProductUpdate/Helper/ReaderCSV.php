<?php
namespace OmniPro\ProductUpdate\Helper;

use Directory; 
use Magento\Framework\File\Csv;
use Magento\Framework\Filesystem\Driver\File;
use \Magento\Framework\Filesystem;
use Magento\Framework\Exception\FileSystemException;
use OmniPro\ProductUpdate\Logger\Logger;

class ReaderCSV
{
    const PATH_FILE = 'update/data.csv';
    const DELIMITER = '|';

    /**
     * @param \Magento\Framework\Filesystem
     */
    private $filesystem;

    /**
     * @param \Magento\Framework\Filesystem\Driver\File
     */
    private $file;

    /**
     * @param \Magento\Framework\File\Csv
     */
    private $csv;

    //  /** TODO
    //  * @param \Magento\Framework\File\Csv
    //  */
    private $entityTemplateFactory;



    /**
     * @param OmniPro\ProductUpdate\Logger\Logger;
     */
    private $logger;
 
    public function __construct(
        Filesystem $filesystem,
        File $file,      
        Csv $csv,
        Logger $logger
    )
    {
        $this->filesystem = $filesystem;
        $this->csv = $csv;
        $this->file = $file;
        $this->logger = $logger;
    }
    public function readCsv()
    {
       $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
       $pathFile = $mediaDirectory->getAbsolutePath('update/data.csv');
       if($this->file->isExists($pathFile)) {
           $this->csv->setDelimiter(self::DELIMITER);
           $data = $this->csv->getData($pathFile);
           if(!empty($data)){
               $header = array_slice($data, 0, 1)[0];
               foreach (array_slice($data,1) as $key => $value) { 
                  $this->logger->debug('DATA ' . implode(';',$value));   
               }
           }
       }
    }
}
    
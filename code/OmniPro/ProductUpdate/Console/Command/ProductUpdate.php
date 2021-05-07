<?php
namespace OmniPro\ProductUpdate\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use OmniPro\ProductUpdate\Logger\Logger;
use OmniPro\ProductUpdate\Model\UpdateProduct;


class ProductUpdate extends Command
{
     /**
     *
     * @var  OmniPro\ProductUpdate\Model\UpdateProduct;
     */
    private $_productUpdate;

    public function __construct(
        \OmniPro\ProductUpdate\Model\UpdateProduct $productUpdate
        )
    {
        $this->_productUpdate =  $productUpdate;
        parent::__construct();
    }
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('omnipro:productupdate');
        $this->setDescription('update product from csv');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {    
        try {
            $this->_productUpdate->updateProductCsv();
            $output->writeln('<info>Success Message.</info>');
        } catch (\Exception $e) {
            $output->writeln('<error>An error to create product: '.$e.' </error>');
        }
        
    }
}
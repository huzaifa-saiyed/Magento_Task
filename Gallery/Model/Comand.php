<?php

namespace Kitchen\Gallery\Model;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use Kitchen\Gallery\Model\GalleryFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Comand extends Command
{
    protected $_galleryFactory;
    protected $_scopeConfig;

    public function __construct(
        GalleryFactory $_galleryFactory,
        ScopeConfigInterface $_scopeConfig
    ) {
        $this->_galleryFactory = $_galleryFactory;
        $this->_scopeConfig = $_scopeConfig;
        parent::__construct();
    }


    protected function configure()
    {
        $this->setName('kitchen:cleans')
        ->setDescription('Kitchen Gallery Cleans Commands!');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $isEnable = $this->_scopeConfig->getValue(
            'info/general/isEnable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if($isEnable) {
            try {

                $varCustomer = $this->_galleryFactory->create();
                $varCollection = $varCustomer->getCollection();

                foreach ($varCollection as $row) {
                    $output->writeln('Gallery ID is: ' . $row->getId())."<br>";
                    $row->delete();
                }
                $output->writeln('Data cleaned successfully.');
            } catch (\Throwable $e) {
                $output->writeln('Error occurred: ' . $e->getMessage());
                return 1;
            }
        } else {
            $output->writeln('Command execution skipped as configuration is disabled.');
        }
        return 0;
    }
}
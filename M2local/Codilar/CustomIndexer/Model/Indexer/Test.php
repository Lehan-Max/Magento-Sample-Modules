<?php
namespace Codilar\CustomIndexer\Model\Indexer;

class Test implements \Magento\Framework\Indexer\ActionInterface, \Magento\Framework\Mview\ActionInterface
{
    public function execute($ids)
    {

        //code here!
    }


    public function executeFull()
    {
        echo "Hello World!!";
    }


    public function executeList(array $ids)
    {
        //code here!
    }

    public function executeRow($id)
    {
        //code here!
    }
}

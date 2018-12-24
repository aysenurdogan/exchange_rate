<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use App\Entity\Company;

class ExchangeRateCommand extends Command
{
    protected static $defaultName = 'app:exchange-rate';

    private $entityManager;
    /**
     * {@inheritdoc}
     */

    protected function configure()
    {
        $this
            ->setDescription('Döviz bilgilerini karşılaştırmak istediğiniz firmalara ait bilgileri giriniz. ')
            ->addArgument('company', InputArgument::OPTIONAL, 'Firma Adı')
            ->addArgument('api', InputArgument::OPTIONAL, 'Api Bilgisi')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
       // $this->entityManager = $this->getContainer()->get('doctrine')->getManager();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $companyname = $input->getArgument('company');
        $apiinformation = $input->getArgument('api');

        $data = file_get_contents($apiinformation);
        $json_data = json_decode($data,true);

        $company = new Company();
        $company->setTitle($companyname);
        $company->setBody($apiinformation);

        if(isset($json_data['result'])){
            foreach ($json_data as $item){
                $company->setUsd($item[0]["symbol"]);
                $company->setEuro($item[1]["symbol"]);
                $company->setStr($item[2]["symbol"]);
            }
        }
        else {
            foreach ($json_data as $item){
                if($item["kod"] =="DOLAR" ){
                    $company->setUsd($item["kod"]);
                }elseif ($item["kod"] =="AVRO"){
                    $company->setEuro($item["kod"]);
                } else {
                    $company->setStr($item["kod"]);
                }
            }
        }

        $this->entityManager->persist($company);
        $this->entityManager->flush();

        $output->writeln('Kayıt işlemi başarı ile tamamlandı.');
    }
}

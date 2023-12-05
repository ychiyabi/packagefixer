<?php
namespace App\Service;

use App\Entity\Package;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService{

    protected $params;
    protected $client;
    protected $logger;
    protected $db_handler;

    public function __construct(ParameterBagInterface $params,HttpClientInterface $client,LoggerInterface $logger,EntityManagerInterface $em)
    {
        $this->params=$params;
        $this->client=$client;
        $this->logger=$logger;
        $this->db_handler=$em;
    }

    public function fetchApi($page_number){
        $response = $this->client->request(
            'GET',
            $this->params->get('apiUrl').'?page='.$page_number.'&per_page=100'
        );
        
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $packages=null;

        if(json_validate($content) && $statusCode==200){$packages=json_decode($content);}
        else{$this->logger->error("The json is invalid");return;}
        
        foreach($packages->packages as $pkg){
            $local_package=new Package();
            $local_package->setUrl($pkg->url);
            $local_package->setName($pkg->name);
            $local_package->setDescription($pkg->description);
            $this->db_handler->persist($local_package);
            $this->db_handler->flush();
        }
        
        

    }
}
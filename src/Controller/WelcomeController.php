<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Company;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class WelcomeController extends Controller
{
    /**
     * @Route("/welcome", name="welcome")
     *  @Method ({"GET"})
     */
    public function index()
    {


        $em = $this->getDoctrine()->getManager();

        $USD_QUERY = 'SELECT * FROM `company` WHERE usd=(SELECT MIN(usd) from company)';
        $statement_usd = $em->getConnection()->prepare($USD_QUERY);
        $statement_usd->execute();
        $result_usd = $statement_usd->fetchAll();

        $STR_QUERY = 'SELECT * FROM `company` WHERE str=(SELECT MIN(str) from company)';
        $statement_str = $em->getConnection()->prepare($STR_QUERY);
        $statement_str->execute();
        $result_str = $statement_str->fetchAll();

        $EURO_QUERY = 'SELECT * FROM `company` WHERE euro=(SELECT MIN(euro) from company)';
        $statement_euro = $em->getConnection()->prepare($EURO_QUERY);
        $statement_euro->execute();
        $result_euro = $statement_euro->fetchAll();


        return $this->render('welcome/index.html.twig',

            array (
                'usd'=> $result_usd[0]["usd"],'usd_firma'=> $result_usd[0]["title"],
                'str'=> $result_str[0]["str"],'str_firma'=> $result_str[0]["title"],
                'euro'=> $result_euro[0]["euro"],'euro_firma'=> $result_euro[0]["title"]
            ));
    }
}

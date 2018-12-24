<?php

namespace App\Controller;

use App\Entity\Company;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Twig\Node\Expression\Unary\NegUnary;


class CompanyController extends Controller {
    /**
     * @Route("/company", name="company_list")
     * @Method ({"GET"})
     */


    public function company(){

        $companies = $this->getDoctrine()->getRepository(Company::class)->findAll();



        $data = file_get_contents('http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0');
        $json_data = json_decode($data,true);

        if(isset($json_data['result'])){

            foreach ($json_data as $item){
                print_r($item[0]["symbol"]);
                print_r($item[1]["symbol"]);
                print_r($item[2]["symbol"]);
            }
        }
        else {
            foreach ($json_data as $item){
                if($item["kod"] =="DOLAR" ){

                }elseif ($item["kod"] =="AVRO"){

                } else {

                }

            }
        }


        return $this->render('company/index.html.twig', array
        ('companies' => $companies));
    }

    /**
     * @Route ("/company/new", name="new_company")
     * Method ({"GET", "POST"})
     */
    public function new(Request $request){
        $company = new Company();

        $form = $this->createFormBuilder($company)
            ->add('title', TextType::class, array('attr' =>array('class' => 'form-control')))
            ->add('str', TextType::class, array('attr' =>array('class' => 'form-control')))
            ->add('euro', TextType::class, array('attr' =>array('class' => 'form-control')))
            ->add('usd', TextType::class, array('attr' =>array('class' => 'form-control')))
            ->add('body', TextareaType::class, array('required' =>false, 'attr' =>array('class' =>'form-control')))
            ->add('save', SubmitType::class, array(
                'label' =>'Create',
                'attr' =>array('class'=>'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $company = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('company_list');
        }

        return $this->render('company/new.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route ("/company/{id}", name= "company_show")
     * @Method ({"GET"})
     */
    public function show($id){
        $company = $this->getDoctrine()->getRepository(Company::class)->find($id);

        return $this->render('company/show.html.twig', array('company' =>$company));

    }

    /**
     * @Route ("/company/update/{id}", name="list_company")
     * Method ({"GET", "POST"})
     */
    public function update(Request $request, $id){

        $company = $this->getDoctrine()->getRepository(Company::class)->find($id);

        $form = $this->createFormBuilder($company)
            ->add('title', TextType::class, array('attr' =>array('class' => 'form-control')))
            ->add('str', TextType::class, array('attr' =>array('class' => 'form-control')))
            ->add('euro', TextType::class, array('attr' =>array('class' => 'form-control')))
            ->add('usd', TextType::class, array('attr' =>array('class' => 'form-control')))
            ->add('body', TextareaType::class, array('required' =>false,
                'attr' =>array('class' =>'form-control')))
            ->add('save', SubmitType::class, array(
                'label' =>'Update',
                'attr' =>array('class'=>'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('company_list');
        }

        return $this->render('company/update.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route ("/company/delete/{id}")
     * @Method ({"DELETE"})
     */
    public function delete(Request $request, $id){
        $company = $this->getDoctrine()->getRepository(Company::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($company);
        $entityManager->flush();

        return $this->redirectToRoute('company_list');
    }


}
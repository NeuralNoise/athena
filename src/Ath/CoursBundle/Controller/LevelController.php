<?php
namespace Ath\CoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Ath\CoursBundle\Form\Type\LevelFormType;
use Ath\CoursBundle\Form\Type\DisciplineFormType;

use Ath\CoursBundle\Entity\Level;
use Ath\CoursBundle\Entity\Discipline;

class LevelController extends Controller
{
  // permet d'afficher la liste des niveaux, ainsi que d'en rajouter
  public function levelsAction(Request $request)
  {
      $em = $this->getDoctrine()->getManager();

      $level = new Level();
      $formLevel = $this->createForm(new LevelFormType(), $level);

      $discipline = new Discipline();

      $formDiscipline = $this->createForm(new DisciplineFormType(), $discipline);

      $disciplines = $em->getRepository('AthCoursBundle:Discipline')->findAll();

      if ($request->getMethod() == 'POST') {
        $formLevel->bind($request);
        if ($formLevel->isValid()) {
          $em->persist($level);
          $em->flush();

          $this->get('session')->getFlashBag()->add(
              'notice',
              'Le niveau a été sauvegardé !'
          );
        }
      }

      $levels = $em->getRepository('AthCoursBundle:Level')->findAll();
      return $this->render('AthCoursBundle:Level:level.html.twig', array('levels' => $levels,
                                                                          'disciplines' => $disciplines,
                                                                         'formLevel' => $formLevel->createView(),
                                                                         'formDiscipline' => $formDiscipline->createView()
                                                                         ));
  }

  public function deleteAction(Level $level)
  {
    try{
      $em = $this->getDoctrine()->getManager();
      $em->remove($level);
      $em->flush();
      $this->get('session')->getFlashBag()->add(
              'notice',
              'Le niveau a été supprimé !'
          );
    } catch (\Exception $e) {
       $this->get('session')->getFlashBag()->add(
              'notice',
              "Le niveau n'a pu être supprimé !\nVérifiez qu'il ne possède pas de classes."
          );
    }
    return $this->redirect($this->generateUrl('ath_level_add'));
  }

  public function editAction(Level $level)
  {
      $em = $this->getDoctrine()->getManager();
      $form = $this->createForm(new LevelFormType(), $level);

      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
        $form->bind($request);
        if ($form->isValid()) {
          $em->persist($level);
          $em->flush();

          $this->get('session')->getFlashBag()->add(
              'notice',
              'Le niveau a été mis à jour !'
          );
        }
      }

      return $this->render('AthCoursBundle:Level:edit.html.twig', array('level' => $level,
                                                                        'form' => $form->createView(),
                                                                        )
      );
  }
}

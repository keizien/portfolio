<?php

namespace App\Controller;

use App\Entity\Fichier;
use App\Form\FichierType;
use App\Repository\FichierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


final class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('base/contact.html.twig', [
        ]);
    }

    #[Route('/projets', name: 'app_projets')]
    public function projet(): Response
    {
        return $this->render('base/projets/projets.html.twig', [
        ]);
    }

    #[Route('/stages', name: 'app_stages')]
    public function stages(): Response
    {
        return $this->render('base/stages/stages.html.twig', [
        ]);
    }

    #[Route('/competences', name: 'app_competences')]
    public function competences(): Response
    {
        return $this->render('base/competences.html.twig', [
        ]);
    }

    #[Route('/veille', name: 'app_veille')]
    public function veille(): Response
    {
        return $this->render('base/veille.html.twig', [
        ]);
    }

    #[Route('/certifications', name: 'app_certifications')]
    public function certifications(): Response
    {
        return $this->render('base/certifications/certifications.html.twig', [
        ]);
    }

    #[Route('/fichiers', name: 'app_fichiers')]
    public function fichiers(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class, $fichier);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form->get('fichier')->getData();
                if ($file) {
                    $nomFichierServeur = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $nomFichierServeur = $slugger->slug($nomFichierServeur);
                    $nomFichierServeur = $nomFichierServeur . '-' . uniqid() . '.' . $file->guessExtension();
                    try {
                        $fichier->setNomServeur($nomFichierServeur);
                        $fichier->setNomOriginal($file->getClientOriginalName());
                        $fichier->setDateEnvoi(new \Datetime());
                        $fichier->setExtension($file->guessExtension());
                        $fichier->setTaille($file->getSize());
                        $em->persist($fichier);
                        $em->flush();
                        $file->move($this->getParameter('file_directory'), $nomFichierServeur);
                        $this->addFlash('notice', 'Fichier envoyé');
                        return $this->redirectToRoute('app_fichiers');
                    } catch (FileException $e) {
                        $this->addFlash('notice', 'Erreur d\'envoi');
                    }
                }
            }
        }
        return $this->render('base/fichiers.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/liste-fichiers', name: 'app_liste_fichiers')]
    public function liste_fichiers(FichierRepository $fichierRepository): Response
    {
        $fichiers = $fichierRepository->findAll();
        return $this->render('base/liste-fichiers.html.twig', [
            'fichiers' => $fichiers,
        ]);
    }

    #[Route('/stage1', name: 'app_stage1')]
    public function stage1(): Response
    {
        return $this->render('base/stages/stage1.html.twig', [
        ]);
    }

    #[Route('/stage2', name: 'app_stage2')]
    public function stage2(): Response
    {
        return $this->render('base/stages/stage2.html.twig', [
        ]);
    }

    #[Route('/solution_web', name: 'app_solution_web')]
    public function solution_web(): Response
    {
        return $this->render('base/projets/solution_web.html.twig', [
        ]);
    }

    #[Route('/neptune', name: 'app_neptune')]
    public function neptune(): Response
    {
        return $this->render('base/projets/neptune.html.twig', [
        ]);
    }

    #[Route('/arcachon', name: 'app_arcachon')]
    public function arcachon(): Response
    {
        return $this->render('base/projets/arcachon.html.twig', [
        ]);
    }

    #[Route('/apProjet', name: 'app_apProjet')]
    public function apProjet(): Response
    {
        return $this->render('base/projets/AP_Projet1.html.twig', [
        ]);
    }

    #[Route('/infra_reseau', name: 'app_infra_reseau')]
    public function infra_reseau(): Response
    {
        return $this->render('base/projets/infra_reseau.html.twig', [
        ]);
    }

    #[Route('/workshop_SN1', name: 'app_workshop_SN1')]
    public function workshop_SN1(): Response
    {
        return $this->render('base/projets/workshop_SN1.html.twig', [
        ]);
    }

    #[Route('/workshop_SN2', name: 'app_workshop_SN2')]
    public function workshop_SN2(): Response
    {
        return $this->render('base/projets/workshop_SN2.html.twig', [
        ]);
    }

    #[Route('/atelier_CNIL', name: 'app_atelier_CNIL')]
    public function atelier_CNIL(): Response
    {
        return $this->render('base/certifications/atelier_CNIL.html.twig', [
        ]);
    }

    #[Route('/patrimoine_info', name: 'app_patrimoine_info')]
    public function patrimoine_info(): Response
    {
        return $this->render('base/patrimoine_info.html.twig', [
        ]);
    }

    #[Route('/incidents', name: 'app_incidents')]
    public function incidents(): Response
    {
        return $this->render('base/incidents/incidents.html.twig', [
        ]);
    }

    #[Route('/presence_ligne', name: 'app_presence_ligne')]
    public function presence_ligne(): Response
    {
        return $this->render('base/presence_ligne/presence_ligne.html.twig', [
        ]);
    }

    #[Route('/travailler_mode_projet', name: 'app_travailler_mode_projet')]
    public function travailler_mode_projet(): Response
    {
        return $this->render('base/travailler_en_mode_projet/travailler_mode_projet.html.twig', [
        ]);
    }

    #[Route('/service_info', name: 'app_service_info')]
    public function service_info(): Response
    {
        return $this->render('base/service_info/service_info.html.twig', [
        ]);
    }

    #[Route('/tests_integration', name: 'app_tests_integration')]
    public function tests_integration(): Response
    {
        return $this->render('base/service_info/tests_integration.html.twig', [
        ]);
    }

    #[Route('/deploiement_service', name: 'app_deploiement_service')]
    public function deploiement_service(): Response
    {
        return $this->render('base/service_info/deploiement_service.html.twig', [
        ]);
    }

    #[Route('/accompagnement_utilisateur', name: 'app_accompagnement_utilisateur')]
    public function accompagnement_utilisateur(): Response
    {
        return $this->render('base/service_info/accompagnement_utilisateur.html.twig', [
        ]);
    }

    #[Route('/dev_pro', name: 'app_dev_pro')]
    public function dev_pro(): Response
    {
        return $this->render('base/dev_pro/dev_pro.html.twig', [
        ]);
    }

    #[Route('/env_apprentissage', name: 'app_env_apprentissage')]
    public function env_apprentissage(): Response
    {
        return $this->render('base/dev_pro/env_apprentissage.html.twig', [
        ]);
    }

    #[Route('/veille_informationnelle', name: 'app_veille_informationnelle')]
    public function veille_informationnelle(): Response
    {
        return $this->render('base/dev_pro/veille_informationnelle.html.twig', [
        ]);
    }

    #[Route('/identite_professionnelle', name: 'app_identite_professionnelle')]
    public function identite_professionnelle(): Response
    {
        return $this->render('base/dev_pro/identite_professionnelle.html.twig', [
        ]);
    }

    #[Route('/projet_professionnel', name: 'app_projet_professionnel')]
    public function projet_professionnel(): Response
    {
        return $this->render('base/dev_pro/projet_professionnel.html.twig', [
        ]);
    }

    #[Route('/gerer_sauvegardes', name: 'app_gerer_sauvegardes')]
    public function gerer_sauvegardes(): Response
    {
        return $this->render('base/gerer-les-sauvegardes.html.twig', [
        ]);
    }

    #[Route('/recensement', name: 'app_recensement')]
    public function recensement(): Response
    {
        return $this->render('base/recensement.html.twig', [
        ]);
    }

    #[Route('/exploitation_caracteristiques', name: 'app_exploitation_caracteristiques')]
    public function exploitation_caracteristiques(): Response
    {
        return $this->render('base/exploitation_caracteristiques.html.twig', [
        ]);
    }

    #[Route('/installation_poste', name: 'app_installation_poste')]
    public function installation_poste(): Response
    {
        return $this->render('base/installation_poste.html.twig', [
        ]);
    }

    #[Route('/continuite_service', name: 'app_continuite_service')]
    public function continuite_service(): Response
    {
        return $this->render('base/continuite_service.html.twig', [
        ]);
    }

    #[Route('/regles_utilisation', name: 'app_regles_utilisation')]
    public function regles_utilisation(): Response
    {
        return $this->render('base/regles_utilisation.html.twig', [
        ]);
    }

    #[Route('/collecte_incident', name: 'app_collecte_incident')]
    public function collecte_incident(): Response
    {
        return $this->render('base/incidents/collecte_incident.html.twig', [
        ]);
    }

    #[Route('/incidents_service', name: 'app_incidents_service')]
    public function incidents_service(): Response
    {
        return $this->render('base/incidents/incidents_service.html.twig', [
        ]);
    }

    #[Route('/assistance_utilisateur', name: 'app_assistance_utilisateur')]
    public function assistance_utilisateur(): Response
    {
        return $this->render('base/incidents/assistance_utilisateur.html.twig', [
        ]);
    }

    #[Route('/valorisation_image', name: 'app_valorisation_image')]
    public function valorisation_image(): Response
    {
        return $this->render('base/presence_ligne/valorisation_image.html.twig', [
        ]);
    }

    #[Route('/referencement_services', name: 'app_referencement_services')]
    public function referencement_services(): Response
    {
        return $this->render('base/presence_ligne/referencement_services.html.twig', [
        ]);
    }

    #[Route('/evolution_site_web', name: 'app_evolution_site_web')]
    public function evolution_site_web(): Response
    {
        return $this->render('base/presence_ligne/evolution_site_web.html.twig', [
        ]);
    }

    #[Route('/analyser_objectifs_projet', name: 'app_analyser_objectifs_projet')]
    public function analyser_objectifs_projet(): Response
    {
        return $this->render('base/travailler_en_mode_projet/analyser_objectifs_projet.html.twig', [
        ]);
    }

    #[Route('/planifier_activites', name: 'app_planifier_activites')]
    public function planifier_activites(): Response
    {
        return $this->render('base/travailler_en_mode_projet/planifier_activites.html.twig', [
        ]);
    }

    #[Route('/evaluer_indicateurs_suivi', name: 'app_evaluer_indicateurs_suivi')]
    public function evaluer_indicateurs_suivi(): Response
    {
        return $this->render('base/travailler_en_mode_projet/evaluer_indicateurs_suivi.html.twig', [
        ]);
    }
}


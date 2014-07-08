<?php

namespace Aml\Bundle\BlogBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Aml\Bundle\BlogBundle\Entity\Blog;
use Aml\Bundle\BlogBundle\Form\Admin\BlogType;

/**
 * Blog controller.
 *
 * @Route("/admin/content/blog")
 */
class BlogController extends Controller
{
    protected $_limitPagination = 15;

    /**
     * Lists all Blog entities.
     *
     * @Route("/{page}", name="admin_content_blog", requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryBlog = $em->getRepository('AmlBlogBundle:Blog');

        $allEntities = $repositoryBlog->findAll();
        $nbEntities = count($allEntities);
        $num_pages = $page; // some calculation of what page you're currently on
        $nbPages = (int)ceil($nbEntities / $this->_limitPagination);


        $entities = $repositoryBlog->findBy(
            array(),
            array('created' => 'DESC'),
            $this->_limitPagination,
            $this->_limitPagination * ($num_pages - 1)
        );


        // Calcul de la pagination
        $calculLastPage = round($nbEntities / $this->_limitPagination);
        $pagination = array(
            'nbPages' => $nbPages,
            'nbEntities' => $nbEntities,
            'limit' => $this->_limitPagination,
            'currentPage' => $page,
            'nextPage' => ($page + 1 * $this->_limitPagination < $nbEntities ? $page + 1 : false),
            'prevPage' => ($page - 1 > 0 ? $page - 1 : false),
            'lastPage' => ($calculLastPage >= 0 ? $calculLastPage : 0)
        );

        return array(
            'entities' => $entities,
            'pagination' => $pagination
        );
    }

    /**
     * Displays a form to create a new Blog entity.
     *
     * @Route("/new", name="admin_content_blog_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Blog();
        $form = $this->createForm(new BlogType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Blog entity.
     *
     * @Route("/create", name="admin_content_blog_create")
     * @Method("post")
     * @Template("AmlBlogBundle:Blog:new.html.twig")
     */
    public function createAction()
    {
        //var_dump( $_POST );
        $entity = new Blog();
        $request = $this->getRequest();

        //$em = $this->getDoctrine()->getManager();
        //  $blogRepository = $em->getRepository('AmlBlogBundle:Blog');

        $form = $this->createForm(new BlogType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Set Tags
            // var_dump( $form->get('tags')->getData() );
            if ($form->get('tags')->getData()) {
                foreach ($form->get('tags')->getData() as $tag_id) {
                    $entityTag = $em->getRepository('AmlBlogBundle:BlogTags')->find($tag_id);
                    $entityTag->getArticles()->add($entity);
                }
            }

            $entity
                ->setCreated(new \DateTime())
                ->setUpdated(new \DateTime())
                ->setPublished(new \DateTime())
                ->setUrl();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('success', 'L\'article a été créé avec succès');
            return $this->redirect($this->generateUrl('admin_content_blog'));

        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Blog entity.
     *
     * @Route("/{id}/edit", name="admin_content_blog_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlBlogBundle:Blog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $editForm = $this->createForm(new BlogType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Blog entity.
     *
     * @Route("/{id}/update", name="admin_content_blog_update")
     * @Method("post")
     * @Template("AmlBlogBundle:Blog:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $blogRepository = $em->getRepository('AmlBlogBundle:Blog');
        $entity = $blogRepository->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $editForm = $this->createForm(new BlogType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {

            // Clean tags
            $blogRepository->cleanTags($entity);

            $listTags = $entity->getTags();


            // Save tags
            foreach ($editForm->get('tags')->getData() as $tag_id) {
                $entityTag = $em->getRepository('AmlBlogBundle:BlogTags')->find($tag_id);
                $entityTag->getArticles()->add($entity);
            }


            $entity
                ->setUpdated(new \DateTime())
                ->setUrl();

            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('success', 'L\'article a été mis à jour avec succès');
            return $this->redirect($this->generateUrl('admin_content_blog'));
        } else {
            $this->get('session')->setFlash('error', 'Une erreur est survenue lors de la mise à jour de l\'article "' . $entity->getTitle() . '".');
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Blog entity.
     *
     * @Route("/{id}/delete", name="admin_content_blog_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AmlBlogBundle:Blog')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Blog entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('content_blog'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }


    /* GESTION DES TAGS */
    /**
     * Action to search tags for autocomplete field
     *
     * @Route("/tags-ajax-autocomplete", name="blog_tags_ajax_autocomplete")
     * @Template()
     */
    public function ajaxAutocompleteTagsAction(Request $request)
    {
        // récupération du mots clés en ajax selon la présélection du mot
        $value = $request->get('term');
        $em = $this->getDoctrine()->getManager();
        $blogTagsRepository = $em->getRepository('AmlBlogBundle:BlogTags');
        $tags = $blogTagsRepository->getTags($value);

        return new Response(json_encode($tags));
    }

    /**
     * Action to load tag or create it if not exist
     *
     * @Route("/tags-load-item", name="blog_tags_load_item")
     * @Template()
     */
    public function ajaxLoadTagAction(Request $request)
    {
        // récupération du mots clés en ajax selon la présélection du mot
        $value = $request->get('tag');


        $em = $this->getDoctrine()->getManager();
        $blogTagsRepository = $em->getRepository('AmlBlogBundle:BlogTags');

        // Check if tag Already exist
        $resultTag = $blogTagsRepository->loadOneTagByName($value);
        if (false === $resultTag) {

            // Create a new tag
            $newEntityTag = new \Aml\Bundle\BlogBundle\Entity\BlogTags();
            $newEntityTag
                ->setName($value)
                ->setSystemName($value);
            $em->persist($newEntityTag);
            $em->flush();

            // Parsing result
            $resultTag = array(
                'id' => $newEntityTag->getId(),
                'name' => $newEntityTag->getName()
            );
        }

        return new Response(json_encode($resultTag));
    }
}

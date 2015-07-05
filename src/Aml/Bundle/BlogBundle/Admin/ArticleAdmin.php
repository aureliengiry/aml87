<?php
namespace Aml\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Aml\Bundle\MediasBundle\Form\Admin\ImageType;

class ArticleAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'id'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        // use $thumbnailFieldOptions so we can add other options to the field
        /*$avatarFieldOptions = array('required' => false,'data_class' => null);
        if ($user) {
            $avatar = $user->getAvatar();
            if( empty($avatar) ){
                $avatar = $user->getGravatar();
            }
            else{
                $avatar = '/' . $user->getAvatarWebPath();
            }
            // add a 'help' option containing the preview's img tag
            $avatarFieldOptions['help'] = '<img src="'.$avatar.'" class="admin-preview" />';
        }

        $formMapper
            ->with('General')
            ->add('login')
            ->add('email')
            //->add('plainPassword', 'text', array('required' => false))
            ->end()
            ->with('Profile')
            ->add('avatar','file',$avatarFieldOptions)
            ->add('firstname','text', array(
                'required' => false,
            ))
            ->add('lastname','text', array(
                'required' => false,
            ))
            ->add('nsfw_mode', null, array('required' => false))
            ->end()
*/
        $formMapper
            ->with('General')
                ->add('title', 'text')
                /*->add('url', 'text',array(
                    'required' => false,
                    'data_class' => '\Aml\Bundle\UrlRewriteBundle\Entity\UrlArticle',
                    'read_only' => true
                ))*/
                ->add('category', 'entity', array(
                    'label' => 'Catégorie',
                    'class' => 'AmlBlogBundle:Category',
                    'property' => 'name',
                    'empty_value' => 'Choisissez une catégorie',
                    'attr' => array('class'=>'uniform')
                ))
                ->add('body', 'textarea', array(
                    'label' => 'Texte',
                    'attr' => array('size' => 15, 'data-help' => 'Texte de l\'article'),
                    'required' => false,
                    'wysiwyg' => true
                ))
                ->add('public', 'checkbox', array(
                    'label' => 'Publier',
                    'required' => false,
                    'attr' => array('data-help' => 'Signifie que l\'article sera visible pour tout le monde'),
                ))
            ->end()
            ->with('Image')
                ->add('logo','sonata_type_admin',array(
                    'delete' => false,
                    'required' => false
                ))
            ->end()
            ->with('Tags')
                ->add('tags', 'sonata_type_model', array(
                    'required' => false,
                    'expanded' => false,
                    'multiple' => true,
                    'by_reference' => false,
                    'attr'=>array('data-sonata-select2'=>'true')
                ))
            ->end()
            ->with('Evenements')
            ->add('evenements', 'sonata_type_model', array(
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false
            ))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('category')
            ->add('public')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('created')
            ->add('updated')
            ->add('category')
            ->add('public');
    }

    /**
     * @param string $name
     *
     * @return null|string
     */
    public function getTemplate($name)
    {
        if (isset($this->templates[$name])) {
            return $this->templates[$name];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($article)
    {
        $article->setUpdated(new \DateTime);

        // $this->_setLogoTitle($article);
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($article)
    {
        $article->setCreated(new \DateTime);
        $article->setUpdated(new \DateTime);

        //$this->_setLogoTitle($article);
    }

    protected function _setLogoTitle($article)
    {
        $logo = $article->getLogo();

        $logo->setTitle($article->getTitle());

        // Remove old file
        $logo->storeFilenameForRemove();
        $logo->removeUpload();

        // Upload
        $logo->preUpload();
    }
}
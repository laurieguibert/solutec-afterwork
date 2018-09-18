<?php

namespace App\Form;

use App\Entity\Campaign;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignType extends AbstractType
{
    private $em;

    /**
     * The Type requires the EntityManager as argument in the constructor. It is autowired
     * in Symfony 3.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            /*->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'name',
                'label' => 'Catégorie',
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])*/
            ->add('mailingList', EntityType::class, [
                'class' => 'App\Entity\MailingList',
                'choice_label' => 'name',
                'label' => 'Liste de diffusion',
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
                'required' => false,
                'empty_data' => null,
            ])
            ->add('users', EntityType::class, [
                'class' => 'App\Entity\User',
                'choice_label' => 'fullName',
                //'expanded'  => true,
                'multiple'  => true,
                'label' => 'Utilisateurs',
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            /*->add('template', CKEditorType::class, [
                "label" => "Contenu du mail",
                "mapped" => false,
                "required" => false
            ])*/
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, Category $category = null) {
        $form->add('category', EntityType::class, array(
            'required' => true,
            'data' => $category,
            'placeholder' => 'Sélectionner une catégorie',
            'class' => 'App\Entity\Category',
            'choice_label' => 'name',
            'label' => 'Catégorie',
            'label_attr' => [
            'style' => 'font-size :14px;'
        ],
        ));

        $templates = array();

        if ($category) {
            $repoTemplate = $this->em->getRepository('App\Entity\Template');

            $templates = $repoTemplate->createQueryBuilder("q")
                ->where("q.category = :category_id")
                ->setParameter("category_id", $category->getId())
                ->getQuery()
                ->getResult();
        }

        $form->add('template', EntityType::class, array(
            'class' => 'App\Entity\Template',
            'choice_label' => 'name',
            'choices' => $templates,
            'label_attr' => [
                'style' => 'font-size :14px;'
            ]
        ));

        $form->add('templateContent', CKEditorType::class, [
            'mapped' => false,
            'disabled' => true,
            'label_attr' => [
                'style' => 'font-size :14px;'
            ],
            'label' => 'Contenu du template'
        ]);

        $form->add('newTemplate', CKEditorType::class, [
            'mapped' => false,
            'label_attr' => [
                'style' => 'font-size :14px;'
            ],
            'label' => 'Template personnalisé'
        ]);
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        $category = $this->em->getRepository('App\Entity\Category')->find($data['category']);

        $this->addElements($form, $category);
    }

    function onPreSetData(FormEvent $event) {
        $campaign = $event->getData();
        $form = $event->getForm();

        $category = $campaign->getCategory() ? $campaign->getCategory() : null;

        $this->addElements($form, $category);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Campaign::class,
        ]);
    }
}

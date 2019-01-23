<?php

namespace App\Controller\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FormBuilder
{
    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function buildForm()
    {
        return Forms::createFormFactoryBuilder()
            // ...
            ->getFormFactory()
            ->createBuilder()
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->getForm();
    }
}
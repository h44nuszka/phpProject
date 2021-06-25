<?php
/**
 * UsersData type.
 */

namespace App\Form;

use App\Entity\UsersData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UsersDataType.
 */
class UsersDataType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'label_name',
                'required' => true,
                'attr' => ['max_length' => 64],
            ],
        );
        $builder->add(
            'surname',
            TextType::class,
            [
                'label' => 'label_surname',
                'required' => true,
                'attr' => ['max_length' => 255],
            ],
        );

        $builder->add(
            'nick',
            TextType::class,
            [
                'label' => 'label_nick',
                'required' => true,
                'attr' => ['max_length' => 255],
            ],
        );

        $builder->add(
            'phoneNumber',
            TextType::class,
            [
                'label' => 'label_phone_number',
                'required' => true,
                'attr' => ['max_length' => 32],
            ],
        );

        $builder->add(
            'birthDate',
            DateType::class,
            [
                'years' => range(date('Y') - 100, date('Y') - 1),
            ],
            [
                'label' => 'label_birth_date',
                'required' => true,
            ],
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => UsersData::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'usersData';
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use DateTimeImmutable;
use DateTimeZone;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UsersCrudController extends AbstractCrudController implements EventSubscriberInterface
{


    public static function getEntityFqcn(): string
    {
        return Users::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $roles = [
            'Administrator' => 'ROLE_ADMIN',
            'User' => 'ROLE_USER'
        ];
        if ($pageName === Crud::PAGE_INDEX) {
            return [
                TextField::new('username'),
                EmailField::new('email')
                    ->hideWhenUpdating(),
                ArrayField::new('roles'),
                BooleanField::new('confirmed'),
                DateField::new('created_at')->setFormat('d/m/Y')->onlyOnIndex()
            ];
        } elseif ($pageName === Crud::PAGE_NEW) {

            return [
                TextField::new('username'),
                EmailField::new('email'),
                TextField::new('password'),
                ChoiceField::new('roles')
                    ->allowMultipleChoices()
                    ->setChoices($roles),
                BooleanField::new('confirmed')
            ];
        } elseif ($pageName === Crud::PAGE_EDIT) {
            return [
                TextField::new('username'),
                ChoiceField::new('roles')
                    ->allowMultipleChoices()
                    ->setChoices($roles),
                BooleanField::new('confirmed')
            ];
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['beforePersist'],
            BeforeEntityUpdatedEvent::class => ['beforeUpdate'],
        ];
    }

    public function beforePersist(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if ($entity instanceof Users) {
            $entity
                ->setCreatedAt();
        }
    }

    public function beforeUpdate(BeforeEntityUpdatedEvent $event)
    {
        $timezone = new DateTimeZone('Europe/Paris');
        $entity = $event->getEntityInstance();
        if ($entity instanceof Users) {
            $entity->setUpdatedAt(new DateTimeImmutable('now', $timezone));
        }
    }
}
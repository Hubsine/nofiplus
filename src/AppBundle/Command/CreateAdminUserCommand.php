<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\User\Admin;
use AppBundle\Doctrine\DoctrineUtil;
use AppBundle\Util\TokenGeneratorUtil;

/**
 * Description of CreateAdminUserCommand
 *
 * @author Hubsine <contact@hubsine.com>
 */
class CreateAdminUserCommand extends Command
{
    /**
     * @var DoctrineUtil
     */
    private $doctrineUtil;
    
    /**
     * @var TokenGeneratorUtil
     */
    private $tokenGenerator;
    
    private $abortedMessage = 'Un ou plusieurs utilisateurs possédant le role "ROLE_SUPER_ADMIN" existe déjà.';

    public function __construct(DoctrineUtil $doctrineUtil, TokenGeneratorUtil $tokenGenerator, $name = null) 
    {
        parent::__construct($name);
        
        $this->doctrineUtil     = $doctrineUtil;
        $this->tokenGenerator  = $tokenGenerator;
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:user:create-admin')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates single user Super Admin if not exist')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Cette commande créee un utilisateur avec le role ROLE_SUPER_ADMIN si ce dernier n\'existe pad déja');
        
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $admins              = $this->doctrineUtil->getRepository(Admin::class)->findAll();
        
        if( count($admins) > 0 )
        {
            $output->writeln($this->abortedMessage);
        }else{
            
            $output->writeln("Creation de l'utilisateur avec le role ROLE_SUPER_ADMIN...");
        
            $username = 'Super admin 2';
            $email = 'super_admin2@nofiplus.fr';
            $password = substr($this->tokenGenerator->generateToken(), 0, 10);

            $user = new Admin();

            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setEnabled(true);
            $user->setEnabledByAdmin(true);

            $this->doctrineUtil->persist($user);
            
            $output->writeln("L'Utilisateur admin a été créer. Notez les identifiants...");
            $output->writeln([
                'email : ' . $email, 
                'Mot de passe : ' . $password
            ]);
            
        }
    }
}

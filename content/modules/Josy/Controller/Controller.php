<?php
/*
 *
 * (c) Prudence D. ASSOGBA <jprud67@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 10/06/2018
 * Time: 21:26
 */

namespace Josy\Controller;


use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use Twig_Loader_Filesystem;

class  Controller
{
    public $container;
    public $em;
    public function __construct()
    {
        $this->container= include join(DIRECTORY_SEPARATOR,[__DIR__,'..','Container.php']);
        $this->em=$this->container->get('entity_manager')->em;
    }

    public function getContainer(){
       return include join(DIRECTORY_SEPARATOR,[__DIR__,'..','Container.php']);
    }

    /**
     * @param $path
     * @param array $variables
     * @return Response
     */
    public function render($path, $variables=array())
    {
        $loader = new Twig_Loader_Filesystem(join(DIRECTORY_SEPARATOR,[__DIR__,'..','..','..','themes']));
        $twig = new Twig_Environment($loader, array(
            'debug' => true,
            'charset' => 'UTF-8',
            'base_template_class' => 'Twig_Template',
            'strict_variables' => true,
            'autoescape' => 'html',
            'cache' =>join(DIRECTORY_SEPARATOR,[__DIR__,'..','..','..','..','var','cache','twig']),
            'auto_reload' => null,
            'optimizations' => -1,
        ));


        return new Response($twig->render($path,$variables));
    }


}
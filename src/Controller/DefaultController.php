<?php
namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use \Symfony\Component\Yaml\Yaml;
use \Symfony\Component\Yaml\Parser;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {

    	$yaml = new Parser();
		$values = $yaml->parse( file_get_contents( '/home/adyma/wwwroot/symfony/organizations/public/files/organizations.yaml' ) );

		/*echo "<pre>";
		print_r( $values);
*/
        return $this->render('default/index.html.twig', compact('values'));
    }

    public function edit(int $id): Response
    {

    	$yaml = new Parser();
			$values = $yaml->parse( file_get_contents( '/home/adyma/wwwroot/symfony/organizations/public/files/organizations.yaml' ) );

			$item = $values['organizations'][$id];
			$item['id'] = $id; 
    	/*echo "<pre>";
    	print_r ( $id);
    	print_r ( $item);
    	echo "</pre>";

    	die;*/


    	return $this->render('default/edit.html.twig', compact('item'));;
    }

    public function add(): Response
    {
    	return $this->render('default/add.html.twig');
    }

    public function delete(int $id): Response
    {

    	$values = $this->deleteItem( $id);
    	
      return $this->render('default/index.html.twig', compact('values'));

    }

    public function save(Request $request, $type, $id): Response
    {

    	$yaml = new Parser();
			$values = $yaml->parse( file_get_contents( '/home/adyma/wwwroot/symfony/organizations/public/files/organizations.yaml' ) );


    	echo "<pre>";
    	print_r ( $values);
    	print_r ( $type);
    	print_r ( $id);
    	print_r ( $request->request->all());
    	$data = $request->request->all();
    	print_r ( $data['name']);
    	echo "</pre>";
    	die;


    	if ( $type == 'add')
    	{
    		
    	}
    	else
    	{
    		//$values = $this->deleteItem( $id);
    		//array_push( $values, )
    	}

    	die;
    	//return "0";
    }

    private function deleteItem( $id)
    {

    	$yaml = new Parser();
			$values = $yaml->parse( file_get_contents( '/home/adyma/wwwroot/symfony/organizations/public/files/organizations.yaml' ) );

    	unset ( $values['organizations'][$id]);

    	$__yaml = Yaml::dump($values);

			file_put_contents('/home/adyma/wwwroot/symfony/organizations/public/files/organizations.yaml', $__yaml);

			return ( $values);
    }
}
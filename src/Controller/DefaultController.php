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

		protected $file_path;

		public function __construct()
		{
			$this->file_path = dirname( dirname( dirname( __FILE__))) . '/public/files/organizations.yaml';
		}

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {

    	$yaml = new Parser();
		$values = $yaml->parse( file_get_contents( $this->file_path ) );

/*		echo "<pre>";
		print_r( $values);
die;*/
        return $this->render('default/index.html.twig', compact('values'));
    }

    public function edit(int $id): Response
    {

    	$yaml = new Parser();
			$values = $yaml->parse( file_get_contents( $this->file_path ) );

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
			$values = $yaml->parse( file_get_contents( $this->file_path ) );

    	if ( $type == 'add')
    	{

    		$data = $request->request->all();


    		$datos['name'] = $data['name'];
    		$datos['description'] = $data['description'];
    		$datos['users'][0]['name'] = $data['name_user'];
    		$datos['users'][0]['password'] = $data['password'];
    		$datos['users'][0]['role'][] = $data['role'];

    		array_push( $values['organizations'], $datos);

    		$__yaml = Yaml::dump($values);
				file_put_contents( $this->file_path, $__yaml);

    	}
    	else
    	{
    		$values = $this->deleteItem( $id);

    		$data = $request->request->all();

    		$datos['name'] = $data['name'];
    		$datos['description'] = $data['description'];

    		for ( $i = 0; $i < count($data['name_user']); $i++) 
    		{
    			$datos['users'][$i]['name'] = $data['name_user'][$i];
    			$datos['users'][$i]['password'] = $data['password'][$i];

    			foreach ( $data['role'][$i] as $value) 
    			{
    				$datos['users'][$i]['role'][] = $value;
    			}
    		}

    		array_push( $values['organizations'], $datos);

    		$__yaml = Yaml::dump($values);
				file_put_contents( $this->file_path, $__yaml);
    	}

    	
    	
    	return $this->render('default/index.html.twig', compact('values'));

    }

/*    private function saveItem( $dataArray)
    {
    	$yaml = new Parser();
			$values = $yaml->parse( file_get_contents( '/home/adyma/wwwroot/symfony/organizations/public/files/organizations.yaml' ) );

    	unset ( $values['organizations'][$id]);

    	$__yaml = Yaml::dump($values);

			file_put_contents('/home/adyma/wwwroot/symfony/organizations/public/files/organizations.yaml', $__yaml);

			return ( $values);
    }*/


    private function deleteItem( $id)
    {

    	$yaml = new Parser();
			$values = $yaml->parse( file_get_contents( $this->file_path ) );

    	unset ( $values['organizations'][$id]);

    	$__yaml = Yaml::dump($values);

			file_put_contents( $this->file_path, $__yaml);

			return ( $values);
    }
}
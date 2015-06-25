<?php
namespace ClimaClass\ApplicationBundle\Twig;
class TwigExtension extends \Twig_Extension
{
    /**
     * Return the functions registered as twig extensions
     * 
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'thumbnail_image' => new \Twig_Function_Method($this, 'thumbnail_image'),
            'isTabRainEmpty' => new \Twig_Function_Method($this, 'isTabRainEmpty'),
        );
    }
    public function thumbnail_image($content)
    {
         if(preg_match_all('/src=(["\'])(.*?)\1/mi', $content, $matches)) {
			$temp = explode("/", $matches[0][0]);
			return rtrim($temp[count($temp) - 1], '"');
         }
         else {
             return "default.png";
         }
        
    }
	
	public function isTabRainEmpty($tab){
		$i = 0;
		$isNull = true;
		
		while($isNull && $i < count($tab) - 1){
			$isNull = is_null($tab[$i]["rainlevel"]);
			$i++;
		}
		
		return $isNull;
	}
    
    public function getName()
    {
        return 'twig_extension';
    }
}
?>
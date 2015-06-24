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
        );
    }
    public function thumbnail_image($content)
    {
         if(preg_match_all('/src=(["\'])(.*?)\1/mi', $content, $matches)==true) {
            
            return str_replace('"','',(str_replace('src="','',(str_replace('/ClimaClass/web/bundles/climaclassapplication/libraries/../images/report/','',$matches[0][0])))));
         }
         else {
             return "default.png";
         }
        
    }
    
    public function getName()
    {
        return 'twig_extension';
    }
}
?>
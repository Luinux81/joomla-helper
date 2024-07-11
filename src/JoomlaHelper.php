<?php
namespace LBCdev;

class JoomlaHelper{


    /**
     * Obtiene la versión de Joomla (3,4, ...)
     *
     * @return string Versión mayor de Joomla
     */
    public static function getJoomlaVersion(){
        return explode(".", JVERSION)[0];
    }


    public static function getJoomlaPath(){
        switch(self::getJoomlaVersion()){
            case "2":            
            case "3":
                $uri = JUri::base();
                break;
            case "4":
            case "5":
            default:
                $uri = \Joomla\CMS\Uri\Uri::base();
                break;            
        }

        return $uri;
    }


    /**
     * Obtiene el objeto de aplicación Joomla
     *
     * @return object El objeto de aplicación Joomla 
     */
    public static function getJoomlaApp(){
        switch (self::getJoomlaVersion()){
            case "2":            
            case "3":
                $app = JFactory::getApplication();
                break;
            case "4":
            case "5":
            default:
                $app = \Joomla\CMS\Factory::getContainer()->get(\Joomla\CMS\Application\SiteApplication::class);               
        }

        return $app;
    }


    /**
     * Obtiene una conexión con la base de datos
     *
     * @return object El objeto de conexión con la base de datos
     */
    public static function getDBConnection(){
        switch (self::getJoomlaVersion()){
            case "2":            
            case "3":
                $db = JFactory::getDbo();
                break;
            case "4":
            case "5":
            default:
                $db = \Joomla\CMS\Factory::getContainer()->get('DatabaseDriver');
        }

        return $db;
    }


    /**
     * Determina desde la entrada de la aplicación si la vista actual corresponde a un articulo
     *
     * @param [type] $app
     * @return boolean True si la vista actual es un artículo, falso en caso contrario.
     */
    public static function isCurrentViewArticle(&$app){
        $res = false;

        $input = $app->input;

        if($input){
            $res = $input->getCmd('option') == 'com_content' && $input->getCmd('view') == 'article';
        }

        return $res;
    }


    /**
     * Determina desde la entrada de la aplicación si la vista actual corresponde a una categoría
     *
     * @param [type] $app
     * @return boolean True si la vista actual es una categoría, falso en caso contrario.
     */
    public static function isCurrentViewCategory(&$app){
        $res = false;

        $input = $app->input;

        if($input){
            $res = $input->getCmd('option') == 'com_content' && $input->getCmd('view') == 'category';
        }

        return $res;
    }

    /**
     * Determina si la vista actual es la página home del lenguaje actual
     *
     * @param [type] $app
     * @return boolean True si la vista actual es la página home, falso en caso contrario.
     */
    public static function isCurrentViewHome(&$app){
        $menu = $app->getMenu();
        $lang = $app->getLanguage();

        return $menu->getActive() == $menu->getDefault($lang->getTag());
    }

}

?>
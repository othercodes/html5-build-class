<?php
/**
 * Clase que crear paginas en HTML5 valido.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @copyright (c) 2014, David Unay Santisteban
 * @license http://www.gnu.org/licenses/gpl.txt GPLv2 
 * @version 1.0.20140306
 */

class html5 {
    
    /**
     * Codificacion del documento.
     * @var String 
     */
    public $charset;
    
    /**
     * Lenguaje que usara el documento.
     * @var String 
     */
    public $lang;
    
    /**
     * Constructor de la clase html5
     * @param String $charset define la codificacion 
     * @param String $lang define el lenguaje.
     */
    function __construct($charset="utf-8",$lang="es") {
        $this->doctype  = "<!doctype html>\n";
        $this->charset  = $charset;
        $this->lang     = $lang;
    }
    
    /**
     * Establece el titulo de la ventana
     * @param string $title titulo de la ventana 
     */
    public function setTitle($title){
        $this->title = "\t<title>".$title."</title>\n";
    }
    
    /**
     * Añade una hoja de estilos
     * @param string $css ruta del css
     */
    public function addCSS($css) {
        $this->stylesheets .= "\t".'<link rel="stylesheet" href="'.$css.'" />'."\n";
    }
    
    /**
     * Añade un documento javascript
     * @param string $js ruta de js
     */
    public function addJS($js) {
        $this->script .= "\t".'<script src="'.$js.'"></script>'."\n";
    }
    
    /**
     * Carga contenido en el buffer.
     * @param mixed $content contenido del body
     */
    public function loadContent($content){
        $this->content .= $content;
    }
    
    /**
     * Imprime una etiqueta con su contenido
     * @param string $tag nombre de la etiqueta.
     * @param string $content contenido
     * @param String $id nombre del id de la tabla.
     * @param String $class nombre de la class de la tabla.
     * @return String resultado html
     */
    public static function tag($tag,$content,$id,$class,$style){
        $id     = ($id != null)? " id='$id'":"";
        $class  = ($class != null)? " class='$class'":"";
        $style  = ($style != null)? " style='$style'":"";
        $buffer .= "<".$tag.$id.$class.$style.">\n".$content."\n</".$tag.">\n";
        return $buffer;
    }
    
    /**
     * Construye una tabla en base a los arrays recibidos
     * @param mixed $thead puede ser un array simple o la clave ASSOC_THEAD, 
     * este ultimo cargara el nombre asociado de cada campo. 
     * @param array $tfooter array simple para el pie de la tabla.
     * @param array $tbody array 2D para el cuerpo de la tabla.
     * @param String $id nombre del id de la tabla.
     * @param String $class nombre de la class de la tabla.
     * @return String html de la tabla
     */
    public static function table($thead,$tfoot,$tbody,$id,$class){
        $id     = ($id != null)? " id='$id'":"";
        $class  = ($class != null)? " class='$class'":"";
        
        $table = "<table$id$class>\n";
        if($thead != NULL) {
            $table .= "<thead>\n<tr>\n";
            if ($thead != "ASSOC_THEAD") {
                foreach ($thead as $cell) {
                    $table .= "\t<th>$cell</th>\n";
                }
            } else {
                foreach ($tbody[0] as $th => $cell) {
                    $table .= "\t<th>".ucwords($th)."</th>\n";
                }
            }
            $table .= "</tr>\n</thead>\n";
        }

        if($tfoot != NULL) {
            $table .= "<tfoot>\n<tr>\n";
            foreach ($tfoot as $cell) {
                $table .= "\t<td>$cell</td>\n";
            }
            $table .= "</tr>\n</tfoot>\n";
        }

        $table .= "<tbody>\n";
        foreach ($tbody as $tr){
            $table .= "<tr>\n";
            foreach ($tr as $td) {
                $table .= "\t<td>$td</td>\n";
            }
            $table .= "</tr>\n";
        }
        $table .= "</tbody>\n";
        $table .= "</table> \n";
        return $table;
    }
    
    /**
     * Imprime imagenes usando la etiqueta img.
     * @param String $src ruta de la imagen.
     * @param String $alt texto alternativo.
     * @param String $id id de la imagen.
     * @param String $class clase de la imagen.
     * @return String html de la imagen.
     */
    public static function img($src,$alt,$id,$class){
        $id     = ($id != null)? " id='$id'":"";
        $class  = ($class != null)? " class='$class'":"";
        $buffer = "<img src=\"".$src."\" alt=\"".$alt."\" $id$class />\n";
        return $buffer;
    }
    
    /**
     * Crea un enlace
     * @param String $href url del enlace.
     * @param String $target objetivo del enlace _self, _blank o _parent
     * @param String $text texto del enlace.
     * @param String $id id del enlace.
     * @param String $class clase del enlace.
     * @return String html final del enlace.
     */
    public static function link($href,$target="_self",$text,$id,$class){
        $id     = ($id != null)? " id='$id'":"";
        $class  = ($class != null)? " class='$class'":"";
        $buffer = "<a href=\"$href\" target=\"$target\" $id$class>".$text."</a>\n";
        return $buffer;
    }
    
    /**
     * Crea listas de un nivel ordenadas o desordenas.
     * @param array $list array con las entradas de la lista.
     * @param String $type puede ser ordenada (ol) o deshordenada (ul) por defecto.
     * @param String $id id de la lista.
     * @param String $class clase de la lista.
     * @return String html de la lista.
     */
    public static function lists($list,$type="ul",$id,$class){
        $id     = ($id != null)? " id='$id'":"";
        $class  = ($class != null)? " class='$class'":"";
        $buffer = "<$type$id$class>\n";
        foreach ($list as $entry){
            $buffer .= "\t<li>$entry</li> \n";
        }
        $buffer .= "</$type> \n";
        return $buffer;
    }
    
    /**
     * Contruye un campo de formulario
     * @param String $type tipo del input
     * @param String $name nombre del input
     * @param String $value valor del input
     * @param String $id id del input
     * @param String $class clase del input
     * @param boolean $disabled establece si el campo esta deshabilitado o no.
     * @return String codigo html final
     */
    public static function input($type,$name,$value,$id,$class,$disabled=false) {
        $id     = ($id != null)? " id='$id'":"";
        $class  = ($class != null)? " class='$class'":"";
        $value  = ($value != null)? " value='$value'":"";
        $disabled = ($disabled == true)? " disabled='disabled'":"";
        $buffer = "<input type=\"$type\" name=\"$name\"$value$disabled$id$class>\n";
        return $buffer;
    }
    
    /**
     * Crea un textarea.
     * @param String $name nombre del textarea
     * @param String $value contenido del textarea
     * @param String $id id del textarea
     * @param String $class clase del textarea
     * @return String html final
     */
    public static function textarea($name,$value,$id,$class){
        $id     = ($id != null)? " id='$id'":"";
        $class  = ($class != null)? " class=\'$class\'":"";
        $name   = ($name!= null)? " name='$name'":"";
        $buffer = "<textarea $name$id$class>$value</textarea>\n";
        return $buffer;
    }
    
    /**
     * Contrute un formulario
     * @param String $fields campos que contiene el formulario.
     * @param String $action url del archivo que procesara la informacion
     * @param String $method metodo que usara, puede ser POST o GET
     * @param String $legend nombre del fieldset
     * @param String $enctype tipo de enctype por defecto aplication/x-www-form-urlencoded
     * @param String $name nombre del formulario
     * @param String $id id del formulario
     * @param String $fieldset habilita o deshabilita el uso de fieldset puede ser true o false
     * @return string devuelve el html final del formulario.
     */
    public static function buildForm($fields,$action,$method="post",$legend,$enctype,$name,$id,$fieldset=true){
        $name   = ($name != null)? " name='$name'":"";
        $id     = ($id != null)? " id='$id'":"";
        $enctype = ($enctype == "default")? " enctype='application/x-www-form-urlencoded'":"";
        $legend = ($legend != null)? "<legend>$legend</legend>\n":"";
        $buffer = "<form$name$id action=\"$action\" method=\"$method\"$enctype>\n";
        if ($fieldset != null) {
            $buffer .= "<fieldset>\n$legend$fields</fieldset>\n";
        } else {
             $buffer .= "\n$fields\n";
        }
        $buffer .= "</form>\n";
        return $buffer;
    }
    
    /**
     * Crea selecciones desplegables.
     * @param array $options array simple con las opciones del desplegable.
     * @param String $id id del select 
     * @param String $class clase del select 
     * @return string codigo html final
     */
    public static function select($options,$name,$id,$class){
        $class   = ($name != null)? " class='$class'":"";
        $id     = ($id != null)? " id='$id'":"";
        $name   = ($name != null)? " name='$name'":"";
        $buffer = "<select$name$id$class>\n";
        foreach($options as $key => $option){
            $buffer .= "<option value=\"$key\">".$option."</option>\n";
        }
        $buffer .= "</select>\n";
        return $buffer;
    }
    
    /**
     * Monta el head del documento.
     */
    private function buildHead(){
        $this->head = "<head>\n".$this->title."\t<meta charset=\"".$this->charset."\">\n".$this->script.$this->stylesheets."</head>\n";
    }
    
    /**
     * Monta el body del documento.
     */
    private function buildBody(){
        $this->body = "<body>\n".$this->content."</body>\n";
    }
    
    /**
     * Estructura el documento HTML
     */
    private function buildDocument(){
        $this->document = $this->doctype."<html lang=\"".$this->lang."\">\n".$this->head.$this->body."</html>";
    }
    
    /**
     * Renderiza el documento HTML5
     */
    public function render(){
        $this->buildHead();
        $this->buildBody();
        $this->buildDocument();
        print $this->document;
    }
}

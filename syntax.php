<?php
/**
 * Signhere Plugin: Display a signature line with a description 
 * Usage: ____(<Description>)____
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Dennis Ploeger <develop@dieploegers.de>
 */

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_signhere extends DokuWiki_Syntax_Plugin {

    // How many spaces do you wish to be put around the description?

    var $space_fill = 4;
 
    // How much do you like the min-width of the signature line?

    var $min_width = "100px";

    // What font size do you want for the description?

    var $font_size = "x-small";

    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }
   
    /**
     * Where to sort in?
     */ 
    function getSort(){
        return 400;
    }

    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern("-_.*?_-", $mode ,'plugin_signhere');
    }

    /**
     * Handle the match
     */

    function handle($match, $state, $pos, &$handler){
        preg_match('/-_(.*?)_-/', $match, $matches);
        return array($matches[1]);
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
        global $INFO, $conf;

        if($mode == 'xhtml'){

            $data[0] = str_repeat('&nbsp;', $this->space_fill).$data[0].str_repeat('&nbsp;', $this->space_fill);
            
            $renderer->doc .= '<table border="0" cellspacing="0" cellpadding="0">';
            $renderer->doc .= '<tr>';
            $renderer->doc .= '<td style="min-width:'.$this->min_width.';border-bottom:1px solid #000000">&nbsp;</td>';
            $renderer->doc .= '</tr>';
            $renderer->doc .= '<tr>';
            $renderer->doc .= '<td align="center" style="font-size:'.$this->font_size.';">'.$data[0].'</td>';
            $renderer->doc .= '</tr>';
            $renderer->doc .= '</table>';
            $renderer->doc .= '<br />';

            return true;
        }
        return false;
    }

}

//Setup VIM: ex: et ts=4 enc=utf-8 :

?>

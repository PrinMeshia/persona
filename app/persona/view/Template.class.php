<?php
namespace app\persona\view;

class Template 
{
    private $vars = array();
    private $lDelim = '{',
            $rDelim = '}';

    public function assign( $key, $value ) {
        $this->vars[$key] = $value;
    }

    public function parse( $templateFile ) {
        if ( file_exists( $templateFile ) ) {
            $content = file_get_contents($templateFile);
            foreach ( $this->vars as $key => $value ) {
                if ( is_array( $value ) ) {
                    $content = $this->parsePair($key, $value, $content);
                } else {
                    $content = $this->parseSingle($key, (string) $value, $content);
                }
            }
            eval( '?> ' . $content . '<?php ' );
        } else {
            exit( '<h1>Template error</h1>' );
        }
    }
    private function parseSingle( $key, $value, $string, $index ) {
        if ( isset( $index ) ) {
            $string = str_replace( $this->lDelim . '%index%' . $this->rDelim, $index, $string );
        }
        return str_replace( $this->lDelim . $key . $this->rDelim, $value, $string );
    }
     private function parsePair( $variable, $data, $string ) {
        $match = $this->matchPair($string, $variable);
        if( $match == false ) return $string;
        $str = '';
        foreach ( $data as $k_row => $row ) {
            $temp = $match['1'];
            foreach( $row as $key => $val ) {
                if( !is_array( $val ) ) {
                    $index = array_search( $k_row, array_keys( $data ) );
                    $temp = $this->parseSingle( $key, $val, $temp, $index );
                } else {
                    $temp = $this->parsePair( $key, $val, $temp );
                }
            }
            $str .= $temp;
        }
        return str_replace( $match['0'], $str, $string );
    }
    private function matchPair( $string, $variable ) {
        if ( !preg_match("|" . preg_quote($this->lDelim) . 'loop ' . $variable . preg_quote($this->rDelim) . "(.+?)". preg_quote($this->lDelim) . 'end loop' . preg_quote($this->rDelim) . "|s", $string, $match ) ) {
            return false;
        }
        return $match;
    }

}
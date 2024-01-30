<?php
/**
 * @package XTerminal
 * @version 0.1.0
 * @deprecated 0.0.9
 */
/*
Plugin Name: XTerminal
Plugin URI: https://rralves.dev.br/projetos/
Description: XTerminal generates a terminal emulation around your text to give it the appearance of an iOS or Linux terminal. Create a terminal with <code>[terminal][/terminal]</code>.
Author: Rudson R Alves
Version: 0.1.0
Author URI: https://rralves.dev.br
Original Plugin Name: Blog Terminal
Original Plugin URI: https://radeksprta.eu/projects/terminal
Original Description: Terminal generates a box around your text to give it the appearance of a terminal such as xterm or cmd. Create a terminal with <code>[terminal][/terminal]</code>.
Original Author: Radek Sprta
Original Version: 0.2.1
Original Author URI: https://radeksprta.eu
*/

#  This is free software; you can redistribute it and/or modify it under
#  the terms of the GNU General Public License as published by the Free
#  Software Foundation; either version 2 of the License, or (at your option)
#  any later version.
#
#  It is distributed in the hope that it will be useful, but WITHOUT ANY
#  WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
#  FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
#  details.
#
#  You should have received a copy of the GNU General Public License along
#  with this software, if not, write to the Free Software Foundation, Inc.,
#  59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
#

// Add [terminal] shortcode.
// Syntax [terminal user="user" computer="computer" cwd="null"]
add_shortcode( 'terminal', array( 'Terminal', 'handler' ) );

// Add styling.
add_action( 'wp_enqueue_scripts', array( 'Terminal', 'register_styles' ));

/**
 * Contain the Terminal plugin.
 */
class Terminal
{
   /**
     * Get the terminal prompt based on the provided attributes.
     *
     * @param array $atts Array of terminal attributes.
     * @return string The formatted terminal prompt.
     */
    public static function get_prompt($atts) {
        $user_color_class = $atts['user'] == 'root' ? 'user-root' : 'user-normal';

        $user_span = "<span class='{$user_color_class}'>{$atts['user']}</span>";
        $computer_span = "<span class='{$user_color_class}'>{$atts['computer']}</span>";
        // Here we set the cwd to '~' if it's not provided
        $cwd = isset($atts['cwd']) && !empty($atts['cwd']) ? $atts['cwd'] : "~";
        $cwd_span = "<span class='cwd'>{$cwd}</span>";
        // The prompt will always include the cwd
        $prompt = "{$user_span}@{$computer_span}:{$cwd_span}$ ";

        return $prompt;
    }

    /**
     * Create formatted terminal output based on the provided commands and attributes.
     *
     * @param array $commands Array of terminal commands.
     * @param string $prompt The terminal prompt.
     * @param string $title The title of the terminal.
     * @param string $style The style of the terminal.
     * @return string The formatted terminal output.
     */
    public static function make_terminal($commands, $prompt, $title, $style) {
        // Add the title to the terminal header
        $output = "\n<div class=\"terminal {$style}\">"; // Add the style class to the terminal
        $output .= "<div class=\"terminal-header\"><span class=\"terminal-title\">{$title}</span></div>";
        $output .= "<pre><code>";

        foreach ( $commands as $command ) {
            $output .= rtrim( str_replace( "$ ", $prompt, $command ) );
        }

        $output .= "</code></pre></div>\n";
        return $output;
    }
    
   /**
     * Register the necessary CSS styles for the terminal.
     */
    public static function register_styles()
    {
        wp_register_style( 'terminal', plugins_url( 'blog-terminal/style/terminal.css' ) );
        wp_enqueue_style( 'terminal' );
    }

    /**
     * Split the code into lines for processing.
     *
     * @param string $code The terminal code.
     * @return array The code split into lines.
     */
    public static function split_lines( $code )
    {
        return explode( "\n|\r\n", $code );
    }

    /**
     * Handler for the [terminal] shortcode.
     *
     * @param array $atts Attributes of the [terminal] shortcode.
     * @param string $content Content of the [terminal] shortcode.
     * @return string The formatted terminal output.
     */
    public static function handler( $atts, $content=null )
    {
        $a = shortcode_atts( array(
            'user' => 'user',
            'computer' => 'computer',
            'cwd' => null,
            'title' => 'Bash',
            'style' => 'ios',
        ), $atts );
        
        // Validate the 'style' attribute to ensure it is a valid option.
        $valid_styles = array('ios', 'linux');
        if (!in_array($a['style'], $valid_styles)) {
            $a['style'] = 'ios';
        }

        $prompt = Terminal::get_prompt( $a );
        $commands = Terminal::split_lines( $content );

        return Terminal::make_terminal( $commands, $prompt, $a['title'], $a['style'] );
    }
}
?>

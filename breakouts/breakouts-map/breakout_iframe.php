<!-- custom shortcode template sections

    [breakout_iframe iframe_src="iframe_src"][/breakout_iframe]

-->

<?php
    function breakout_iframe_shortcode($atts, $content = null) {
        $atts = shortcode_atts([
            'iframe_src' => '',
            'iframe_title' => '',
        ], $atts);

        ob_start();
        ?>
        <div class="breakout p-0">
            <iframe style="border: 0;"
                    title="<?php echo $atts['iframe_title']; ?>" 
                    src="<?php echo esc_url($atts['iframe_src']); ?>"  
                    width="100%" 
                    height="400" 
                    allowfullscreen="allowfullscreen">
            </iframe>
        </div>
        <?php
        return ob_get_clean();
    }

    add_shortcode('breakout_iframe', 'breakout_iframe_shortcode');
?>






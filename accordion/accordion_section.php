<!-- custom shortcode template sections

[accordion_section title="{{title}}"]

<p>{{content}}</p>

[/accordion_section]

-->

<?php

function accordion_section_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'title' => '',
    ], $atts);

    ob_start();
    ?>
    
    <div class="accordion ">
        <?php if (!empty($atts['title'])): ?>
            <?php echo esc_html($atts['title']); ?>
        <?php endif; ?>
    </div>

    <div class="panel">
        <div class="inner">               
            <?php if (!empty($content)): ?>
                <?php echo do_shortcode($content); ?>
            <?php endif; ?>
        </div>
    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('accordion_section', 'accordion_section_shortcode');

?>
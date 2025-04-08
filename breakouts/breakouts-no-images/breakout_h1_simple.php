<!-- custom shortcode template sections

[breakout_h1_simple sub_title="{{sub_title}}" title="{{title}}" wrapper="sm,md,lg"] 

<p>{{content}}</p> 

[/breakout_h1_simple]

-->

<?php

function breakout_h1_simple($atts, $content = null)
{
    $atts = shortcode_atts([
        'sub_title' => '',
        'title' => '',
        'wrapper' => 'md'
    ], $atts);

    ob_start();
    ?>
    <div class="breakout text-center dk invert">

        <?php if ($atts['wrapper'] === 'sm'): ?>
            <div class="small-wrapper">
            <?php elseif ($atts['wrapper'] === 'md'): ?>
                <div class="medium-wrapper">
                <?php elseif ($atts['wrapper'] === 'lg'): ?>
                    <div class="large-wrapper">
                    <?php else: ?>
                        <div class="medium-wrapper">
                        <?php endif; ?>

                        <?php if (!empty($atts['sub_title'])): ?>
                            <b class="spaced mb-4"><?php echo esc_html($atts['sub_title']); ?></b>
                        <?php endif; ?>

                        <?php if (!empty($atts['title'])): ?>
                            <h1><?php echo esc_html($atts['title']); ?></h1>
                        <?php endif; ?>

                        <?php if (!empty($content)): ?>
                            <?php echo do_shortcode($content); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                return ob_get_clean();
}

add_shortcode('breakout_h1_simple', 'breakout_h1_simple');

?>